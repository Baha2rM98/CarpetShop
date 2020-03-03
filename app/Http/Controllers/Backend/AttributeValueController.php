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
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributesValue = AttributeValue::with('attributeGroup')->get();
        return view('admin.attributes-value.index', compact('attributesValue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributesGroup = AttributeGroup::all();
        return view('admin.attributes-value.create', compact('attributesGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAttributeValueRequest $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateAttributeValueRequest $request)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $newValue = new AttributeValue();
        $newValue->title = $request->input('title');
        $newValue->attribute_group_id = $request->input('attributes_group_id');
        $newValue->saveOrFail();
        Session::flash('attributes-value', 'مقدار ویژگی با موفقیت ذخیره شد!');
        return redirect('/administrator/attributes-value');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributesValue = AttributeValue::with('attributeGroup')->whereId($id)->firstOrFail();
        $attributesGroup = AttributeGroup::all();
        return view('admin.attributes-value.edit', compact('attributesValue', 'attributesGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateAttributeValueRequest $request
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function update(CreateAttributeValueRequest $request, $id)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributeGroup = AttributeValue::findOrFail($id);
        $attributeGroup->title = $request->title;
        $attributeGroup->attribute_group_id = $request->attributes_group_id;
        $attributeGroup->saveOrFail();
        Session::flash('attributes-value', 'مقدار ویژگی با موفقیت به روزرسانی شد!');
        return redirect('/administrator/attributes-value');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();
        Session::flash('attributes-value', 'مقدار ویژگی با موفقیت حذف شد!');
        return redirect('/administrator/attributes-value');
    }
}
