@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - کدهای تخفیف</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">کدهای تخفیف</h3>
                <div class="text-left">
                    <a class="btn btn-app" href="{{route('coupons.create')}}"><i class="fa fa-plus"></i>جدید</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('coupons'))
                    <div class="alert alert-success">
                        <div>{{session('coupons')}}</div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">کد تخفیف</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td class="text-center">{{$coupon->id}}</td>
                                <td class="text-center">{{$coupon->title}}</td>
                                <td class="text-center">{{$coupon->code}}</td>
                                @if($coupon->status === 0)
                                    <td class="text-center"><span class="tag tag-pill tag-danger">غیر فعال</span></td>
                                @else
                                    <td class="text-center"><span class="tag tag-pill tag-success">فعال</span></td>
                                @endif
                                <td class="text-center">
                                    <a class="btn btn-warning"
                                       href="{{route('coupons.edit', $coupon->id)}}">ویرایش</a>
                                    <div class="display-inline-block">
                                        <form method="post" name="_method"
                                              action="/administrator/coupons/{{$coupon->id}}">
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
