<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // DB::table('apps')->insert([
        //     'name' => 'core',
        //     'description' => 'Megappolis Core App',
        //     'type' => 'CORE',
        //     'url' => '/core',
        //     'user_id' => 1,
        // ]);
    }
}
