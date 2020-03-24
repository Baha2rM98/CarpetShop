<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
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
        if ( ! $this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('frontend.home.index', compact('products'));
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return Response
//     */
//    public function create()
//    {
//        //
//    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  Request  $request
//     *
//     * @return Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }

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

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     *
//     * @return Response
//     */
//    public function edit($id)
//    {
//        //
//    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  Request  $request
//     * @param  int  $id
//     *
//     * @return Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     *
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}
