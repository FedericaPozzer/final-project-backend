<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Array di tipi di cucina */
        $names=["Italiano", "Cinese", "Messicano", "Giapponese", "Indiano", "Americano", "Spagnolo",];

        /* Creo un nuovo oggetto Tipo per ogni elemento nell'array */

        $type = new Type;
        $type->name = 'Italiano';
        $type->image = 'https://img.icons8.com/plasticine/100/pizza.png';
        $type->save();

        $type = new Type;
        $type->name = 'Cinese';
        $type->image = 'https://img.icons8.com/plasticine/100/chinese-noodle.png';
        $type->save();

        $type = new Type;
        $type->name = 'Messicano';
        $type->image = 'https://img.icons8.com/plasticine/100/taco.png';
        $type->save();

        $type = new Type;
        $type->name = 'Giapponese';
        $type->image = 'https://img.icons8.com/plasticine/100/sushi.png';
        $type->save();

        $type = new Type;
        $type->name = 'Indiano';
        $type->image = 'https://img.icons8.com/plasticine/100/curry.png';
        $type->save();

        $type = new Type;
        $type->name = 'Americano';
        $type->image = 'https://img.icons8.com/plasticine/100/hamburger.png';
        $type->save();

        $type = new Type;
        $type->name = 'Spagnolo';
        $type->image = 'https://img.icons8.com/plasticine/100/paella.png';
        $type->save();
    }

}
