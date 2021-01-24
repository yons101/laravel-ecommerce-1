<?php

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = $this->getFaker();

        //create categories
        DB::table('categories')->insert(
            [
                [
                    'title' => 'iphone',
                    'slug' => 'iphone',
                    'description' => "The iPhone is a line of smartphones designed and marketed by Apple Inc",
                    'image' => "/img/iphone.png"
                ],
                [
                    'title' => 'ipad',
                    'slug' => 'ipad',
                    'description' => "iPad is a line of tablet computers designed, developed and marketed by Apple Inc., which run the iOS and iPadOS mobile operating systems.",
                    'image' => "/img/ipad.png"
                ],
                [
                    'title' => 'macbook',
                    'slug' => 'macbook',
                    'description' => "The MacBook is a brand of Macintosh laptop computers designed and marketed by Apple Inc. that use Apple's macOS operating system.",
                    'image' => "/img/macbook.png"
                ],
            ]
        );

        //create products
        for ($i = 0; $i < 50; $i++) {
            $title = Arr::random(['iphone-x', 'iphone-xs', 'iphone-11']);
            DB::table('products')->insert(
                [
                    [
                        'title' => $title,
                        'slug' => "$title-" . $faker->randomNumber(4),
                        'price' => $faker->numberBetween(30, 100) * 100,
                        'description' => $faker->text(500),
                        'image' => "/img/" . $title . ".png",
                        'category_id' => 1,
                    ]
                ]
            );
            $title = Arr::random(['ipad-air', 'ipad-pro']);

            DB::table('products')->insert(
                [
                    [
                        'title' => $title,
                        'slug' => "$title-" . $faker->randomNumber(4),
                        'price' => $faker->numberBetween(30, 100) * 100,
                        'description' => $faker->text(500),
                        'image' => "/img/" . $title . ".png",
                        'category_id' => 2,
                    ]
                ]
            );
            $title = Arr::random(['macbook-pro', 'macbook-air']);

            DB::table('products')->insert(
                [
                    [
                        'title' => $title,
                        'slug' => "$title-" . $faker->randomNumber(4),
                        'price' => $faker->numberBetween(30, 100) * 100,
                        'description' => $faker->text(500),
                        'image' => "/img/" . $title . ".png",
                        'category_id' => 3,
                    ]
                ]
            );
        }

        //create users
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

        //create carts
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

    public function getFaker()
    {
        if (empty($this->faker)) {
            $faker = Faker::create();
        }
        return $this->faker = $faker;
    }
}
