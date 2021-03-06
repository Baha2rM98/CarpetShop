<?php

namespace App\Http\Controllers\Admin;

use App\AttributeGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttributeGroupRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class AttributeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $attributesGroup = AttributeGroup::paginate(10);

        return view('admin.attributes.index', compact('attributesGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAttributeGroupRequest  $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateAttributeGroupRequest $request)
    {
        (new AttributeGroup($request->all()))->saveOrFail();
        Session::flash('attributes', 'ویژگی جدید با موفقیت اضافه شد!');

        return redirect()->route('attribute-groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $attributesGroup = AttributeGroup::findOrFail($id);

        return view('admin.attributes.edit', compact('attributesGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateAttributeGroupRequest  $request
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function update(CreateAttributeGroupRequest $request, $id)
    {
        $attributeGroup = AttributeGroup::findOrFail($id);
        $attributeGroup->fill($request->all());
        $attributeGroup->saveOrFail();
        Session::flash('attributes', 'ویژگی با موفقیت به روزرسانی شد!');

        return redirect()->route('attribute-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $attributeGroup = AttributeGroup::findOrFail($id);
        $attributeGroup->delete();
        Session::flash('attributes', 'ویژگی و مقادیر آن با موفقیت حذف شدند!');

        return redirect()->route('attribute-groups.index');
    }
}
