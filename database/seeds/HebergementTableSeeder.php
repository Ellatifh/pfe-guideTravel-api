<?php

use App\Endroits;
use App\Hebergements;
use App\Media;
use Illuminate\Database\Seeder;

class HebergementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $reference = "HEB-".$i."-RBT".$faker->buildingNumber;
            Endroits::create([
                'reference' => $reference,
                'name' => $faker->company,
                'description' => $faker->text(20),
                'adresse1' =>$faker->address ,
                'adresse2' =>$faker->address ,
                'email' => $faker->companyEmail,
                'telephone' => $faker->phoneNumber,
                'website' => $faker->url,
                'startTime' => $faker->time('H:i:s','now'),
                'endTime' => $faker->time('H:i:s','now'),
                'zipcode' => $faker->buildingNumber ,
                'longitude' => $faker->longitude,
                'latitude' => $faker->latitude,
                'categorie_id' =>1,
                'city_id' =>$faker->numberBetween(1,5),
                'user_id' => $faker->numberBetween(1,5),
            ]);
            Hebergements::create([
                'endroits_reference' => $reference,
                'ranking' => $faker->numberBetween(1, 5),
                'wifi' => $faker->boolean(50),
                'piscine' => $faker->boolean(50),
                'restaurant' => $faker->boolean(50),
                'spa' => $faker->boolean(50),
                'fitness' => $faker->boolean(50),
                'rooms' => $faker->boolean(50)
            ]);

            for($j=0;$j<5;$j++){
                Media::create([
                    'endroits_reference' => $reference,
                    'path' => $faker->imageUrl(250, 250, 'cats', true, 'Faker', true),
                    'type' => 'image'
                ]);
            }
        }
    }
}
