<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        if ( ! $this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $products = Product::paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     * @method apiVueJsGetCategories
     * @method apiVueJsGetBrands
     */
    public function create()
    {
        if ( ! $this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }

        // We retrieved categories and brands tables data by API just for fun :))

        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /** Retrieves categories table for create product page api
     *
     * @return JsonResponse
     */
    public function apiVueJsGetCategories()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();
        $brands     = Brand::all();

        return response()->json(['categories' => $categories, 'brands' => $brands], 200);
    }

    /** Retrieves brands table for create product page api
     *
     * @return JsonResponse
     */
    public function apiVueJsGetBrands()
    {
        $brands = Brand::all();

        return response()->json(['brands' => $brands], 200);
    }
}
