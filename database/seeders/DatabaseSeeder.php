<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SessionSeeder;
use Database\Seeders\YOERangeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $this->call(CategorySeeder::class);

        $this->call(WorkingStyleSeeder::class);
        $this->call(SpeakingLanguageSeeder::class);
        $this->call(SpecialtySeeder::class);
        $this->call(QualificationSeeder::class);
        $this->call(AgeGroupSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(AdminsTableSeeder::class);
        $this->call(AppSettingsTableSeeder::class);

        $this->call(AddCategoriesPermissionsToAdmin::class);
        $this->call(PriceRangeSeeder::class);
        $this->call(SessionRangeSeeder::class);
        $this->call(YOERangeSeeder::class);
        $this->call(SessionSeeder::class);
        $this->call(TimeZoneSeeder::class);
    }
}
