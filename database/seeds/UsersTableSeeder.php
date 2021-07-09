<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' =>  'Admin Oasys',
                'email' => 'admin@oasys-lab.com',
                'password' => bcrypt('admin345'),
                'role_id' => 1,
            ],
        ]);
        DB::table('users')->update([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
