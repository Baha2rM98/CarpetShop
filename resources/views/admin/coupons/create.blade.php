@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ایجاد کدتخفیف</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد کد تخفیف جدید</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if($errors->any())
                    <ul>
                        <div class="alert alert-warning">
                            @foreach($errors->all() as $error)
                                <ul>{{$error}}</ul>
                            @endforeach
                        </div>
                    </ul>
                @endif
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="post" action="/coupons">
                            @csrf
                            <div class="form-group">
                                <label for="name">عنوان کد تخفیف</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="عنوان کد تخفیف را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">کد</label>
                                <input type="text" name="code" class="form-control" placeholder="کد را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">قیمت</label>
                                <input type="number" name="price" class="form-control" placeholder="قیمت را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label>وضعیت</label>
                                <div>
                                    <input type="radio" name="status" value="0" checked> <span class="margin-l-10">غیر فعال</span>
                                    <input type="radio" name="status" value="1"> <span>فعال</span>
                                </div>
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
