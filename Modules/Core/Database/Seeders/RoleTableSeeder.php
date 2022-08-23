<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // DB::table('roles')->insert([
        //     'name' => 'CORE-MEGAPPOLIS',
        //     'description' => 'Megappolis Core Role',
        // ]);
    }
}
