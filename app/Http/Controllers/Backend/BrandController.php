<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBrandRequest $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateBrandRequest $request)
    {
        if (!$this->isDatabaseConnected()) {
            abort(503, 'Database Connection Error');
        }
        $brand = new Brand();
        $brand->title = $request->input('title');
        $brand->description = $request->input('description');
        $brand->photo_id = $request->input('photo_id');
        $brand->saveOrFail();
        Session::flash('brands', 'برند جدید با موفقیت ذخیره شد!');
        return redirect('/administrator/brands');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CreateBrandRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
