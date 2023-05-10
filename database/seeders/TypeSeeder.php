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
        $names=["Italiano", "Cinese", "Messicano", "Giapponese", "Indiano"];

        foreach($names as $name) {
            $type = new Type;
            $type->name = $name;
            $type->save();
        }
    }

}
