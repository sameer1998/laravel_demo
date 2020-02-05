<?php

use Illuminate\Database\Seeder;

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
            'name' => Str::random(10),
            'mobile' => rand(1111111111,9999999999),
            'type' => 'user',
            'email' => Str::random(10).'@gmail.com',
            'api_token' => str::random(40),
            'password' => bcrypt('123456'),
        ]);
    }
}
