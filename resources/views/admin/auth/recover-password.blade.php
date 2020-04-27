@extends('admin.layout.master-auth')
<title>صفحه مدیریت بازیابی رمزعبور</title>
@section('content')
    <div class="row" style="margin-right: 50px;">
        <div class="col-sm-9" id="content">
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-warning" style="margin-top: 40px">
                    <div>{{session('error')}}</div>
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
            <h2 class="title" style="color: #1d2124;">بازیابی رمزعبور</h2>
            <form class="form-horizontal" style="margin-top: 50px" method="post" action="{{route('admin.send.Vcode')}}">
                @csrf
                <div class="form-group required">
                    <label for="input-phone" class="col-sm-2 control-label" style="color: #1d2124">شماره موبایل</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" id="input-phone" placeholder="شماره موبایل"
                               name="phone_number">
                    </div>
                </div>
                <br>
                <div class="buttons">
                    <div class="pull-left">
                        <input type="submit" class="btn btn-primary" value="ارسال کد">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
