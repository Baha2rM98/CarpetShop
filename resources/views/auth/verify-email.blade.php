@extends('shop.layout.master')
<title>تایید نام کاربری | فروشگاه اینترنتی کارپت مارکت</title>
@section('menu')
    <nav id="menu" class="navbar">
        <div class="navbar-header"><span class="visible-xs visible-sm"> منو <b></b></span></div>
        <div class="container">
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a class="home_link" title="خانه" href="{{url('/')}}">خانه</a></li>
                    <li class="dropdown"><a>دسته بندی ها <span>&rsaquo;</span></a>
                        <div class="dropdown-menu">
                            @foreach($menus as $menu)
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('category.index', ['slug' => $menu->slug])}}">{{$menu->name}}</a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div id="content" class="col-sm-9">
            @if(\Illuminate\Support\Facades\Session::has('failure'))
                <div class="alert alert-warning">
                    <div>{{session('failure')}}</div>
                </div>
            @endif
            <h1 class="title">حساب کاربری ورود</h1>
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="subtitle">مشتری جدید</h2>
                    <p><strong>ثبت نام حساب کاربری</strong></p>
                    <p>با ایجاد حساب کاربری میتوانید سریعتر خرید کرده، از وضعیت خرید خود آگاه شده و تاریخچه ی سفارشات خود را مشاهده کنید.</p>
                    <a href="{{route('register')}}" class="btn btn-primary">ادامه</a> </div>
                <div class="col-sm-6">
                    <h2 class="subtitle">نام کاربری یا ایمیل خود را فراموش کرده اید؟</h2>
                    <p><strong>ایمیل خود را وارد کنید...</strong></p>
                    <form method="post" action="{{route('verify.email')}}">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="input-email">آدرس ایمیل</label>
                            <input type="email" name="email" value="" placeholder="آدرس ایمیل" class="form-control" />
                        </div>
                        <input type="submit" value="بررسی" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
