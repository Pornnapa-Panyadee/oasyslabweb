<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            [
                'image_id'=>null,
                'order_no'=>1
            ],
            [
                'image_id'=>null,
                'order_no'=>2
            ],
            [
                'image_id'=>null,
                'order_no'=>3
            ],
            [
                'image_id'=>null,
                'order_no'=>4
            ],
            [
                'image_id'=>null,
                'order_no'=>5
            ],
        ]);
        DB::table('banners')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
