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
                                    <a class="btn btn-danger"
                                       href="{{route('categories.destroy', $category->id)}}">حذف</a>
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
