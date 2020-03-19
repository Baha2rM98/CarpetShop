@extends('frontend.layout.master')

@section('content')
    <div class="row">
        <!--Middle Part Start-->
        <div class="col-sm-9" id="content">
            <h1 class="title">ثبت نام حساب کاربری</h1>
            <p>اگر قبلا حساب کاربریتان را ایجاد کرد اید جهت ورود به <a href="{{route('login')}}">صفحه لاگین</a> مراجعه
                کنید.</p>
            <form class="form-horizontal" method="post" action="{{route('user.register')}}">
                @csrf
                <fieldset id="account">
                    <legend>اطلاعات شخصی شما</legend>
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
                    <div class="form-group">
                        <label for="input-fax" class="col-sm-2 control-label">کدملی</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-fax" placeholder="کدملی" value=""
                                   name="national_code">
                            @if($errors->has('national_code'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('national_code')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </fieldset>
                <fieldset id="address">
                    <legend>آدرس</legend>
                    <div class="form-group">
                        <label for="input-company" class="col-sm-2 control-label">شرکت</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-company" placeholder="شرکت" value=""
                                   name="company">
                            @if($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('company')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-address-1" class="col-sm-2 control-label">آدرس</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-address" placeholder="آدرس" value=""
                                   name="address">
                            @if($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('address')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="input-postcode" class="col-sm-2 control-label">کد پستی</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-postcode" placeholder="کد پستی" value=""
                                   name="post_code">
                            @if($errors->has('post_code'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('post_code')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <select-city-province-component></select-city-province-component>
                    <div class="col-sm-10" style="margin-right: 129px">
                        @if($errors->has('province'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('province')}}</strong>
                            </span>
                        @endif
                        @if($errors->has('city'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('city')}}</strong>
                            </span>
                        @endif
                    </div>
                </fieldset>
{{--                <div class="form-group required" style="right: 1000px">--}}
{{--                </div>--}}
                <fieldset>
                    <legend>رمز عبور شما</legend>
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
                    <div class="pull-right">
                        <input type="submit" class="btn btn-primary" value="ثبت نام">
                    </div>
                </div>
            </form>
        </div>
        <!--Middle Part End -->
    </div>
@endsection

@section('script-vuejs')
    <script src="{{asset('/admin/js/app.js')}}"></script>
@endsection
