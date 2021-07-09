<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            [
                'keyword' => 'bg-main1', 
                'code' => '#75BBDC', 
            ],[
                'keyword' => 'bg-main2', 
                'code' => '#FCCC00', 
            ],[
                'keyword' => 'bg-main3', 
                'code' => '#555', 
            ],[
                'keyword' => 'bg-main4', 
                'code' => '#000', 
            ],[
                'keyword' => 'color-main1', 
                'code' => '#FFF', 
            ],[
                'keyword' => 'color-main2', 
                'code' => '#333', 
            ],[
                'keyword' => 'color-main3', 
                'code' => '#FFF', 
            ],[
                'keyword' => 'color-main4', 
                'code' => '#FFF', 
            ],[
                'keyword' => 'color-main5', 
                'code' => '#FCCC00', 
            ],[
                'keyword' => 'color-main6', 
                'code' => '#75BBDC', 
            ],[
                'keyword' => 'filter', 
                'code' => '#75BBDC33', 
            ]
        ]);

        DB::table('colors')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
