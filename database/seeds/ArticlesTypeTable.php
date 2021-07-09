<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticlesTypeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles_type')->insert([
            [
                'type' => 'news', 
            ],
            [
                'type' => 'article', 
            ],
        ]);

        DB::table('articles_type')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

    }
}
