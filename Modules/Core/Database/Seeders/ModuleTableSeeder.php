<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $modules = [
            [
                'app_id' => 1,
                'controller' => 'home',
                'action' => 'index',
                'name' => 'Home',
                'type' => 'app',
                'icon' => 'fa fa-home',
                'module_id' => 0,
            ],
            [
                'app_id' => 1,
                'controller' => NULL,
                'action' => NULL,
                'name' => 'Navigation',
                'type' => 'module',
                'icon' => 'fa fa-user',
                'module_id' => 1,
            ],
            [
                'app_id' => 1,
                'controller' => 'app',
                'action' => 'index',
                'name' => 'Applications',
                'type' => 'access',
                'icon' => 'fa fa-cubes',
                'module_id' => 2,
            ],
            [
                'app_id' => 1,
                'controller' => 'app',
                'action' => 'register',
                'name' => 'Register Application',
                'type' => 'form',
                'icon' => 'fa fa-plus',
                'module_id' => 2,
            ],
            [
                'app_id' => 1,
                'controller' => 'module',
                'action' => 'index',
                'name' => 'Modules',
                'type' => 'access',
                'icon' => 'fa fa-cube',
                'module_id' => 2,
            ],
            [
                'app_id' => 1,
                'controller' => 'module',
                'action' => 'register',
                'name' => 'Register Module',
                'type' => 'form',
                'icon' => 'fa fa-plus',
                'module_id' => 2,
            ],
            [
                'app_id' => 1,
                'controller' => NULL,
                'action' => NULL,
                'name' => 'Administration',
                'type' => 'module',
                'icon' => 'fa fa-cogs',
                'module_id' => 1,
            ],
            [
                'app_id' => 1,
                'controller' => 'user',
                'action' => 'index',
                'name' => 'Users',
                'type' => 'access',
                'icon' => 'fa fa-user',
                'module_id' => 7,
            ],
            [
                'app_id' => 1,
                'controller' => 'user',
                'action' => 'register',
                'name' => 'Register User',
                'type' => 'form',
                'icon' => 'fa fa-plus',
                'module_id' => 7,
            ],
            [
                'app_id' => 1,
                'controller' => 'role',
                'action' => 'index',
                'name' => 'Roles',
                'type' => 'access',
                'icon' => 'fa fa-user-secret',
                'module_id' => 7,
            ],
            [
                'app_id' => 1,
                'controller' => 'role',
                'action' => 'register',
                'name' => 'Register Role',
                'type' => 'form',
                'icon' => 'fa fa-plus',
                'module_id' => 7,
            ],
            [
                'app_id' => 1,
                'controller' => 'permission',
                'action' => 'index',
                'name' => 'Permissions',
                'type' => 'access',
                'icon' => 'fa fa-key',
                'module_id' => 7,
            ],
            [
                'app_id' => 1,
                'controller' => 'permission',
                'action' => 'register',
                'name' => 'Register Permission',
                'type' => 'form',
                'icon' => 'fa fa-plus',
                'module_id' => 7,
            ],
        ];

        DB::table('modules')->insert($modules);
    }
}
