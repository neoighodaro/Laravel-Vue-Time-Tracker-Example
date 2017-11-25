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
        App\User::create(['email' => 'neo@creativitykills.co', 'name' => 'Neo', 'password' => bcrypt('secret')]);
    }
}
