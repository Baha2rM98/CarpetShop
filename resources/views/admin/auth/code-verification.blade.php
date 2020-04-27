@extends('admin.layout.master-auth')
<title>صفحه مدیریت بازیابی رمزعبور - تایید کد بازیابی</title>
@section('content')
    <div class="row" style="margin-right: 50px;">
        <div class="col-sm-9" id="content">
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-warning" style="margin-top: 40px">
                    <div>{{session('error')}}</div>
                </div>
            @endif
            @if(\Illuminate\Support\Facades\Session::has('ok'))
                <div class="alert alert-success" style="margin-top: 40px">
                    <div>{{session('ok')}}</div>
                </div>
            @endif
            @if($errors->any())
                <ul>
                    <div class="alert alert-warning">
                        @foreach($errors->all() as $error)
                            <ul>{{$error}}</ul>
                        @endforeach
                    </div>
                </ul>
            @endif
            <h3 class="title" style="color: #1d2124;">کد ارسال شده را وارد کنید :</h3>
            <form class="form-horizontal" style="margin-top: 50px" method="post"
                  action="{{route('admin.verify.code.back', ['id'=>request('id')])}}">
                @csrf
                <div class="form-group required">
                    <label for="input-phone" class="col-sm-2 control-label" style="color: #1d2124">کد بازیابی</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="input-phone" placeholder="کد بازیابی" name="vCode">
                    </div>
                </div>
                <br>
                <div class="buttons">
                    <div class="pull-left">
                        <input type="submit" class="btn btn-primary" value="بررسی">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
