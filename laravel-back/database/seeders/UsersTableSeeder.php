<?php

namespace Database\Seeders;

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
        \DB::table('users')->insert([
            'name'=>"Ognjen",
            'email'=>"on20170077@student.fon.bg.ac.rs",
            'password'=>bcrypt("komplet")
        ]);
    }
}
