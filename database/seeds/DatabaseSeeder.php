<?php

use App\Hebergements;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorieSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(HebergementTableSeeder::class);
        $this->call(RestaurantTableSeeder::class);
        $this->call(CultureTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(ShoppingTableSeeder::class);
        $this->call(LoisirTableSeeder::class);
    }
}
