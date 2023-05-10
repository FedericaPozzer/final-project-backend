<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Restaurant;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\it_IT\Restaurant($faker));

        for($i=0; $i<20; $i++) {

            $dish = new Dish;
            $dish->name = $faker->foodName();
            $dish->in_stock = $faker->randomDigit();
            $dish->description = $faker->sentence(8);
            $dish->price = $faker->randomFloat(2, 3, 10);
            $dish->save();

            $dish->restaurant()->associate(Restaurant::all()->random(1)->first());
            $dish->save();

        }
    }
}
