<?php

use Illuminate\Database\Seeder;

class ResetUserSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email','admin@gmail.com')->delete();

        $data = [
            // product 1
            [
                'name'      => 'admin',
                'email'     => 'admin@gmail.com',
                'password'  =>  bcrypt('admin'),
                'role'      => 'superadmin'
            ],
            
            
        ];

        DB::table('users')->insert($data);
    }
}
