<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ShopHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $products = Product::orderByDesc('created_at')->get();
        $categories = Category::orderByDesc('created_at')->get();

        return view('frontend.home.index', compact('products', 'categories'));
    }
}
