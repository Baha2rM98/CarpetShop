<?php

namespace App\Http\Controllers\Backend;

use App\AttributeGroup;
use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Product;
use App\Rules\CheckUniqueSlugForProduct;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class ProductController extends Controller
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
        $products = Product::paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     * @method apiVueJsGetCategories
     * @method apiVueJsGetBrands
     * @method apiVueJsGetCategoriesAttributes
     */
    public function create()
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $brands = Brand::all();

        // We retrieved categories and attributes group tables data by API just for fun :))

        return view('admin.products.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest  $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateProductRequest $request)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $product = new Product();
        $product->title = $request->input('title');
        $product->sku = $this->generateSKU();
        $product->slug = static::makeSlug($request->input('slug'));
        $product->status = $request->input('status');
        $product->price = $request->input('price');
        $product->discount_price = $request->input('discount_price');
        $product->description = $request->input('description');
        $product->brand_id = $request->input('brand');
        //TODO: We complete $product->user_id = (?) after we initialized authentication system.
        $product->user_id = 1;
        //TODO --------------------------------------------------------------------------------
        $product->saveOrFail();
        $product->categories()->sync($request->input('categories'));
        $product->attributeValues()->sync($request->input('attributes'));
        $product->photos()->sync(explode(',', $request->input('photo_id')[0]));
        Session::flash('products', 'محصول جدید با موفقیت ذخیره شد!');

        return redirect('/administrator/products');
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
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }

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
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $this->validate($request, [
            'title' => ['bail', 'required', 'min:2', 'max:100'],
            'slug' => ['bail', 'required', new CheckUniqueSlugForProduct($id), 'max:100'],
            'categories' => 'required|array',
            'brand' => 'required',
            'status' => 'required',
            'price' => ['bail', 'required', 'numeric', 'digits_between:1,25', 'gt:discount_price'],
            'discount_price' => ['bail', 'nullable', 'numeric', 'digits_between:1,25'],
            'description' => ['bail', 'required', 'max:100000'],
            'photo_id.*' => 'required'
        ], [
            'title.required' => 'نام محصول نمیتواند خالی باشد!',
            'title.min' => 'نام محصول نمیتواند کمتر از 2 کاراکتر باشد!',
            'title.max' => 'نام محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
            'slug.required' => 'نام مستعار محصول نمیتواند خالی باشد!',
            'slug.max' => 'نام مستعار محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
            'categories.required' => 'هر محصول باید حداقل متعلق به یک دسته بندی باشد!',
            'brand.required' => 'هر محصول باید متعلق به یک برند باشد!',
            'status.required' => 'وضعیت محصول باید درج شود!',
            'price.required' => 'قیمت محصول نمیتواند خالی باشد!',
            'price.numeric' => 'قیمت محصول باید از نوع عدد باشد!',
            'price.digits_between' => 'قیمت وارد شده بزرگ تر از حد مجاز است!',
            'price.gt' => 'قیمت ویژه محصول نمیتواند از قیمت اصلی آن بزرگتر یا برابر باشد!',
            'discount_price.numeric' => 'قیمت ویژه محصول باید از نوع عدد باشد!',
            'discount_price.digits_between' => 'قیمت ویژه وارد شده بزرگ تر از حد مجاز است!',
            'description.required' => 'توضیحات محصول نمیتواند خالی باشد!',
            'description.max' => 'توضیحات محصول نمیتواند بیشتر ار 100000 کاراکتر باشد!',
            'photo_id.*.required' => 'عکس محصول نمیتواند خالی باشد!'
        ]);
        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->slug = static::makeSlug($request->slug);
        $product->status = $request->status;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->description = $request->description;
        $product->brand_id = $request->brand;
        //TODO: We complete $product->user_id = (?) after we initialized authentication system.
        $product->user_id = 1;
        //TODO --------------------------------------------------------------------------------
        $product->saveOrFail();
        $product->categories()->sync($request->categories);
        $product->attributeValues()->sync($request->input('attributes'));
        $product->photos()->sync(explode(',', $request->photo_id[0]));
        Session::flash('products', 'محصول با موفقیت ویرایش شد!');

        return redirect('/administrator/products');
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
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $product = Product::with('photos')->whereId($id)->first();
        $product->delete();
        Session::flash('products', 'محصول با موفقیت حذف شد!');

        return redirect('/administrator/products');
    }

    /**
     * Generates an individual identifier for each product
     *
     * @return string
     */
    private function generateSKU()
    {
        $alphabet = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($alphabet);
        $sku = substr(str_shuffle(strval(mt_rand(1, mt_getrandmax())).implode(array_slice($alphabet, mt_rand(8, 20),
                8))), 4, 8);
        if ($this->ifSKUExists($sku)) {
            return $this->generateSKU();
        }

        return $sku;
    }

    /** Checks if generated sku exists already
     *
     * @param  string  $sku
     *
     * @return bool
     */
    private function ifSKUExists($sku)
    {
        return Product::where('sku', $sku)->exists();
    }

    /**
     * Makes suitable slug for each product
     *
     * @param  string  $slug
     *
     * @return string|null
     */
    public static function makeSlug($slug)
    {
        return preg_replace('/\s+/', '-', trim(str_replace(['؟', '?'], '', strtolower($slug))));
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
    public function apiVueJsGetCategoriesAttributes(Request $request)
    {
        $categories = $request->all();
        $attributeGroup = AttributeGroup::with('attributeValues', 'categories')->whereHas(
            'categories', function ($query) use ($categories) {
            $query->whereIn('categories.id', $categories);
        })->get();

        return response()->json(['attributes' => $attributeGroup]);
    }
}
