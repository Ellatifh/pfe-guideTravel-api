<?php

use App\Citie;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for($i=0;$i<10;$i++){
            Citie::create([
                'name' => $faker->city
            ]);
        }
        // php artisan db:seed --class=CitySeeder
    }
}
