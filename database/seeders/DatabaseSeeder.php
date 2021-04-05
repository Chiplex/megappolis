<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\AppTableSeeder;
use Modules\Core\Database\Seeders\PageTableSeeder;
use Modules\Core\Database\Seeders\PermissionTableSeeder;
use Modules\Core\Database\Seeders\RoleTableSeeder;
use Modules\Core\Database\Seeders\RoleUserTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(RoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(AppTableSeeder::class);
        // $this->call(PageTableSeeder::class);
        // $this->call(PermissionTableSeeder::class);
    }
}
