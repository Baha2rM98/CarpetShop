@extends('frontend.layout.master')

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
                                <li><a href="{{route('category.index', ['id' => $menu->id])}}">{{$menu->name}}</a>
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
    <div class="container">
            <div class="row">
                <div id="content" class="col-xs-12">
                    <div class="slideshow single-slider owl-carousel">
                        <div class="item"><img class="img-responsive" src="image/slider/banner-2.jpg" alt="banner 2"/>
                        </div>
                        <div class="item"><img class="img-responsive" src="image/slider/banner-1.jpg" alt="banner 1"/>
                        </div>
                    </div>
                    <div id="product-tab" class="product-tab">
                        <ul id="tabs" class="tabs">
                            <li><a href="#tab-product">جدیدترین محصولات</a></li>
                        </ul>
                        <div id="tab-product" class="tab_content">
                            <div class="owl-carousel product_carousel_tab">
                                @foreach($products as $product)
                                    <div class="product-thumb clearfix">
                                        <div class="image"><a
                                                    href="{{route('product.introduce', ['slug'=>$product->slug])}}"><img
                                                        src="{{$product->photos[0]->path}}" alt="{{$product->title}}"
                                                        title="{{$product->title}}" class="img-responsive"/></a></div>
                                        <div class="caption">
                                            <h4>
                                                <a href="{{route('product.introduce', ['slug'=>$product->slug])}}">{{$product->title}}</a>
                                            </h4>
                                            @if(isset($product->discount_price))
                                                <p class="price"><span
                                                            class="price-new">{{$product->discount_price}} تومان</span>
                                                    <span class="price-old">{{$product->price}} تومان</span><span
                                                            class="saving">{{round(abs((($product->price - $product->discount_price) / $product->price) * 100))}}%</span>
                                                </p>
                                            @else
                                                <p class="price">{{$product->price}}تومان </p>
                                            @endif
                                        </div>
                                        <div class="button-group">
                                            <a class="btn-primary"
                                               href="{{route('cart.add', ['id' => $product->id])}}"><span>افزودن به سبد</span></a>
                                            <div class="add-to-links">
                                                <br>
                                                <a href="" data-toggle="tooltip"> افزودن به علاقه مندی ها <i
                                                            class="fa fa-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
