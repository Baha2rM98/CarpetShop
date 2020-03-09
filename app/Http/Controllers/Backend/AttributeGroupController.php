<?php

namespace App\Http\Controllers\Backend;

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
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributesGroup = AttributeGroup::all();
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
     * @param CreateAttributeGroupRequest $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateAttributeGroupRequest $request)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributeGroup = new AttributeGroup();
        $attributeGroup->title = $request->input('title');
        $attributeGroup->type = $request->input('type');
        $attributeGroup->saveOrFail();
        Session::flash('attributes', 'ویژگی جدید با موفقیت اضافه شد!');
        return redirect('/administrator/attributes-group');
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
        $attributesGroup = AttributeGroup::findOrFail($id);
        return view('admin.attributes.edit', compact('attributesGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateAttributeGroupRequest $request
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function update(CreateAttributeGroupRequest $request, $id)
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $attributeGroup = AttributeGroup::findOrFail($id);
        $attributeGroup->title = $request->title;
        $attributeGroup->type = $request->type;
        $attributeGroup->saveOrFail();
        Session::flash('attributes', 'ویژگی با موفقیت به روزرسانی شد!');
        return redirect('/administrator/attributes-group');
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
        $attributeGroup = AttributeGroup::findOrFail($id);
        $attributeGroup->delete();
        Session::flash('attributes', 'ویژگی و مقادیر آن با موفقیت حذف شدند!');
        return redirect('/administrator/attributes-group');
    }
}
