<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RolesTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(MemberLevelsTable::class);
        // $this->call(ArticlesTypeTable::class);
        // $this->call(BannersTableSeeder::class);
        // $this->call(DetailsTableSeeder::class);
        // $this->call(PublicationTypesTable::class);
        // $this->call(ColorsTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
    }
}
