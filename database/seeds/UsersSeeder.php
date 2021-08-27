<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersSeeder extends Seeder
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
            	'name' => 'Sajad Shafizadeh',
            	'email' => 'test@test.com',
            	'password' => '$2y$10$tTNU8X114s5cd9CFmKpjjuOu9XvbafQln.y0611ukbZmq6MXAPevC',
            	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
