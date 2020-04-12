<?php

namespace App\Http\Controllers\Backend;

use App\AttributeGroup;
use App\Category;
use App\Http\Controllers\Controller;
use App\Rules\NoCategoryIsOwnParent;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $categories = Category::with('children')->where('parent_id', null)->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();

        return view('admin.categories.create', compact('categories'));
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
        $this->categoryValidator($request);
        $category = new Category($request->all());
        $category->slug = self::makeSlug($request->input('slug'));
        $category->saveOrFail();
        Session::flash('attributes', 'دسته بندی جدید با موفقیت اضافه شد!');

        return redirect()->route('categories.index');
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
        $categories = Category::with('children')->where('parent_id', null)->get();
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->categoryValidator($request, $id);
        $this->validate($request, ['parent_id' => new NoCategoryIsOwnParent($id)]);
        $category = Category::findOrFail($id);
        $category->fill($request->all());
        $category->slug = self::makeSlug($request->input('slug'));
        $category->saveOrFail();
        Session::flash('attributes', 'دسته بندی با موفقیت به روزرسانی شد!');

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy($id)
    {
        $category = Category::with('children')->where('id', $id)->first();
        if (count($category->children) > 0) {
            Session::flash('error_category',
                'دسته بندی '."[ $category->name ]".' دارای زیردسته است، بنابراین حذف آن امکان پذیر نیست.');

            return redirect()->route('categories.index');
        }
        $category->delete();
        Session::flash('attributes', 'دسته بندی با موفقیت حذف شد!');

        return redirect()->route('categories.index');
    }

    /**
     * Displays setting page for each category
     *
     * @param  int  $id
     *
     * @return Factory|View
     */
    public function indexAttributes($id)
    {
        $category = Category::findOrFail($id);
        $attributeGroups = AttributeGroup::all();

        return view('admin.categories.index-attribute', compact('category', 'attributeGroups'));
    }

    /**
     * Stores newly request in database
     *
     * @param  Request  $request
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function saveAttributes(Request $request, $id)
    {
        $this->validate($request, ['attributeGroups' => ['required', 'array']],
            ['attributeGroups.required' => 'ویژگی انتخاب شده نمیتواند خالی باشد!']);
        $category = Category::findOrFail($id);
        $category->attributeGroups()->sync($request->input('attributeGroups'));
        $category->saveOrFail();
        Session::flash('settings', 'ویژگی های دسته بندی '." [ $category->name ] ".' با موفقیت ذخیره شدند!');

        return redirect()->route('categories.index');
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return array
     * @throws ValidationException
     */
    private function categoryValidator(Request $request, $id = null)
    {
        $request = $request->merge(['slug' => self::makeSlug($request->input('slug'))]);

        if (isset($id)) {
            return $this->validate($request, [
                'name' => ['bail', 'required', 'max:50', 'min:2'],
                'slug' => [
                    'bail', 'required', 'max:100', 'min:2',
                    Rule::unique('categories')->ignore($id, 'id')->whereNull('deleted_at')
                ]
            ], [
                'name.required' => 'نام دسته بندی نمیتواند خالی باشد!',
                'name.max' => 'نام دسته بندی نمیتواند بیشتر از 50 کاراکتر باشد!',
                'name.min' => 'نام دسته بندی نمیتواند کمتر از 2 کاراکتر باشد!',
                'slug.required' => 'نام مستعار دسته بندی نمیتواند خالی باشد!',
                'slug.max' => 'نام دسته بندی نمیتواند بیشتر از 50 کاراکتر باشد!',
                'slug.min' => 'نام دسته بندی نمیتواند کمتر از 2 کاراکتر باشد!',
                'slug.unique' => 'این نام مستعار قبلا ثبت شده است!'
            ]);
        }

        return $this->validate($request, [
            'name' => ['bail', 'required', 'max:50', 'min:2'],
            'slug' => ['bail', 'required', 'max:100', 'min:2', Rule::unique('categories')->whereNull('deleted_at')]
        ], [
            'name.required' => 'نام دسته بندی نمیتواند خالی باشد!',
            'name.max' => 'نام دسته بندی نمیتواند بیشتر از 50 کاراکتر باشد!',
            'name.min' => 'نام دسته بندی نمیتواند کمتر از 2 کاراکتر باشد!',
            'slug.required' => 'نام مستعار دسته بندی نمیتواند خالی باشد!',
            'slug.max' => 'نام دسته بندی نمیتواند بیشتر از 50 کاراکتر باشد!',
            'slug.min' => 'نام دسته بندی نمیتواند کمتر از 2 کاراکتر باشد!',
            'slug.unique' => 'این نام مستعار قبلا ثبت شده است!'
        ]);
    }

    /**
     * Makes suitable slug for each category
     *
     * @param  string  $slug
     *
     * @return string
     */
    private static function makeSlug($slug)
    {
        return preg_replace('/\s+/', '-', trim(str_replace(['؟', '?'], '', Str::lower($slug))));
    }
}
