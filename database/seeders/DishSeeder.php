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
        /* Importo FakerRestaurant IT */
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\it_IT\Restaurant($faker));

        $restaurants = Restaurant::all();
        foreach($restaurants as $restaurant)
        {

            for($i=0; $i<$faker->numberBetween(6,10); $i++) {
    
                /* Creo una descrizione con degli ingredienti */
                $ingredients = [$faker->vegetableName(), $faker->fruitName(), $faker->meatName(),  $faker->sauceName(), $faker->dairyName()];
                $description = $faker->dairyName() . ', ';
                foreach ($ingredients as $ingredient){
                    if ($faker->boolean(50)){
                        $description .= $ingredient . ', '; 
                    }
                }
    
                /* Rimuovo gli ultimi due caratteri */
                $description = substr($description,0,-2);
    
                /* Creo un nuovo piatto */
                $dish = new Dish;
                $dish->name = $faker->foodName();

                $default_images = ['restaurant_images/1.jpg', 'restaurant_images/3.jpg', 'restaurant_images/4.jpg', 'restaurant_images/5.jpg'];

                $dish->image = $default_images[$faker->numberBetween(0, 3)];


                $dish->available = $faker->boolean(80);
                $dish->description = $description;
                $dish->price = $faker->randomFloat(2, 3, 10);
                /* Salvo il piatto */
                $dish->save();
    
                /* Associo un ristoratore al piatto */
                $dish->restaurant()->associate($restaurant);
                $dish->save();
    
            }
        }
        /* Ciclo la creazione di nuovi piatti */
    }
}
