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

        $permissions = [
            [
                'role_id' => 1,
                'module_id' => 12,
                'name' => 'view',
            ],
            [
                'role_id' => 1,
                'module_id' => 13,
                'name' => 'view',
            ],
        ];
        DB::table('permissions')->insert($permissions);
    }
}
