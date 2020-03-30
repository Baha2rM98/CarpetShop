<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
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
     * @param  Request  $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $this->brandStoreValidator($request);
        (new Brand($request->all()))->saveOrFail();
        Session::flash('brands', 'برند جدید با موفقیت ذخیره شد!');

        return redirect('/administrator/brands');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Factory|View
     */
    public function edit($id)
    {
        $brand = Brand::with('photo')->whereId($id)->first();

        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->brandUpdateValidator($request, $id);
        $brand = Brand::findOrFail($id);
        $brand->fill($request->all());
        $brand->saveOrFail();
        Session::flash('brands', 'برند با موفقیت ویرایش شد!');

        return redirect('/administrator/brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $brand = Brand::with('photo')->whereId($id)->first();
        $brand->delete();
        Session::flash('brands', 'برند با موفقیت حذف شد!');

        return redirect('/administrator/brands');
    }

    /**
     * Validates request input for storing data
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function brandStoreValidator(Request $request)
    {
        return $this->validate($request, [
            'title' => ['bail', 'required', 'min:2', 'unique:brands'],
            'description' => ['bail', 'required', 'max:10000'],
            'photo_id' => 'required'
        ], [
            'title.required' => 'نام برند نمیتواند خالی باشد!',
            'title.min' => 'نام برند نمیتواند کمتر از 2 کاراکتر باشد!',
            'title.unique' => 'این برند قبلا ثبت شده است!',
            'description.required' => 'توضیحات برند نمیتواند خالی باشد!',
            'description.max' => 'توضیحات برند نمیتواند بیشتر از 10000 کاراکتر باشد!',
            'photo_id.required' => 'عکس برند نمیتواند خالی باشد!'
        ]);
    }

    /**
     * Validates request input for updating data
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     * @throws ValidationException
     */
    private function brandUpdateValidator(Request $request, $id)
    {
        return $this->validate($request, [
            'title' => ['bail', 'required', 'min:2', 'unique:brands,title,'.$id],
            'description' => ['bail', 'required', 'max:10000'],
            'photo_id' => 'required'
        ], [
            'title.required' => 'نام برند نمیتواند خالی باشد!',
            'title.min' => 'نام برند نمیتواند کمتر از 2 کاراکتر باشد!',
            'title.unique' => 'این برند قبلا ثبت شده است!',
            'description.required' => 'توضیحات برند نمیتواند خالی باشد!',
            'description.max' => 'توضیحات برند نمیتواند بیشتر از 10000 کاراکتر باشد!',
            'photo_id.required' => 'عکس برند نمیتواند خالی باشد!'
        ]);
    }
}
