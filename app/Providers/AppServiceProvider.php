<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Page;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $apps = App::whereNotNull('approved_at')->get()->map(function (App $app)
            {
               return [
                   'text' => '',
                   'url' => '/'.$app['name'],
                   'icon' => $app['icon'],
                   'topnav' => true
               ]; 
            });

            $event->menu->add(...$apps);

            $pages = App::firstWhere(['name' => request()->segment(1)])->pages()->where(['type' => 'submenu'])->get()->map(function (Page $page)
            {
                return [
                    'text' => $page['name'],
                    'url' => $page->buildUrl(),
                    'icon' => $page['icon']
                ];
            });
            $event->menu->add(...$pages);

            

        });
    }
}
