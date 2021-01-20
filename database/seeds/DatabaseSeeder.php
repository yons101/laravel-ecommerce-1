<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductSeeder::class);

        DB::table('users')->insert(
            [

                [
                    'username' => 'admin',
                    'password' => '$2y$10$QLDao84rqm4wPIXlWcI6au2lIX4XVgvrSxxYY5KFgonHr6JDpuy6S',
                    'role' => 'admin',
                ],
                [
                    'username' => 'test1',
                    'password' => '$2y$10$N57RXskaiaQzgnBTVCwOfOj3oDsfOSJQQp/kKD1WDCYi5FX6K3Daq',
                    'role' => 'user',


                ],
                [
                    'username' => 'test2',
                    'password' => '$2y$10$SEAIo7Qo/XSNT/GD9Tym/OT7HlZ9bqsLRK3YWICJCZKoQvaZUSVay',
                    'role' => 'user',

                ]
            ]
        );


        DB::table('profiles')->insert(
            [
                [
                    'fullname' => 'admin admin',
                    'phone' => '0633221144',
                    'address' => 'Rue 05, Qt X, Ville A',
                    'user_id' => 1,
                ],
                [
                    'fullname' => 'Ahmed Hamada',
                    'phone' => '0606330508',
                    'address' => 'Rue 99, Qt YY, Ville B',
                    'user_id' => 2,
                ],
                [
                    'fullname' => 'Said Saada',
                    'phone' => '0633221144',
                    'address' => 'Rue 007, Qt FFF, Ville C',
                    'user_id' => 3,
                ],
            ]
        );

        DB::table('carts')->insert(
            [
                [
                    'user_id' => 1, //admin
                    'product_id' => 1,
                ],
                [
                    'user_id' => 1, //admin
                    'product_id' => 2,
                ],
                [
                    'user_id' => 1, //admin
                    'product_id' =>3,
                ],
                [
                    'user_id' => 2,
                ],
                [
                    'user_id' => 3,
                ]
            ]
        );

      
    }
}
