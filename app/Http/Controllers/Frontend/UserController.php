<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Shows the authenticated user dashboard
     *
     * @return Factory|View
     */
    public function profile()
    {
        $menus = Category::all();
        $user = Auth::user();

        return view('frontend.dashboard.index', compact('user', 'menus'));
    }

    /**
     * Shows favorite list of user
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function getFavorites(Request $request)
    {
        $menus = Category::all();

        $products = Product::with('photos')->whereHas('users', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->paginate(10);

        return view('frontend.dashboard.favorites-list', compact('products', 'menus'));
    }

    /**
     * Adds products to user's favorite list
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function addToFavorite(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $user = $request->user();

        if ($user->products()->where('product_id', $product->id)->exists()) {
            return back();
        }

        $user->products()->attach([$product->id]);

        return back();
    }

    /**
     * Deletes a product from user's favorite list
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function deleteFromFavorites(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->user()->products()->detach([$product->id]);

        return back()->with(['deleted' => 'محصول مورد نظر از لیست علاقه مندی های شما حذف شد!']);
    }
}
