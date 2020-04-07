<?php

namespace App\Http\Controllers\Backend;

use App\AttributeGroup;
use App\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttributeValueRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $attributesValue = AttributeValue::with('attributeGroup')->paginate(10);

        return view('admin.attributes-value.index', compact('attributesValue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $attributesGroup = AttributeGroup::all();

        return view('admin.attributes-value.create', compact('attributesGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAttributeValueRequest  $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateAttributeValueRequest $request)
    {
        (new AttributeValue($request->all()))->saveOrFail();
        Session::flash('attributes-value', 'مقدار ویژگی با موفقیت ذخیره شد!');

        return redirect()->route('attribute-values.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $attributesValue = AttributeValue::with('attributeGroup')->whereId($id)->first();
        $attributesGroup = AttributeGroup::all();

        return view('admin.attributes-value.edit', compact('attributesValue', 'attributesGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateAttributeValueRequest  $request
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function update(CreateAttributeValueRequest $request, $id)
    {
        $attributeGroup = AttributeValue::findOrFail($id);
        $attributeGroup->fill($request->all());
        $attributeGroup->saveOrFail();
        Session::flash('attributes-value', 'مقدار ویژگی با موفقیت به روزرسانی شد!');

        return redirect()->route('attribute-values.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();
        Session::flash('attributes-value', 'مقدار ویژگی با موفقیت حذف شد!');

        return redirect()->route('attribute-values.index');
    }
}
