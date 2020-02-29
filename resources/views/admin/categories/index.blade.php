@extends('admin.layout.master')
<title>دسته بندی ها</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">دسته بندی ها</h3>
                <div class="text-left">
                    <a class="btn btn-app" href="{{route('categories.create')}}"><i class="fa fa-plus"></i>جدید</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('attributes'))
                    <div class="alert alert-success">
                        <div>{{session('attributes')}}</div>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Session::has('error_category'))
                    <div class="alert alert-danger">
                        <div>{{session('error_category')}}</div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="text-center">{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning"
                                       href="{{route('categories.edit', $category->id)}}">ویرایش</a>
                                    <div class="display-inline-block">
                                        <form method="post" name="_method"
                                              action="/administrator/categories/{{$category->id}}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @if(isset($category->children))
                                @include('admin.partials.categorylist', ['categories' => $category->children, 'level' => 1])
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-footer -->
        </div>
    </section>
@endsection
