<?php

use Illuminate\Support\Arr;
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

        DB::table('categories')->insert(
            [
                [
                    'title' => 'iphone',
                    'slug' => 'iphone',
                    'description' => 'iphone description',
                    'image' => "/img/iphone.png"
                ],
                [
                    'title' => 'ipad',
                    'slug' => 'ipad',
                    'description' => 'ipad description',
                    'image' => "/img/ipad.png"
                ],
                [
                    'title' => 'macbook',
                    'slug' => 'macbook',
                    'description' => 'macbook description',
                    'image' => "/img/macbook.png"
                ],
            ]
        );


        $this->call(ProductSeeder::class);

        DB::table('users')->insert(
            [
                [
                    'username' => 'admin',
                    'password' => '$2y$10$QLDao84rqm4wPIXlWcI6au2lIX4XVgvrSxxYY5KFgonHr6JDpuy6S',
                    'email' => 'admin@gmail.com',
                    'fullname' => 'admin admin',
                    'phone' => '0633221144',
                    'role' => 'admin',
                ],
                [
                    'username' => 'test1',
                    'password' => '$2y$10$N57RXskaiaQzgnBTVCwOfOj3oDsfOSJQQp/kKD1WDCYi5FX6K3Daq',
                    'email' => 'test1@gmail.com',
                    'fullname' => 'Ahmed Hamada',
                    'phone' => '0606330508',
                    'role' => 'user',
                ],
                [
                    'username' => 'test2',
                    'password' => '$2y$10$SEAIo7Qo/XSNT/GD9Tym/OT7HlZ9bqsLRK3YWICJCZKoQvaZUSVay',
                    'email' => 'test2@gmail.com',
                    'fullname' => 'Said Saada',
                    'phone' => '0633221144',
                    'role' => 'user',
                ]
            ]
        );

        DB::table('carts')->insert(
            [
                [
                    'user_id' => 2,
                    'product_id' => 1,
                    'quantity' => 4,
                ],
                [
                    'user_id' => 2,
                    'product_id' => 3,
                    'quantity' => 2,

                ],
                [
                    'user_id' => 1,
                    'product_id' => 3,
                    'quantity' => 2,
                ]
            ]
        );
    }
}
