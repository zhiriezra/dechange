<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        User::create([
            'name' => 'Paulina Bureau',
            'email' => 'admin@paulina.com',
            'password' => bcrypt('secret123'),
            'admin' => 1

        ]);

        User::create([
     		'name' => 'Ezra Kolo',
     		'email' => 'customer@paulina.com',
     		'password' => bcrypt('secret123'),

     	]);
    }
}
