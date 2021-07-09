<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PublicationTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publication_types')->insert([
            [
                'th_name' =>  'Journal Papers',
                'en_name' => "Journal Papers",
            ],
            [
                'th_name' =>  'Refereed Conference and Workshop Papers',
                'en_name' => "Refereed Conference and Workshop Papers",
            ],
            [
                'th_name' =>  'Refereed Poster Papers',
                'en_name' => "Refereed Poster Paperss",
            ],

        ]);
        DB::table('publication_types')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
