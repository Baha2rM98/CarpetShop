@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ویرایش دسته بندی</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش دسته بندی {{$category->name}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if($errors->any())
                    <ul>
                        <div class="alert alert-warning">
                            @foreach($errors->all() as $error)
                                {{$error}}
                            @endforeach
                        </div>
                    </ul>
                @endif
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="post" action="/administrator/categories/{{$category->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" name="name" class="form-control" value="{{$category->name}}"
                                       placeholder="عنوان دسته بندی را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">دسته والد</label>
                                <select name="parent_id" id="" class="form-control">
                                    <option value="">بدون والد</option>
                                    @foreach($categories as $showParentCategory)
                                        <option value="{{$showParentCategory->id}}"
                                                @if($category->parent_id === $showParentCategory->id) selected @endif>{{$showParentCategory->name}}</option>
                                        @if(count($showParentCategory->children) > 0)
                                            @include('admin.partials.subcategory', ['categories' => $showParentCategory->children, 'level' => 1, 'selectedCategory' => $category])
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">عنوان سئو</label>
                                <input type="text" name="meta_title" class="form-control"
                                       value="{{$category->meta_title}}"
                                       placeholder="عنوان سئو را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="meta_desc">توضیحات سئو</label>
                                <textarea name="meta_desc" class="form-control"
                                          placeholder="توضیحات سئو را وارد کنید...">{{$category->meta_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">کلمات کلیدی سئو</label>
                                <input type="text" name="meta_keywords" class="form-control"
                                       value="{{$category->meta_keywords}}"
                                       placeholder="کلمات کلیدی سئو را وارد کنید...">
                            </div>
                            <button type="submit" class="btn btn-facebook pull-left">ویرایش کردن</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-footer -->
    </section>
@endsection
