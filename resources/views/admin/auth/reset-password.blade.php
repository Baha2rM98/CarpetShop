@extends('admin.layout.master-auth')
<title>صفحه مدیریت بازیابی رمزعبور - ایجاد رمزعبور جدید</title>
@section('content')
    <div class="row" style="margin-right: 50px;">
        <div class="col-sm-9" id="content">
            @if($errors->any())
                <ul>
                    <div class="alert alert-warning">
                        @foreach($errors->all() as $error)
                            <ul>{{$error}}</ul>
                        @endforeach
                    </div>
                </ul>
            @endif
            <h3 class="title" style="color: #1d2124;">بازیابی رمزعبور :</h3>
            <form class="form-horizontal" style="margin-top: 50px" method="post"
                  action="{{route('admin.reset.pass.post', ['token' => request('token')])}}">
                @csrf
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
                <div class="buttons">
                    <div class="pull-left">
                        <input type="submit" class="btn btn-primary" value="ذخیره">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
