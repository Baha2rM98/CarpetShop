@extends('shop.layout.master')
<title>پروفایل - لیست علاقه مندی ها | فروشگاه اینترنتی کارپت مارکت</title>
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
        <aside id="column-right" class="col-sm-3 hidden-xs">
            <div class="list-group">
                <ul class="list-item">
                    <li><a href="">ویرایش پروفایل</a></li>
                    <li><a href="">لیست آدرس ها</a></li>
                    <li><a href="{{route('favorite.index')}}">لیست علاقه مندی</a></li>
                    <li><a href="">تاریخچه سفارشات</a></li>
                </ul>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            @if(isset($products[0]))
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">عکس</th>
                            <th class="text-center">نام محصول</th>
                            <th class="text-center">قیمت</th>
                            <th class="text-center">قیمت تخفیف</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(\Illuminate\Support\Facades\Session::has('deleted'))
                            <div class="alert alert-success">
                                <div>{{session('deleted')}}</div>
                            </div>
                        @endif
                        @foreach($products as $product)
                            <tr>
                                <td class="image" width="15%"><a href="{{route('product.introduce', ['sku'=>$product->sku])}}"><img class="img-responsive" src="{{$product->photos[0]->path}}"></a></td>
                                <td class="text-center"><a href="{{route('product.introduce', ['sku'=>$product->sku])}}">{{$product->title}}</a></td>
                                <td class="text-center">{{$product->price}}</td>
                                @if(isset($product->discount_price))
                                    <td class="text-center">{{$product->discount_price}}</td>
                                @else
                                    <td class="text-center">ندارد</td>
                                @endif
                                <td class="text-center">
                                    <div class="display-inline-block">
                                        <form method="post" name="_method" action="{{route('favorite.delete', ['id'=>$product->id])}}">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">حذف از علاقه مندی ها</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: center">{{$products->links()}}</div>
                </div>
            @else
                <br>
                <br>
                <div class="col-md-offset-3 label label-warning" style="font-size: x-large">محصولی جهت نمایش موجود نیست!</div>
            @endif
        </div>
    </div>
@endsection
