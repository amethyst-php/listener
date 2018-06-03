<?php

namespace Railken\LaraOre;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Work\WorkManager;
use Illuminate\Support\Facades\Config;

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

        if (!class_exists('CreateListenersTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_listeners_table.php.stub' => database_path('migrations/'.(new \DateTime())->format("Y_m_d_His.u").'_create_listeners_table.php'),
            ], 'migrations');
        }
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
        $this->app->register(\Railken\LaraOre\WorkServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TemplateServiceProvider::class);

        Event::listen(Config::get('ore.listener.events'), function ($event_name, $events) {
            $lm = new ListenerManager();
            $wm = new WorkManager();
            $listeners = $lm->getRepository()->findByEventClass($event_name);

            foreach ($listeners as $listener) {
                foreach ($events as $event) {
                    $wm->dispatch($listener->work, $event->data);
                }
            }
        });
    }
}
