<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 50)->create()->each(function ($product) {
            $product->photos()->attach($this->randomArray());
            $product->categories()->attach($this->randomArray());
            $product->attributeValues()->attach($this->randomArray());
        });
    }

    /**
     * Generates random numbers in an array
     *
     * @return array
     */
    private function randomArray()
    {
        $result = [];
        for ($i = 0; $i < 50; $i++) {
            array_push($result, mt_rand(1, 50));
        }

        return $result;
    }
}
