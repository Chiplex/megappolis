<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Entities\App;
use Modules\Core\Entities\Page;
use Modules\Core\Entities\Permission;
use App\Models\User;

class ViewController extends Controller
{
    /**
     * Display a view.
     *
     * @return Illuminate\View\View
     */
    public function show($view)
    {
        $referer = request()->headers->get('referer');
        $parseUrl = parse_url($referer, PHP_URL_PATH);
        $segments = explode('/', $parseUrl);
        if (count($segments) < 2) {
            $appName = 'main';
            $controller = $segments[1];
            $action = $segments[2];
        } else {
            $appName = $segments[1];
            $controller = $segments[2];
            $action = $segments[3];
        }

        $app = App::firstWhere(['name' => $appName]);
        $page = Page::where(['app_id'=> $app->id, 'controller' => $controller, 'action' => $action])->first();

        $permissions = "ver"; //GetPermisos($page);
        
        $result = ['result' => true, 'data' => $permissions];
        return view($app->name . '::' . $view, compact('result'))->render();
    }
}
