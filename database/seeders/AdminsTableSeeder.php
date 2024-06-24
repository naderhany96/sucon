<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $admin1 = Admin::create([
            'email' => 'super_admin@admin.com',
            'name' => 'superAdmin',
            'mobile_phone' => '01010000000',
            'password' => Hash::make('123456'),
            'isActive' => 1,
            'isSuperAdmin' => 1,
        ]);

        $permissions = [
            "access_admin",
            "add_admin",
            "view_admin",
            "edit_admin",
            "delete_admin",
            "active_admin",
            "admin_permissions",

            "access_patient",
            "add_patient",
            "view_patient",
            "edit_patient",
            "delete_patient",

            "access_doctor",
            "add_doctor",
            "view_doctor",
            "edit_doctor",
            "delete_doctor",

            "access_qualification",
            "add_qualification",
            "view_qualification",
            "edit_qualification",
            "delete_qualification",

            "access_age_group",
            "add_age_group",
            "view_age_group",
            "edit_age_group",
            "delete_age_group",

            "access_speaking_language",
            "add_speaking_language",
            "view_speaking_language",
            "edit_speaking_language",
            "delete_speaking_language",

            "access_specialty",
            "add_specialty",
            "view_specialty",
            "edit_specialty",
            "delete_specialty",

            "access_working_style",
            "add_working_style",
            "view_working_style",
            "edit_working_style",
            "delete_working_style",

            "access_app",
        ];

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $admin1->givePermissionTo($permissions);

    }
}
