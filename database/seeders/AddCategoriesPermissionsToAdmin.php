<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class AddCategoriesPermissionsToAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $admin1 = Admin::find(1);

        $permissions = [
            "access_category",
            "add_category",
            "view_category",
            "edit_category",
            "delete_category",
        ];

        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('optimize:clear');

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $admin1->givePermissionTo($permissions);

    }
}
