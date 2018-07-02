<?php

namespace Railken\LaraOre;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Railken\LaraOre\Api\Support\Router;
use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Template\TemplateManager;
use Railken\LaraOre\Work\WorkManager;

class ListenerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ore.listener.php' => config_path('ore.listener.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutes();

        config(['ore.permission.managers' => array_merge(Config::get('ore.permission.managers', []), [
            \Railken\LaraOre\Listener\ListenerManager::class,
        ])]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ore.listener.php', 'ore.listener');
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ApiServiceProvider::class);
        $this->app->register(\Railken\LaraOre\WorkServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TemplateServiceProvider::class);

        Event::listen(Config::get('ore.listener.events'), function ($event_name, $events) {
            $lm = new ListenerManager();
            $wm = new WorkManager();
            $tm = new TemplateManager();
                
            /** @var \Railken\LaraOre\Listener\ListenerRepository */
            $repository = $lm->getRepository();

            $listeners = $repository->findByEventClass($event_name);

            foreach ($listeners as $listener) {
                foreach ($events as $event) {
                    $condition = $tm->renderRaw('text/plain', $listener->condition, $event->data);
                    if ($condition === '1') {
                        $wm->dispatch($listener->work, $event->data, $listener->entities && isset($event->entities) ? $event->entities : []);
                    }
                }
            }
        });
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Router::group(Config::get('ore.listener.http.router'), function ($router) {
            $controller = Config::get('ore.listener.http.controller');
            
            $router->get('/', ['uses' => $controller . '@index']);
            $router->post('/', ['uses' => $controller . '@create']);
            $router->put('/{id}', ['uses' => $controller . '@update']);
            $router->delete('/{id}', ['uses' => $controller . '@remove']);
            $router->get('/{id}', ['uses' => $controller . '@show']);
        });
    }
}
