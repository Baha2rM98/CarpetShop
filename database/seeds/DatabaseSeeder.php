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
        $this->call(AdminsTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
//        $this->call(CategoriesTableSeeder::class);
//        $this->call(AttributeGroupsTableSeeder::class);
//        $this->call(AttributeValuesTableSeeder::class);
//        $this->call(PhotosTableSeeder::class);
//        $this->call(BrandsTableSeeder::class);
//        $this->call(ProductsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
