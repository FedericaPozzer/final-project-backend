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

        /* Ciclo la creazione di nuovi piatti */
        for($i=0; $i<20; $i++) {

            /* Creo una descrizione con degli ingredienti */
            $ingredients = [$faker->vegetableName(), $faker->fruitName(), $faker->meatName(),  $faker->sauceName(), $faker->dairyName()];
            $description = 'Ingredienti: ' . $faker->dairyName() . ', ';
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
            $dish->available = $faker->boolean(80);
            $dish->description = $description;
            $dish->price = $faker->randomFloat(2, 3, 10);
            /* Salvo il piatto */
            $dish->save();

            /* Associo un ristoratore al piatto */
            $dish->restaurant()->associate(Restaurant::all()->random(1)->first());
            $dish->save();

        }
    }
}
