@extends('admin.layout.master')
<title>یجاد دسته بندی جدید</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد دسته بندی جدید</h3>
                {{--                <div class="text-left">--}}
                {{--                    <a class="btn btn-app" href="{{route('categories.create')}}">--}}
                {{--                        <i class="fa fa-plus"></i>جدید--}}
                {{--                    </a>--}}
                {{--                </div>--}}
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="post" action="/administrator/categories">
                            @csrf
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="عنوان دسته بندی را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">دسته والد</label>
                                <select name="category_parent" id="" class="form-control">
                                    <option value="nul">بدون والد</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success pull-left">ذخیره</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-footer -->
    </section>
@endsection
