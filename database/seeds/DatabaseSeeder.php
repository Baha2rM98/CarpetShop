<?php

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
        $this->call([
            AdminsTableSeeder::class,
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
            CategoriesTableSeeder::class,
            AttributeGroupsTableSeeder::class,
            AttributeValuesTableSeeder::class,
//            PhotosTableSeeder::class,
            BrandsTableSeeder::class,
//            ProductsTableSeeder::class,
            UsersTableSeeder::class,
            AddressesTableSeeder::class
        ]);
    }
}
