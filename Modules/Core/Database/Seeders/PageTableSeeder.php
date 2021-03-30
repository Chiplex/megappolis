<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // DB::table('pages')->insert([
        //     'app_id' => '1',
        //     'controller' => 'user',
        //     'action' => 'index',
        //     'name' => 'Lista de Usuarios',
        //     'type' => 'submenu',
        //     'state' => 'A',
        //     'page_id' => 0,
        // ]);

        // DB::table('pages')->insert([
        //     'app_id' => '1',
        //     'controller' => 'role',
        //     'action' => 'index',
        //     'name' => 'Lista de Roles',
        //     'type' => 'submenu',
        //     'state' => 'A',
        //     'page_id' => 0,
        // ]);

        // DB::table('pages')->insert([
        //     'app_id' => '1',
        //     'controller' => 'role',
        //     'action' => 'user',
        //     'name' => 'Lista de Roles',
        //     'type' => 'page',
        //     'state' => 'A',
        //     'page_id' => 2,
        // ]);

        // DB::table('pages')->insert([
        //     'app_id' => '1',
        //     'controller' => 'page',
        //     'action' => 'index',
        //     'name' => 'Lista de Paginas',
        //     'type' => 'submenu',
        //     'state' => 'A',
        //     'page_id' => 2,
        // ]);

        DB::table('pages')->insert([
            'app_id' => '1',
            'controller' => 'page',
            'action' => 'register',
            'name' => 'Registro de Paginas',
            'type' => 'page',
            'state' => 'A',
            'page_id' => 0,
        ]);

        DB::table('pages')->insert([
            'app_id' => '1',
            'controller' => 'permission',
            'action' => 'index',
            'name' => 'Lista de Permisos',
            'type' => 'submenu',
            'state' => 'A',
            'page_id' => 0,
        ]);
    }
}
