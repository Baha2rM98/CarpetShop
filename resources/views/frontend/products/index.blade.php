@extends('frontend.layout.master')
<title>مشخصات، قیمت و خرید {{' '}} {{$product->title}}</title>
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
    <div class="container">
        <div class="row">
            <!--Middle Part Start-->
            <div id="content" class="col-sm-9">
                <div itemscope>
                    <h1 class="title" itemprop="name">{{$product->title}}</h1>
                    <div class="row product-info">
                        <div class="col-sm-6">
                            <div class="image"><img class="img-responsive" style="display: block !important;"
                                                    itemprop="image" id="zoom_01" src="{{$product->photos[0]->path}}"
                                                    title="{{$product->title}}"
                                                    data-zoom-image="{{$product->photos[0]->path}}"/></div>
                            <div class="image-additional" id="gallery_01">
                                @foreach($product->photos as $photo)
                                    <a class="thumbnail" data-zoom-image="{{$photo->path}}"
                                       data-image="{{$photo->path}}" title="{{$product->title}}"> <img
                                                src="{{$photo->path}}" title="{{$product->title}}"/></a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled description">
                                <li><b>برند :</b> <span class="label label-warning" style="font-size: small;"><span itemprop="brand">{{$product->brand->title}}</span></span></li>
                                <li><b>کد محصول :</b> <span itemprop="mpn" style="font-size: large;">{{$product->sku}}</span></li>
                                <li><b>وضعیت موجودی :</b>
                                    @if($product->status === 1)
                                        <span class="instock" style="font-size: small;">موجود</span>
                                    @else
                                        <span class="nostock" style="font-size: small;">ناموجود</span>
                                    @endif
                                </li>
                            </ul>
                            <ul class="price-box">
                                <li class="price" itemprop="offers">
                                    @if(isset($product->discount_price))
                                        <span class="price-old">{{$product->price}} تومان</span>
                                        <span itemprop="price">{{$product->discount_price}} تومان
                                        <span itemprop="availability" content="موجود"></span>
                                    </span>
                                    @else
                                        <span class="price">{{$product->price}} تومان</span>
                                    @endif
                                </li>
                            </ul>
                            <a href="{{route('cart.add', ['id' => $product->id])}}" type="button" id="button-cart" class="btn btn-primary btn-lg">افزودن به سبد</a>
                            <div class="btn-group btn" style="padding-right: 50px">
                                <button type="button" class="fa fa-heart" data-toggle="tooltip" style="color: goldenrod" title="افزودن به علاقه مندی ها" onClick="event.preventDefault();document.getElementById('favorite-add-{{$product->id}}').submit();"></button>
                                <form id="favorite-add-{{$product->id}}" action="{{route('favorite.add', ['id'=>$product->id])}}" method="post" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-description" data-toggle="tab">توضیحات</a></li>
                        <li><a href="#tab-specification" data-toggle="tab">مشخصات</a></li>
                        <li><a href="#tab-review" data-toggle="tab">نظرات کاربران</a></li>
                    </ul>
                    <div class="tab-content">
                        <div itemprop="description" id="tab-description" class="tab-pane active">
                            <div>
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div id="tab-specification" class="tab-pane">
                            <div id="tab-specification" class="tab-pane">
                                <table class="table table-bordered">
                                    <tbody>
                                    @foreach($product->attributeValues as $attribute)
                                        <tr>
                                            <td>{{$attribute->attributeGroup->title}}</td>
                                            <td>{{$attribute->title}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab-review" class="tab-pane">
                            <div class="form-horizontal">
                                <div id="review">
                                    <div>
                                        @foreach($comments as $comment)
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <strong><span>{{$comment->user->name . ' ' . $comment->user->last_name}}</span></strong>
                                                    </td>
                                                    <td class="text-right"><span>{{$comment->created_at}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><p>{{$comment->comment}}</p>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    </div>
                                    <div class="text-right"></div>
                                </div>
                                <h2>نظر خود را در مورد محصول مطرح نمایید</h2>
                                <div class="form-group required">
                                    <form class="form-group required" method="post"
                                          action="{{route('comment.post', ['productId' => $product->id])}}">
                                        @csrf
                                        <div class="col-sm-12">
                                            <label for="input-review" class="control-label">نظر شما</label>
                                            <textarea class="form-control" id="input-review" rows="5"
                                                      name="comment"></textarea>
                                        </div>
                                        <div class="buttons">
                                            <div class="pull-right">
                                                <button class="btn btn-primary" id="button-review" type="submit">ثبت
                                                    نظر
                                                </button>
                                            </div>
                                        </div>
                                        @if($errors->any())
                                            <div class="alert alert-warning">
                                                @foreach($errors->all() as $error)
                                                    {{$error}}
                                                @endforeach
                                            </div>
                                        @endif
                                        @if(\Illuminate\Support\Facades\Session::has('commented'))
                                            <div class="alert alert-success">
                                                <div>{{session('commented')}}</div>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="subtitle">محصولات مرتبط</h3>
                    <div class="owl-carousel related_pro">
                        @foreach($relatedProducts as $product)
                            <div class="product-thumb">
                                <div class="image"><a
                                            href="{{route('product.introduce', ['sku'=>$product->sku])}}"><img
                                                src="{{$product->photos[0]->path}}" alt="{{$product->title}}"
                                                title="{{$product->title}}" class="img-responsive"/></a></div>
                                <div class="caption">
                                    <h4>
                                        <a href="{{route('product.introduce', ['sku'=>$product->sku])}}">{{$product->title}}</a>
                                    </h4>
                                    @if(isset($product->discount_price))
                                        <p class="price"><span
                                                    class="price-new">{{$product->discount_price}} تومان</span> <span
                                                    class="price-old">{{$product->price}} تومان</span><span
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
                                        <button type="button" class="fa fa-heart" data-toggle="tooltip" style="color: goldenrod" title="افزودن به علاقه مندی ها" onClick="event.preventDefault();document.getElementById('favorite-add-{{$product->id}}').submit();"></button>
                                        <form id="favorite-add-{{$product->id}}" action="{{route('favorite.add', ['id'=>$product->id])}}" method="post" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach()
                    </div>
                </div>
            </div>
            {{--            <aside id="column-right" class="col-sm-3 hidden-xs">--}}
            {{--                <h3 class="subtitle">پرفروش ها</h3>--}}
            {{--                <div class="side-item">--}}
            {{--                    <div class="product-thumb clearfix">--}}
            {{--                        <div class="image"><a href="product.html"><img src="/image/product/sony_vaio_1-50x75.jpg" alt="کفش راحتی مردانه" title="کفش راحتی مردانه" class="img-responsive" /></a></div>--}}
            {{--                        <div class="caption">--}}
            {{--                            <h4><a href="product.html">کفش راحتی مردانه</a></h4>--}}
            {{--                            <p class="price"> <span class="price-new">32000 تومان</span> <span class="price-old">12 میلیون تومان</span> <span class="saving">-25%</span> </p>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </aside>--}}
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        // Elevate Zoom for Product Page image
        $("#zoom_01").elevateZoom({
            gallery: 'gallery_01',
            cursor: 'pointer',
            galleryActiveClass: 'active',
            imageCrossfade: true,
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 500,
            zoomWindowPosition: 11,
            lensFadeIn: 500,
            lensFadeOut: 500,
            loadingIcon: 'image/progress.gif'
        });
        //////pass the images to swipebox
        $("#zoom_01").bind("click", function (e) {
            var ez = $('#zoom_01').data('elevateZoom');
            $.swipebox(ez.getGalleryList());
            return false;
        });
    </script>
@endsection
