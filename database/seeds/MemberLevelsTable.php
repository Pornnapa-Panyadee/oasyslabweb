<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MemberLevelsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members_levels')->insert([
            [
                'name_th' =>  'ปริญญาตรี',
                'name_en' => "Bachelor's Degree",
            ],
            [
                'name_th' =>  'ปริญญาโท',
                'name_en' => "Master's Degree",
            ],
            [
                'name_th' =>  'ปริญญาเอก',
                'name_en' => "Doctor's Degree",
            ],

        ]);
        DB::table('members_levels')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
