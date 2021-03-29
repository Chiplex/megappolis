<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        DB::table('page')->insert([
            'app_id' => '1',
            'controller' => 'user',
            'action' => 'index',
            'name' => 'Lista de Usuarios',
            'type' => 'submenu',
            'page_id' => 0,
        ]);

        DB::table('page')->insert([
            'app_id' => '1',
            'controller' => 'role',
            'action' => 'index',
            'name' => 'Lista de Roles',
            'type' => 'submenu',
            'page_id' => 0,
        ]);

        DB::table('page')->insert([
            'app_id' => '1',
            'controller' => 'role',
            'action' => 'user',
            'name' => 'Lista de Roles',
            'type' => 'page',
            'page_id' => 2,
        ]);

        DB::table('page')->insert([
            'app_id' => '1',
            'controller' => 'page',
            'action' => 'index',
            'name' => 'Lista de Paginas',
            'type' => 'submenu',
            'page_id' => 2,
        ]);
    }
}
