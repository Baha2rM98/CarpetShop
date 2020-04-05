@extends('admin.layout.master-auth')
<title>صفحه مدیریت ورود</title>
@section('content')
    <div class="row" style="margin-right: 50px;">
        <!--Middle Part Start-->
        <div class="col-sm-9" id="content">
            @if(\Illuminate\Support\Facades\Session::has('ok'))
                <div class="alert alert-success" style="margin-top: 40px">
                    <div>{{session('ok')}}</div>
                </div>
            @endif
                @if(\Illuminate\Support\Facades\Session::has('email'))
                    <div class="alert alert-error" style="margin-top: 40px">
                        <div>{{session('email')}}</div>
                    </div>
                @endif
            <h2 class="title" style="color: #1d2124;">ورود</h2>
            <form class="form-horizontal" style="margin-top: 50px" method="post" action="{{route('admin.login')}}">
                @csrf
                    <div class="form-group required">
                        <label for="input-email" class="col-sm-2 control-label" style="color: #1d2124">آدرس ایمیل</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="input-email" placeholder="آدرس ایمیل" value=""
                                   name="email">
                            @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong style="color: #1d2124">{{$errors->first('email')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-password" class="col-sm-2 control-label" style="color: #1d2124">رمز عبور</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="input-password" placeholder="رمز عبور"
                                   value="" name="password">
                            @if($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                <strong style="color: #1d2124">{{$errors->first('password')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                <div class="buttons">
                    <div class="pull-left">
                        <input type="submit" class="btn btn-primary" value="ورود">
                    </div>
                </div>
            </form>
        </div>
        <!--Middle Part End -->
    </div>
@endsection
