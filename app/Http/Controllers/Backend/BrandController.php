<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if (!$this->isDatabaseConnected()) {
            abort(503, 'Database Connection Error');
        }
        $this->validate($request, [
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
        $brand = new Brand();
        $brand->title = $request->input('title');
        $brand->description = $request->input('description');
        $brand->photo_id = $request->input('photo_id');
        $brand->saveOrFail();
        Session::flash('brands', 'برند جدید با موفقیت ذخیره شد!');
        return redirect('/administrator/brands');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!$this->isDatabaseConnected()) {
            abort(503, 'Database Connection Error');
        }
        $this->validate($request, [
            'title' => ['bail', 'required', 'min:2', 'unique:brands,title,' . $id],
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
        $brand = Brand::findOrFail($id);
        $brand->title = $request->title;
        $brand->description = $request->description;
        $brand->photo_id = $request->photo_id;
        $brand->saveOrFail();
        Session::flash('brands', 'برند با موفقیت ویرایش شد!');
        return redirect('/administrator/brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $brand = Brand::with('photo')->whereId($id)->first();
        Storage::disk('local')->delete('public/photos/' . $this->getFileAbsolutePath($brand->photo->path));
        $brand->photo->delete();
        $brand->delete();
        Session::flash('brands', 'برند با موفقیت حذف شد!');
        return redirect('/administrator/brands');
    }

    /** Returns absolute path of uploaded files on server
     *
     * @param string $path
     * @return string|string[]
     */
    public function getFileAbsolutePath($path)
    {
        return str_replace('/storage/photos/', null, $path);
    }
}
