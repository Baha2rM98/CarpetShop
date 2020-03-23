<?php

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
        factory(\App\Product::class, 3)->create()->each(function ($product) {
            $product->categories()->sync([1]);
            $product->attributeValues()->sync([1, 2, 3]);
            $product->photos()->sync([10]);
        });
    }
}
