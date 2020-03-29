@extends('frontend.layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <!--Middle Part Start-->
            <div id="content" class="col-xs-12">
                <!-- Slideshow Start-->
                <div class="slideshow single-slider owl-carousel">
                    <div class="item"> <img class="img-responsive" src="image/slider/banner-2.jpg" alt="banner 2" /> </div>
                    <div class="item"> <img class="img-responsive" src="image/slider/banner-1.jpg" alt="banner 1" /> </div>
                </div>
                <!-- Slideshow End-->
                <!-- محصولات Tab Start -->
                <div id="product-tab" class="product-tab">
                    <ul id="tabs" class="tabs">
                        <li><a href="#tab-product">محصولات</a></li>
                    </ul>
                    <div id="tab-product" class="tab_content">
                        <div class="owl-carousel product_carousel_tab">
                            @foreach($products as $product)
                                <div class="product-thumb clearfix">
                                    <div class="image"><a href="{{route('product.introduce', ['slug'=>$product->slug])}}"><img src="{{$product->photos[0]->path}}" alt="{{$product->title}}" title="{{$product->title}}" class="img-responsive" /></a></div>
                                    <div class="caption">
                                        <h4><a href="{{route('product.introduce', ['slug'=>$product->slug])}}">{{$product->title}}</a></h4>
                                        @if(isset($product->discount_price))
                                            <p class="price"><span class="price-new">{{$product->discount_price}} تومان</span> <span class="price-old">{{$product->price}} تومان</span><span class="saving">{{round(abs((($product->price - $product->discount_price) / $product->price) * 100))}}%</span></p>
                                        @else
                                            <p class="price">{{$product->price}}تومان </p>
                                        @endif
                                    </div>
                                    <div class="button-group">
                                        <a class="btn-primary" href="{{route('cart.add', ['id' => $product->id])}}"><span>افزودن به سبد</span></a>
                                        <div class="add-to-links">
                                            <br>
                                            <a href="" data-toggle="tooltip"> افزودن به علاقه مندی ها <i class="fa fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>    <!-- محصولات Tab Start -->

                <!-- دسته ها محصولات Slider Start -->
                <h3 class="subtitle">دسته بندی ها - <a class="viewall" href="category.html">نمایش همه</a></h3>
                <div class="owl-carousel latest_category_carousel">
                    <div class="product-thumb">
                        <div class="image"><a href="product.html"><img src="image/product/iphone_6-220x330.jpg" alt="کرم مو آقایان" title="کرم مو آقایان" class="img-responsive" /></a></div>
                        <div class="caption">
                            <h4><a href="product.html">کرم مو آقایان</a></h4>
                            <p class="price"> 42300 تومان </p>
                            <div class="rating"> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> </div>
                        </div>
                        <div class="button-group">
                            <button class="btn-primary" type="button" onClick=""><span>افزودن به سبد</span></button>
                            <div class="add-to-links">
                                <button type="button" data-toggle="tooltip" title="افزودن به علاقه مندی" onClick=""><i class="fa fa-heart"></i></button>
                                <button type="button" data-toggle="tooltip" title="افزودن به مقایسه" onClick=""><i class="fa fa-exchange"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- دسته ها محصولات Slider End -->

                <!-- برند Logo Carousel Start-->
{{--                <div id="carousel" class="owl-carousel nxt">--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/apple_logo-100x100.jpg" alt="پالم" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/canon_logo-100x100.jpg" alt="سونی" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/apple_logo-100x100.jpg" alt="کنون" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/canon_logo-100x100.jpg" alt="اپل" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/apple_logo-100x100.jpg" alt="اچ تی سی" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/canon_logo-100x100.jpg" alt="اچ پی" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/apple_logo-100x100.jpg" alt="brand" class="img-responsive" /></a> </div>--}}
{{--                    <div class="item text-center"> <a href="#"><img src="image/product/canon_logo-100x100.jpg" alt="brand1" class="img-responsive" /></a> </div>--}}
{{--                </div>--}}
                <!-- برند Logo Carousel End -->
            </div>
            <!--Middle Part End-->
        </div>
    </div>
@endsection
