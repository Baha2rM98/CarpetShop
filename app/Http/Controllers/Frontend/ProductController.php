<?php

namespace App\Http\Controllers\Frontend;

use App\AttributeGroup;
use App\Category;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class ProductController extends Controller
{
    use Helper;

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
     * Returns categories with related products
     *
     * @param  int  $id
     * @return Factory|View
     * @see apiVueJsGetProductsByCategory
     * @see apiVueJsGetSortedProductsByCategory
     * @see apiVueJsGetCategoryAttribute
     * @see apiVueJsGetFilteredProducts
     */
    public function getProductsByCategory($id)
    {
        $category = Category::findOrFail($id);

        // We get products by their categories by api vus js

        return view('frontend.categories.index', compact('category'));
    }

    /*
    |--------------------------------------------------------------------------
    | API Controllers
    |--------------------------------------------------------------------------
    |
    | Here is where we registered API controller for our application
    */

    /**
     * Returns related product by their categories
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function apiVueJsGetProductsByCategory($id)
    {
        $products = Product::with('photos')->whereHas('categories', function ($query) use ($id) {
            $query->where('categories.id', $id);
        })->paginate(10);

        $baseUrl = URL::to('/');

        return response()->json(['products' => $products, 'url' => $baseUrl], 200);
    }

    /**
     * Returns related sorted product by their categories
     *
     * @param  int  $id
     * @param  string  $sort
     * @return JsonResponse
     */
    public function apiVueJsGetSortedProductsByCategory($id, $sort)
    {
        if ($sort === 'default') {
            $products = Product::with('photos')->whereHas('categories', function ($query) use ($id) {
                $query->where('categories.id', $id);
            })->paginate(10);

            return response()->json(['products' => $products]);
        }

        $products = Product::with('photos')->whereHas('categories', function ($query) use ($id) {
            $query->where('categories.id', $id);
        })->orderBy('price', $sort)->paginate(10);

        return response()->json(['products' => $products], 200);
    }

    /**
     * Returns attribute groups and values for specified category
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function apiVueJsGetCategoryAttribute($id)
    {
        $attributeGroups = AttributeGroup::with('attributeValues')
            ->whereHas('categories', function ($query) use ($id) {
                $query->where('categories.id', $id);
            })->get();

        return response()->json(['attributeGroups' => $attributeGroups], 200);
    }

    /**
     * Returns filtered products
     *
     * @param  int  $id
     * @param  string  $attributes
     * @param  string  $sort
     * @return JsonResponse
     */
    public function apiVueJsGetFilteredProducts($id, $attributes, $sort)
    {
        $attributes = json_decode($attributes, true);

        if ($attributes === [] || $this->isAllValuesNull($attributes)) {
            return $this->apiVueJsGetSortedProductsByCategory($id, $sort);
        }

        if ($sort === 'default') {
            $products = Product::with('photos')
                ->whereHas('categories', function ($query) use ($id) {
                    $query->where('categories.id', $id);
                })->whereHas('attributeValues', function ($query) use ($attributes) {
                    $query->whereIn('attribute_value_id', $attributes);
                })
                ->paginate(10);

            return response()->json(['products' => $products], 200);
        }

        $products = Product::with('photos')
            ->whereHas('categories', function ($query) use ($id) {
                $query->where('categories.id', $id);
            })->whereHas('attributeValues', function ($query) use ($attributes) {
                $query->whereIn('attribute_value_id', $attributes);
            })
            ->orderBy('price', $sort)->paginate(10);

        return response()->json(['products' => $products], 200);
    }
}
