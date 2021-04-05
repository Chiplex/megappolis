<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // DB::table('permissions')->insert([
        //     'role_id' => '1',
        //     'page_id' => '1',
        //     'name' => 'view',
        // ]);

        // DB::table('permissions')->insert([
        //     'role_id' => '1',
        //     'page_id' => '2',
        //     'name' => 'view',
        // ]);

        // DB::table('permissions')->insert([
        //     'role_id' => '1',
        //     'page_id' => '3',
        //     'name' => 'view',
        // ]);

        // DB::table('permissions')->insert([
        //     'role_id' => '1',
        //     'page_id' => '4',
        //     'name' => 'view',
        // ]);

        DB::table('permissions')->insert([
            'role_id' => '1',
            'page_id' => '1',
            'name' => 'view',
        ]);

        DB::table('permissions')->insert([
            'role_id' => '1',
            'page_id' => '2',
            'name' => 'view',
        ]);
    }
}
