<?php

use App\User;
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
    	User::truncate();

    	User::create([
    		'name'  => 'Jayonta Sarkar',
    		'username'  => 'jayonta',
    		'phone'     => '01744-520025',
    		'address'   => 'Tajmohol Road, Mohammadpur, Dhaka-1207',
    		"password"  => 'password',
    		'type'      => 'administrator',
    		'active'    => 1
    	]);

        factory(User::class, 10)->create();
    }
}
