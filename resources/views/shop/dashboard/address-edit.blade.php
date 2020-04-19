@extends('shop.layout.master')
<title>پروفایل - آدرس ها | فروشگاه اینترنتی کارپت مارکت</title>
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
        <aside id="column-right" class="col-sm-3 hidden-xs">
            <h3 class="subtitle"><a href="{{route('user.dashboard')}}">{{$user->name . ' ' . $user->last_name. ' '}}</a>
            </h3>
            <div class="list-group">
                <ul class="list-item">
                    <li><a href="">ویرایش پروفایل</a></li>
                    <li><a href="{{route('address.index')}}">لیست آدرس ها</a></li>
                    <li><a href="{{route('address.create')}}">اضافه کردن آدرس</a></li>
                    <li><a href="{{route('favorite.index')}}">لیست علاقه مندی</a></li>
                    <li><a href="">تاریخچه سفارشات</a></li>
                </ul>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            <h2 style="font-size: x-large">ویرایش آدرس</h2>
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
                    <div class="alert alert-warning">
                        <div>{{session('error')}}</div>
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-md-offset-3">
                <form method="post" action="{{route('address.update', ['id'=>$address->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">آدرس</label>
                        <input type="text" name="address" class="form-control" value="{{$address->address}}"
                               placeholder="آدرس را وارد کنید...">
                    </div>
                    <div class="form-group">
                        <label for="name">کدپستی</label>
                        <input type="text" name="post_code" class="form-control" value="{{$address->post_code}}"
                               placeholder="کدپستی را وارد کنید...">
                    </div>
                    <div class="form-group">
                        <label for="name">استان</label>
                        <select class="form-control" name="province_id">
                            @foreach($provinces as $province)
                                <option value="{{$province->id}}"
                                        @if($address->province->id === $province->id) selected @endif>{{$province->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">شهر</label>
                        <select class="form-control" name="city_id">
                            @foreach($cities as $city)
                                <option value="{{$city->id}}"
                                        @if($address->city->id === $city->id) selected @endif>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">نوع</label>
                        <select name="primary" id="" class="form-control">
                            <option value="1" @if($address->primary === 1) selected @endif>
                                اصلی
                            </option>
                            <option value="0"
                                    @if($address->primary === 0) selected @endif>غیراصلی
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">شرکت</label>
                        <input type="text" name="company" class="form-control" value="{{$address->company}}"
                               placeholder="شرکت را وارد کنید...">
                    </div>
                    <button type="submit" class="btn btn-primary pull-left">ویرایش</button>
                </form>
            </div>
        </div>
    </div>
@endsection
