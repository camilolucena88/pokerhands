<?php

use Illuminate\Database\Seeder;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'system',
                'email' => 'system@pokertest.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'test',
                'email' => 'camilolucena88@gmail.com',
                'password' => Hash::make('password'),
            ],
        ];
        DB::table('users')->insert($users);
    }
}
