<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //$this->call(RoleTableSeeder::class);
        //$this->call(RoleUserTableSeeder::class);
        //$this->call(AppTableSeeder::class);
        //$this->call(ModuleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
    }
}
