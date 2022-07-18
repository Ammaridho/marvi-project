<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $data = [
            // product 1
            [
                'name'      => 'admin',
                'email'     => 'admin@gmail.com',
                'password'  =>  bcrypt('admin'),
            ],
            
            
        ];

        DB::table('users')->insert($data);
    }
}
