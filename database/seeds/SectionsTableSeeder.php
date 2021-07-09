<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
            [
                'value' => '<Banner />', 
                'name' => 'Banner', 
            ],[
                'value' => '<About />', 
                'name' => 'About', 
            ],[
                'value' => '<Project />', 
                'name' => 'Project', 
            ],[
                'value' => '<Article />', 
                'name' => 'Article', 
            ],[
                'value' => '<Members />', 
                'name' => 'Members', 
            ],[
                'value' => '<Contact />', 
                'name' => 'Contact', 
            ],[
                'value' => '<Footer />', 
                'name' => 'Footer', 
            ]
        ]);

        DB::table('sections')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
