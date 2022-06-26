<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Module;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            $apps = App::whereRelation('transactions', 'value', 'approved')
                ->whereRelation('transactions','value', '!=', 'rejected')
                ->get()
                ->map(function (App $app)
            {
               return [
                   'text' => $app->name,
                   'url' => '/'.$app['name'],
                   'icon' => $app['icon'],
                   'topnav' => true
               ];
            });

            $event->menu->add(...$apps);

            $app = request()->segment(1);
            if ($app != null) {
                $app = App::where('name', $app)->first();
                $modules = Module::where(['type' => 'module', 'app_id' => $app->id])->get()
                ->map(function (Module $module)
                {
                    $menu = [
                        'text' => $module['name'],
                        'icon' => $module['icon'],
                        'url' => $module->buildUrl(),
                    ];

                    $submenus = Module::where(['type' => 'access', 'module_id' => $module['id']])
                    ->orWhere(['type' => 'submodule', 'module_id' => $module['id']])->get()
                    ->map(function (Module $module)
                    {
                        return [
                            'text' => $module['name'],
                            'icon' => $module['icon'],
                            'url' => $module->buildUrl(),
                        ];
                    })->toArray();
                    if (count($submenus) > 0) {
                        $menu['submenu'] = $submenus;
                    }
                    return $menu;
                })->toArray();

                $event->menu->add(...$modules);
            }
        });
    }
}
