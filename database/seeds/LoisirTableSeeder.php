<?php

use App\Endroits;
use App\Media;
use App\Loisir;
use Illuminate\Database\Seeder;

class LoisirTableSeeder extends Seeder
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
            $reference = "HOB-".$i."-".$faker->countryCode."-".$faker->buildingNumber;
            Endroits::create([
                'reference' => $reference,
                'name' => $faker->company,
                'description' => $faker->text(10),
                'adresse1' =>$faker->address,
                'adresse2' =>$faker->address,
                'email' => $faker->companyEmail,
                'telephone' => $faker->phoneNumber,
                'website' => $faker->url,
                'startTime' => $faker->time('H:i:s','now'),
                'endTime' => $faker->time('H:i:s','now'),
                'zipcode' => $faker->buildingNumber ,
                'longitude' => $faker->longitude,
                'latitude' => $faker->latitude,
                'categorie_id' =>5,
                'city_id' =>$faker->numberBetween(1,5),
                'user_id' => $faker->numberBetween(1,5)
            ]);
            Loisir::create([
                'endroits_reference' => $reference,
                'type' => $faker->text(30)
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
