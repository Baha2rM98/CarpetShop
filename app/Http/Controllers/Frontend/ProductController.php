<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Returns a product, its features and its related products
     *
     * @param  string  $slug
     * @return Factory|View
     */
    public function getProduct($slug)
    {
        $product = Product::with('brand', 'attributeValues.attributeGroup', 'photos')
            ->whereSlug($slug)->first();
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories);
            })->get();
        return view('frontend.products.index', compact('product', 'relatedProducts'));
    }
}
