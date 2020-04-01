<?php

namespace App\Http\Controllers\Backend;

use App\AttributeGroup;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Rules\NoCategoryIsOwnParent;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        $categories = Category::with('children')->where('parent_id', null)->get();

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
     * @param  CreateCategoryRequest  $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateCategoryRequest $request)
    {
        (new Category($request->all()))->saveOrFail();
        Session::flash('attributes', 'دسته بندی جدید با موفقیت اضافه شد!');

        return redirect('/administrator/categories');
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
     * @param  CreateCategoryRequest  $request
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(CreateCategoryRequest $request, $id)
    {
        $this->validate($request, ['parent_id' => new NoCategoryIsOwnParent($id)]);
        $category = Category::findOrFail($id);
        $category->fill($request->all());
        $category->saveOrFail();
        Session::flash('attributes', 'دسته بندی با موفقیت به روزرسانی شد!');

        return redirect('/administrator/categories');
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

            return redirect('/administrator/categories');
        }
        $category->delete();
        Session::flash('attributes', 'دسته بندی با موفقیت حذف شد!');

        return redirect('/administrator/categories');
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

        return redirect('/administrator/categories');
    }
}
