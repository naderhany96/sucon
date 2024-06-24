<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // fix Spatie cache bug 
        // https://github.com/spatie/laravel-permission/issues/590
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('optimize:clear');

        Role::insert([
            ['name' => 'super_admin', 'guard_name' => 'admin'],
            ['name' => 'admin', 'guard_name' => 'admin'],
            ['name' => 'doctor', 'guard_name' => 'user'],
            ['name' => 'patient', 'guard_name' => 'user'],
        ]);
    }
}
