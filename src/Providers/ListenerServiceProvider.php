<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Managers\ListenerManager;
use Railken\Amethyst\Managers\TemplateManager;
use Railken\Amethyst\Managers\WorkManager;
use Symfony\Component\Yaml\Yaml;

class ListenerServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable(Config::get('amethyst.listener.data.listener.table'))) {
            $lm = new ListenerManager();

            $available = $lm->getAvailableEventClasses();

            Event::listen(Config::get('amethyst.listener.events'), function ($event_name, $events) use ($available) {
                if (!in_array($event_name, $available)) {
                    return true;
                }

                $lm = new ListenerManager();
                $wm = new WorkManager();
                $tm = new TemplateManager();

                /** @var \Railken\Amethyst\Repositories\ListenerRepository */
                $repository = $lm->getRepository();

                $listeners = $repository->findByEventClass($event_name);

                foreach ($listeners as $listener) {
                    foreach ($events as $event) {
                        $condition = $tm->renderRaw('text/plain', $listener->condition, $event->data);

                        $data = array_merge($event->data, Yaml::parse($tm->renderRaw('text/plain', $listener->data, $event->data)));

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
        $this->app->register(\Railken\Amethyst\Providers\WorkServiceProvider::class);

        parent::register();
    }
}
