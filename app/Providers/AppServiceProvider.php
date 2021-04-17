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

            $app = App::firstWhere(['name' => request()->segment(1)]);
            $pages = Page::where(['type' => 'menu', 'app_id' => $app->id])->get()->map(function (Page $page)
            {
                $menu = [
                    'text' => $page['name'],
                    'icon' => $page['icon'],
                    'url' => $page->buildUrl(),
                ];
                $submenus = Page::where(['type' => 'submenu', 'page_id' => $page['id']])->get()->map(function (Page $page)
                {
                    return [
                        'text' => $page['name'],
                        'icon' => $page['icon'],
                        'url' => $page->buildUrl(),
                    ];
                })->toArray();
                if (count($submenus) > 0) {
                    $menu['submenu'] = $submenus;
                }
                return $menu;
            })->toArray();

            $event->menu->add(...$pages);
        });
    }
}
