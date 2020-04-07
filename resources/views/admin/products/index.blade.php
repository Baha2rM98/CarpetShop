@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه -  محصولات</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">محصولات</h3>
                <div class="text-left">
                    <a class="btn btn-app" href="{{route('products.create')}}"><i class="fa fa-plus"></i>جدید</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('products'))
                    <div class="alert alert-success">
                        <div>{{session('products')}}</div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">کد محصول</th>
                            <th class="text-center">نام محصول</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center">{{$product->id}}</td>
                                <td class="text-center">{{$product->sku}}</td>
                                <td class="text-center">{{$product->title}}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning"
                                       href="{{route('products.edit', $product->id)}}">ویرایش</a>
                                    <div class="display-inline-block">
                                        <form method="post" name="_method"
                                              action="/products/{{$product->id}}">
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

{{-----                  FOR PAGINATE-----------------------------------------------------------------------}}

                    <div class="col-md-12" style="text-align: center">{{$products->links()}}</div>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-footer -->
        </div>
    </section>
@endsection
