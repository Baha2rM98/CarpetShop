@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه | پروفایل - تغییر رمزعبور</title>
@section('content')
    <div class="row">
        <div id="content" class="col-sm-9">
            <h2 style="font-size: x-large; margin-right: 40px">تغییر رمزعبور</h2>
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
                @if(\Illuminate\Support\Facades\Session::has('error'))
                    <div class="alert alert-danger">
                        <div>{{session('error')}}</div>
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-md-offset-3">
                <form method="post" action="{{route('admin.profile.update.pass.real')}}">
                    @csrf
                    <div class="form-group required">
                        <label for="name">رمزعبور قدیمی</label>
                        <input type="password" name="old_password" class="form-control"
                               placeholder="رمزعبور قدیمی را وارد کنید...">
                    </div>
                    <br>
                    <br>
                    <div class="form-group required">
                        <label for="name">رمزعبور جدید</label>
                        <input type="password" name="new_password" class="form-control"
                               placeholder="رمزعبور جدید را وارد کنید...">
                    </div>
                    <div class="form-group required">
                        <label for="name">تکرار رمزعبور جدید</label>
                        <input type="password" name="confirm_new_password" class="form-control"
                               placeholder="رمزعبور جدید را تکرار کنید...">
                    </div>
                    <button type="submit" class="btn btn-primary pull-left">ذخیره</button>
                </form>
            </div>
        </div>
    </div>
@endsection
