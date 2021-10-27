<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Page;

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

            $module = request()->segment(1);
            if ($module != null) {
                $app = App::firstWhere(['name' => $module]);
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
            }
        });
    }
}
