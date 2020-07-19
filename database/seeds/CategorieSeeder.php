<?php

use Illuminate\Database\Seeder;
use App\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorie::create(['name' => "Hebergements"]);
        Categorie::create(['name' => "Restaurants"]);
        Categorie::create(['name' => "Events"]);
        Categorie::create(['name' => "Cultures"]);
        Categorie::create(['name' => "Loisirs"]);
        Categorie::create(['name' => "Shoppings"]);
        Categorie::create(['name' => "Infos"]);


        /*$faker = \Faker\Factory::create();
        for($i=0;$i<10;$i++){
            Categorie::create([
                'name' => $faker->name
            ]);
        }*/
        // php artisan db:seed --class=CategorieSeeder
    }
}
