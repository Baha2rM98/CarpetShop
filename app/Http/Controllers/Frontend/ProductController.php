<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
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
        $product = Product::with('brand', 'attributeValues.attributeGroup', 'photos', 'categories')
            ->whereSlug($slug)->first();
        if (is_null($product)) {
            abort(404);
        }
        $relatedProducts = Product::with('photos')->whereHas('categories', function ($query) use ($product) {
            $query->whereIn('categories.id', $product->categories);
        })->get();
        return view('frontend.products.index', compact('product', 'relatedProducts'));
    }

    /**
     * Returns Products by their categories
     *
     * @param  int  $id
     * @param  int  $page
     * @return Factory|View
     */
    public function getProductsByCategory($id, $page = 10)
    {
        $category = Category::findOrFail($id);
        $products = Product::with('photos')->whereHas('categories', function ($query) use ($category) {
            $query->where('categories.id', $category->id);
        })->paginate($page);
        $items = Category::all();

        return view('frontend.categories.index', compact('category', 'products', 'items'));
    }
}
