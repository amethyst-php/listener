<?php

namespace Railken\LaraOre;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Railken\LaraOre\Api\Support\Router;
use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Template\TemplateManager;
use Railken\LaraOre\Work\WorkManager;

class ListenerServiceProvider extends ServiceProvider
{
    public $events = [];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ore.listener.php' => config_path('ore.listener.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutes();

        config(['ore.managers' => array_merge(Config::get('ore.managers', []), [
            \Railken\LaraOre\Listener\ListenerManager::class,
        ])]);

        if (Schema::hasTable(Config::get('ore.listener.table'))) {
            $lm = new ListenerManager();

            $available = $lm->getAvailableEventClasses();

            Event::listen(Config::get('ore.listener.events'), function ($event_name, $events) use ($available) {
                if (!in_array($event_name, $available)) {
                    return true;
                }

                $lm = new ListenerManager();
                $wm = new WorkManager();
                $tm = new TemplateManager();

                /** @var \Railken\LaraOre\Listener\ListenerRepository */
                $repository = $lm->getRepository();

                $listeners = $repository->findByEventClass($event_name);

                foreach ($listeners as $listener) {
                    foreach ($events as $event) {
                        $condition = $tm->renderRaw('text/plain', $listener->condition, $event->data);

                        $data = array_merge($event->data, (array) json_decode($tm->renderRaw('text/plain', (string) json_encode($listener->data), $event->data)));

                        if ($condition === '1') {
                            $wm->dispatch($listener->work, $data);
                        }
                    }
                }

                return false;
            });
        }
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ore.listener.php', 'ore.listener');
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ApiServiceProvider::class);
        $this->app->register(\Railken\LaraOre\WorkServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TemplateServiceProvider::class);
    }

    /**
     * Load routes.
     */
    public function loadRoutes()
    {
        $config = Config::get('ore.listener.http.admin');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');

                $router->get('/', ['uses' => $controller.'@index']);
                $router->post('/', ['uses' => $controller.'@create']);
                $router->put('/{id}', ['uses' => $controller.'@update']);
                $router->delete('/{id}', ['uses' => $controller.'@remove']);
                $router->get('/{id}', ['uses' => $controller.'@show']);
            });
        }
    }
}
