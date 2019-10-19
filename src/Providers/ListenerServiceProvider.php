<?php

namespace Amethyst\Providers;

use Amethyst\Common\CommonServiceProvider;
use Amethyst\Managers\ListenerManager;
use Amethyst\Managers\TemplateManager;
use Amethyst\Managers\WorkManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Yaml\Yaml;

class ListenerServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return;
        }

        if (Schema::hasTable(Config::get('amethyst.listener.data.listener.table'))) {
            $lm = new ListenerManager();

            $available = $lm->getAvailableEventClasses();

            Event::listen(Config::get('amethyst.listener.events'), function ($event_name, $events) use ($available) {
                if (!in_array($event_name, $available, true)) {
                    return true;
                }

                $lm = new ListenerManager();
                $wm = new WorkManager();
                $tm = new TemplateManager();

                /** @var \Amethyst\Repositories\ListenerRepository */
                $repository = $lm->getRepository();

                $listeners = $repository->findByEventClass($event_name);

                foreach ($listeners as $listener) {
                    foreach ($events as $event) {
                        $condition = $tm->renderRaw('text/plain', $listener->condition, ['event' => $event]);

                        $data = (array) Yaml::parse($tm->renderRaw('text/plain', $listener->data, ['event' => $event]));

                        if ($condition === '1') {
                            $wm->execute($listener->work, $data);
                        }
                    }
                }
            });
        }
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->app->register(\Amethyst\Providers\WorkServiceProvider::class);

        parent::register();
    }
}
