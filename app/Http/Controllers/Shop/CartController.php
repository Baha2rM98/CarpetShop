<?php

namespace App\Http\Controllers\Shop;

use App\Cart;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Shows shopping bag index
     *
     * @return Factory|View
     */
    public function getCart()
    {
        $menus = Category::all();
        $cart = Session::get('cart');
        return view('shop.cart.index', compact('menus', 'cart'));
    }

    /**
     * Adds a product to session
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('photos')->whereId($id)->first();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
        return back();
    }

    /**
     * Removes a product from a session
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function removeItem(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $cart->remove($product, $product->id);
        $request->session()->put('cart', $cart);
        return back();
    }
}
