@extends('frontend.layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <!--Left Part Start -->
            <aside id="column-left" class="col-sm-3 hidden-xs">
                <h3 class="subtitle">دسته ها</h3>
                <div class="categories">
                    <ul id="cat_accordion">
                        @foreach($items as $item)
                            <li><a href="{{route('category.index', ['id' => $item->id])}}">{{$item->name}}</a><span class="down"></span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
            <!--Left Part End -->
            <!--Middle Part Start-->
            <div id="content" class="col-sm-9">
                <h1 class="title">{{$category->name}}</h1>

                <div class="product-filter">
                    <div class="row">
                        <div class="col-md-4 col-sm-5">
                            <div class="btn-group">
                                <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="List"><i class="fa fa-th-list"></i></button>
                                <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Grid"><i class="fa fa-th"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-2 text-right">
                            <label class="control-label" for="input-sort">مرتب سازی :</label>
                        </div>
                        <div class="col-md-3 col-sm-2 text-right">
                            <select id="input-sort" class="form-control col-sm-3">
                                <option value="" selected="selected">پیشفرض</option>
                                <option value="">نام (الف - ی)</option>
                                <option value="">نام (ی - الف)</option>
                                <option value="">قیمت (کم به زیاد)</option>
                                <option value="">قیمت (زیاد به کم)</option>
                                <option value="">امتیاز (بیشترین)</option>
                                <option value="">امتیاز (کمترین)</option>
                                <option value="">مدل (A - Z)</option>
                                <option value="">مدل (Z - A)</option>
                            </select>
                        </div>
                        <div class="col-sm-1 text-right">
                            <label class="control-label" for="input-limit">نمایش :</label>
                        </div>
                        <div class="col-sm-2 text-right">
                            <select id="input-limit" class="form-control">
                                <option value="" selected="selected">20</option>
                                <option value="">25</option>
                                <option value="">50</option>
                                <option value="">75</option>
                                <option value="">100</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row products-category">
                    <div class="product-layout product-list col-xs-12">
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
                <div class="row">
                    <div class="col-sm-12 text-center">
                        {{$products->links()}}
                    </div>
                </div>
            </div>
            <!--Middle Part End -->
        </div>
    </div>
@endsection
