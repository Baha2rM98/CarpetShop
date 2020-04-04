@extends('admin.layout.master-auth')

@section('content')
    <div class="row" style="margin-right: 50px;">
        <!--Middle Part Start-->
        <div class="col-sm-9" id="content">
            <h1 class="title" style="color: #1d2124">ثبت نام</h1>
            <form class="form-horizontal" method="post" action="">
                @csrf
                <fieldset id="account">
                    <legend>اطلاعات شخصی</legend>
                    <div class="form-group required">
                        <label for="input-firstname" class="col-sm-2 control-label">نام</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-firstname" placeholder="نام" value=""
                                   name="name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-lastname" class="col-sm-2 control-label">نام خانوادگی</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-lastname" placeholder="نام خانوادگی"
                                   value="" name="last_name">
                            @if($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('last_name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-telephone" class="col-sm-2 control-label">شماره تلفن</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" id="input-telephone" placeholder="شماره تلفن"
                                   value="" name="phone_number">
                            @if($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('phone_number')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-email" class="col-sm-2 control-label">آدرس ایمیل</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="input-email" placeholder="آدرس ایمیل" value=""
                                   name="email">
                            @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('email')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="form-group required">
                        <label for="input-password" class="col-sm-2 control-label">رمز عبور</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="input-password" placeholder="رمز عبور"
                                   value="" name="password">
                            @if($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('password')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-confirm" class="col-sm-2 control-label">تکرار رمز عبور</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="input-confirm" placeholder="تکرار رمز عبور"
                                   value="" name="password_confirmation">
                            @if($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('password_confirmation')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </fieldset>
                <div class="buttons">
                    <div class="pull-left">
                        <input type="submit" class="btn btn-primary" value="ثبت نام">
                    </div>
                </div>
            </form>
        </div>
        <!--Middle Part End -->
    </div>
@endsection
