<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DetailsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('details')->insert([
            [
                'keyword' => 'aboutus', 
                'th_name' => null, 
                'en_name' => null, 
                'th_description' => 'test', 
                'en_description' => 'test', 
                'amount' => null,
                'path' => null, 
            ],[
                'keyword' => 'stat-Projects', 
                'th_name' => 'PROJECTS', 
                'en_name' => 'PROJECTS', 
                'th_description' => null, 
                'en_description' => null, 
                'amount' => null,
                'path' => null, 
            ],[
                'keyword' => 'stat-Devices', 
                'th_name' => 'DEVICES', 
                'en_name' => 'DEVICES', 
                'th_description' => null, 
                'en_description' => null, 
                'amount' => 0,
                'path' => null, 
            ],[
                'keyword' => 'stat-Areas', 
                'th_name' => 'AREAS', 
                'en_name' => 'AREAS', 
                'th_description' => null, 
                'en_description' => null, 
                'amount' => 0,
                'path' => null, 
            ],[
                'keyword' => 'stat-Members', 
                'th_name' => 'MEMBERS', 
                'en_name' => 'MEMBERS', 
                'th_description' => null, 
                'en_description' => null, 
                'amount' => null,
                'path' => null, 
            ],[
                'keyword' => 'address', 
                'th_name' => null, 
                'en_name' => null, 
                'th_description' => 'OASYS LAB', 
                'en_description' => 'OASYS LAB', 
                'amount' => null,
                'path' => null, 
            ],[
                'keyword' => 'email', 
                'th_name' => null, 
                'en_name' => null, 
                'th_description' => 'admin@oasyslab.com', 
                'en_description' => 'admin@oasyslab.com', 
                'amount' => null,
                'path' => null, 
            ],[
                'keyword' => 'tel', 
                'th_name' => null, 
                'en_name' => null, 
                'th_description' => '053-942074', 
                'en_description' => '053-942074', 
                'amount' => null,
                'path' => null, 
            ],[
                'keyword' => 'facebook', 
                'th_name' => null, 
                'en_name' => null, 
                'th_description' => 'OASYS Research Group, วิศวะ มช.', 
                'en_description' => 'OASYS Research Group, วิศวะ มช.', 
                'path' => 'https://www.facebook.com/OASYSResearch/', 
                'amount' => null,
            ],
        ]);

        DB::table('details')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

    }
}