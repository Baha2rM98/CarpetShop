<?php

namespace App\Http\Controllers\Admin;

use App\AttributeGroup;
use App\Brand;
use App\Category;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class ProductController extends Controller
{
    use Helper;

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $products = Product::paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @method apiVueJsGetCategories
     * @method apiVueJsGetCategoriesAttributes
     */
    public function create()
    {
        $brands = Brand::all();

        // We retrieved categories and attributes group tables data by API just for fun :))

        return view('admin.products.create', compact('brands'));
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
        $this->productValidator($request);
        $product = new Product($request->all());
        $product->sku = $this->generateSKU();
        $product->slug = self::makeSlug($request->input('slug'));
        $product->saveOrFail();
        $product->categories()->sync($request->input('categories'));
        $product->attributeValues()->sync(explode(',', $request->input('attributes')[0]));
        $product->photos()->sync(explode(',', $request->input('photo_id')[0]));
        Session::flash('products', 'محصول جدید با موفقیت ذخیره شد!');

        return redirect()->route('products.index');
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
        $brands = Brand::all();
        $product = Product::with('brand', 'categories', 'attributeValues', 'photos')->whereId($id)->first();

        return view('admin.products.edit', compact('product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function update(Request $request, $id)
    {
        $this->productValidator($request, $id);
        $product = Product::findOrFail($id);
        $product->fill($request->all());
        $product->slug = self::makeSlug($request->input('slug'));
        $product->saveOrFail();
        $product->categories()->sync($request->input('categories'));
        $product->attributeValues()->sync($this->filter(explode(',', $request->input('attributes')[0])));
        $product->photos()->sync(explode(',', $request->input('photo_id')[0]));
        Session::flash('products', 'محصول با موفقیت ویرایش شد!');

        return redirect()->route('products.index');
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
        $product = Product::findOrFail($id);
        $product->delete();
        Session::flash('products', 'محصول با موفقیت حذف شد!');

        return redirect()->route('products.index');
    }

    /**
     * Validates product features
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     * @throws ValidationException
     */
    private function productValidator(Request $request, $id = null)
    {
        $request = $request->merge(['slug' => self::makeSlug($request->input('slug'))]);

        if (isset($id)) {
            return $this->validate($request, [
                'title' => ['bail', 'required', 'min:2', 'max:100'],
                'slug' => [
                    'bail', 'required', Rule::unique('products')->ignore($id, 'id')->whereNull('deleted_at'), 'max:100'
                ],
                'categories' => ['required', 'array'],
                'attributes.*' => 'required',
                'brand_id' => 'required',
                'status' => 'required',
                'price' => ['bail', 'required', 'numeric', 'digits_between:1,15'],
                'discount_price' => ['bail', 'nullable', 'numeric', 'digits_between:1,15', 'lt:price'],
                'description' => ['bail', 'required', 'max:100000'],
                'photo_id.*' => 'required'
            ], [
                'title.required' => 'نام محصول نمیتواند خالی باشد!',
                'title.min' => 'نام محصول نمیتواند کمتر از 2 کاراکتر باشد!',
                'title.max' => 'نام محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
                'slug.required' => 'نام مستعار محصول نمیتواند خالی باشد!',
                'slug.max' => 'نام مستعار محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
                'slug.unique' => 'این نام مستعار قبلا ثبت شده است!',
                'categories.required' => 'هر محصول باید حداقل متعلق به یک دسته بندی باشد!',
                'attributes.*.required' => 'ویژگی های محصول نمیتواند خالی باشد!',
                'brand_id.required' => 'هر محصول باید متعلق به یک برند باشد!',
                'status.required' => 'وضعیت محصول باید درج شود!',
                'price.required' => 'قیمت محصول نمیتواند خالی باشد!',
                'price.numeric' => 'قیمت محصول باید از نوع عدد باشد!',
                'price.digits_between' => 'قیمت وارد شده بزرگ تر از حد مجاز است!',
                'discount_price.numeric' => 'قیمت ویژه محصول باید از نوع عدد باشد!',
                'discount_price.digits_between' => 'قیمت ویژه وارد شده بزرگ تر از حد مجاز است!',
                'discount_price.lt' => 'قیمت ویژه محصول نمیتواند از قیمت اصلی آن بزرگتر یا برابر باشد!',
                'description.required' => 'توضیحات محصول نمیتواند خالی باشد!',
                'description.max' => 'توضیحات محصول نمیتواند بیشتر ار 100000 کاراکتر باشد!',
                'photo_id.*.required' => 'عکس محصول نمیتواند خالی باشد!'
            ]);
        }

        return $this->validate($request, [
            'title' => ['bail', 'required', 'min:2', 'max:100'],
            'slug' => ['bail', 'required', Rule::unique('products')->whereNull('deleted_at'), 'max:100'],
            'categories' => ['required', 'array'],
            'attributes.*' => 'required',
            'brand_id' => 'required',
            'status' => 'required',
            'price' => ['bail', 'required', 'numeric', 'digits_between:1,15'],
            'discount_price' => ['bail', 'nullable', 'numeric', 'digits_between:1,15', 'lt:price'],
            'description' => ['bail', 'required', 'max:100000'],
            'photo_id.*' => 'required'
        ], [
            'title.required' => 'نام محصول نمیتواند خالی باشد!',
            'title.min' => 'نام محصول نمیتواند کمتر از 2 کاراکتر باشد!',
            'title.max' => 'نام محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
            'slug.required' => 'نام مستعار محصول نمیتواند خالی باشد!',
            'slug.max' => 'نام مستعار محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
            'slug.unique' => 'این نام مستعار قبلا ثبت شده است!',
            'categories.required' => 'هر محصول باید حداقل متعلق به یک دسته بندی باشد!',
            'attributes.*.required' => 'ویژگی های محصول نمیتواند خالی باشد!',
            'brand_id.required' => 'هر محصول باید متعلق به یک برند باشد!',
            'status.required' => 'وضعیت محصول باید درج شود!',
            'price.required' => 'قیمت محصول نمیتواند خالی باشد!',
            'price.numeric' => 'قیمت محصول باید از نوع عدد باشد!',
            'price.digits_between' => 'قیمت وارد شده بزرگ تر از حد مجاز است!',
            'discount_price.numeric' => 'قیمت ویژه محصول باید از نوع عدد باشد!',
            'discount_price.digits_between' => 'قیمت ویژه وارد شده بزرگ تر از حد مجاز است!',
            'discount_price.lt' => 'قیمت ویژه محصول نمیتواند از قیمت اصلی آن بزرگتر یا برابر باشد!',
            'description.required' => 'توضیحات محصول نمیتواند خالی باشد!',
            'description.max' => 'توضیحات محصول نمیتواند بیشتر ار 100000 کاراکتر باشد!',
            'photo_id.*.required' => 'عکس محصول نمیتواند خالی باشد!'
        ]);
    }

    /**
     * Generates an individual identifier for each product
     *
     * @return string
     */
    private function generateSKU()
    {
        return 'cmp-'.$this->timestamp();
    }

    /**
     * Makes suitable slug for each product
     *
     * @param  string  $slug
     *
     * @return string
     */
    private static function makeSlug($slug)
    {
        return preg_replace('/\s+/', '-', trim(str_replace(['؟', '?'], '', Str::lower($slug))));
    }

    /*
    |--------------------------------------------------------------------------
    | API Controllers
    |--------------------------------------------------------------------------
    |
    | Here is where we registered API controller for our application
    */

    /** Retrieves categories table for create product page api
     *
     * @return JsonResponse
     */
    public function apiVueJsGetCategories()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();

        return response()->json(['categories' => $categories], 200);
    }

    /** Retrieves attributes group of selected category for create product page api
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function apiVueJsGetCategoryAttributes(Request $request)
    {
        $categories = $request->all();
        $attributeGroup = AttributeGroup::with('attributeValues')->whereHas(
            'categories', function ($query) use ($categories) {
            $query->where('categories.id', $categories);
        })->get();
        return response()->json(['attributes' => $attributeGroup]);
    }
}
