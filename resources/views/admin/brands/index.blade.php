@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - برند ها</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">برند ها</h3>
                <div class="text-left">
                    <a class="btn btn-app" href="{{route('brands.create')}}"><i class="fa fa-plus"></i>جدید</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('brands'))
                    <div class="alert alert-success">
                        <div>{{session('brands')}}</div>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Session::has('error'))
                    <div class="alert alert-danger">
                        <div>{{session('error')}}</div>
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
                        @foreach($brands as $brand)
                            <tr>
                                <td class="text-center">{{$brand->id}}</td>
                                <td>{{$brand->title}}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning"
                                       href="{{route('brands.edit', $brand->id)}}">ویرایش</a>
                                    <div class="display-inline-block">
                                        <form method="post" name="_method"
                                              action="/administrator/brands/{{$brand->id}}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
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
