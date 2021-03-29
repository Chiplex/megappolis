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

        DB::table('role')->insert([
            'app_id' => '1',
            'controller' => 'user',
            'action' => 'index',
            'name' => 'Lista de Usuario',
            'page_id' => 0,
        ]);
    }
}
