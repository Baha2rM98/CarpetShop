@extends('shop.layout.master')
<title>بازیابی رمزعبور | فروشگاه اینترنتی کارپت مارکت</title>
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
                                    <li>
                                        <a href="{{route('category.index', ['slug' => $menu->slug])}}">{{$menu->name}}</a>
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
                @if($errors->any())
                    <ul>
                        <div class="alert alert-warning">
                            @foreach($errors->all() as $error)
                                <ul>{{$error}}</ul>
                            @endforeach
                        </div>
                    </ul>
                @endif
            <div class="row" style="margin-right: 100px; margin-top: 50px">
                <div class="col-sm-6">
                    <form method="post" action="{{route('recover.password', ['email' => request('email')])}}">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="input-email">رمزعبور جدید</label>
                            <input type="password" name="new_password" placeholder="رمزعبور جدید را وارد کنید..." class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="input-email">تکرار رمزعبور جدید</label>
                            <input type="password" name="confirm_new_password" placeholder="رمزعبور جدید را تکرار کنید..." class="form-control"/>
                        </div>
                        <input type="submit" value="ذخیره" class="btn btn-primary"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
