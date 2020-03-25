@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ویرایش کد تخفیف</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش کد تخفیف {{$coupon->title}}</h3>
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
                        <form method="post" action="/administrator/coupons/{{$coupon->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">عنوان کد تخفیف</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="عنوان کد تخفیف را وارد کنید..." value="{{$coupon->title}}">
                            </div>
                            <div class="form-group">
                                <label for="name">کد</label>
                                <input type="text" name="code" class="form-control" placeholder="کد را وارد کنید..."
                                       value="{{$coupon->code}}">
                            </div>
                            <div class="form-group">
                                <label for="name">قیمت</label>
                                <input type="number" name="price" class="form-control" placeholder="قیمت را وارد کنید..."
                                        value="{{$coupon->price}}">
                            </div>
                            <div class="form-group">
                                <label>وضعیت</label>
                                <div>
                                    <input type="radio" name="status" value="0"
                                           @if($coupon->status === 0) checked @endif> <span
                                            class="margin-l-10">غیر فعال</span>
                                    <input type="radio" name="status" value="1"
                                           @if($coupon->status === 1) checked @endif> <span>فعال</span>
                                </div>
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
