@extends('shop.layout.master')
<title>پروفایل - سفارش {{$order->order_code}} | فروشگاه اینترنتی کارپت مارکت</title>
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
                    <li><a href="{{route('profile.edit')}}">ویرایش پروفایل</a></li>
                    <li><a href="{{route('address.index')}}">لیست آدرس ها</a></li>
                    <li><a href="{{route('address.create')}}">اضافه کردن آدرس</a></li>
                    <li><a href="{{route('favorite.index')}}">لیست علاقه مندی</a></li>
                    <li><a href="{{route('order.index')}}">تاریخچه سفارشات</a></li>
                </ul>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th class="text-center">عکس محصول</th>
                        <th class="text-center">نام محصول</th>
                        <th class="text-center">قیمت واحد</th>
                        <th class="text-center">کد محصول</th>
                        <th class="text-center">تعداد</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td class="image" width="15%"><a href="{{route('product.introduce', ['sku'=>$product->sku])}}"><img class="img-responsive" src="{{$product->photos[0]->path}}"></a></td>
                            <td class="text-center"><a href="{{route('product.introduce', ['sku'=>$product->sku])}}">{{$product->title}}</a></td>
                            @if(isset($product->discount_price))
                                <td class="text-center">{{$product->discount_price}}</td>
                            @else
                                <td class="text-center">{{$product->price}}</td>
                            @endif
                            <td class="text-center">{{$product->sku}}</td>
                            <td class="text-center">{{$product->pivot->quantity}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
