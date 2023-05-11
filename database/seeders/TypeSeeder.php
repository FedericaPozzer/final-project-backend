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
        $names=["Italiano", "Cinese", "Messicano", "Giapponese", "Indiano"];

        /* Creo un nuovo oggetto Tipo per ogni elemento nell'array */
        foreach($names as $name) {
            $type = new Type;
            $type->name = $name;
            $type->img = 'prova';
            $type->save();
        }
    }

}
