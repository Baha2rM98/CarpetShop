@extends('admin.layout.master')
<title>صفحه مدیریت | پروفایل - ویرایش</title>
@section('content')
    <div class="row">
        <div id="content" class="col-sm-9">
            <h2 style="font-size: x-large; margin-right: 40px">ویرایش پروفایل</h2>
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
            </div>
            <div class="col-md-6 col-md-offset-3">
                <form method="post" action="{{route('admin.profile.update')}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">نام</label>
                        <input type="text" name="name" class="form-control" value="{{$admin->name}}"
                               placeholder="نام را وارد کنید...">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="name">نام خانوادگی</label>
                        <input type="text" name="last_name" class="form-control" value="{{$admin->last_name}}"
                               placeholder="نام خانوادگی را وارد کنید...">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="name">شماره تلفن</label>
                        <input type="tel" name="phone_number" class="form-control" value="{{$admin->phone_number}}"
                               placeholder="شماره تلفن را وارد کنید...">
                    </div>
                    <button type="submit" class="btn btn-primary pull-left">ویرایش</button>
                </form>
                <a class="btn btn-info pull-right" href="{{route('profile.update.pass.view')}}">تغییر رمزعبور</a>
            </div>
        </div>
    </div>
@endsection
