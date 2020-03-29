@extends('frontend.layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <!--Middle Part Start-->
            <div id="content" class="col-sm-9">
                <div itemscope>
                    <h1 class="title" itemprop="name">{{$product->title}}</h1>
                    <div class="row product-info">
                        <div class="col-sm-6">
                            <div class="image"><img class="img-responsive" style="display: block !important;" itemprop="image" id="zoom_01" src="{{$product->photos[0]->path}}" title="{{$product->title}}" data-zoom-image="{{$product->photos[0]->path}}"/> </div>
{{--                            <div class="center-block text-center"><span class="zoom-gallery"><i class="fa fa-search"></i></span></div>--}}
                            <div class="image-additional" id="gallery_01">
                                @foreach($product->photos as $photo)
                                    <a class="thumbnail" data-zoom-image="{{$photo->path}}" data-image="{{$photo->path}}" title="{{$product->title}}"> <img src="{{$photo->path}}" title="{{$product->title}}"/></a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled description">
                                <li><b>برند :</b> <a href="#"><span itemprop="brand">{{$product->brand->title}}</span></a></li>
                                <li><b>کد محصول :</b> <span itemprop="mpn">{{$product->sku}}</span></li>
                                <li><b>وضعیت موجودی :</b>
                                    @if($product->status === 1)
                                        <span class="instock">موجود</span>
                                    @else
                                        <span class="nostock">ناموجود</span>
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
                            <div id="product">
{{--                                <h3 class="subtitle">انتخاب های در دسترس</h3>--}}
{{--                                <div class="form-group required">--}}
{{--                                    <label class="control-label">رنگ</label>--}}
{{--                                    <select class="form-control" id="input-option200" name="option[200]">--}}
{{--                                        <option value=""> --- لطفا انتخاب کنید --- </option>--}}
{{--                                        <option value="4">مشکی </option>--}}
{{--                                        <option value="3">نقره ای </option>--}}
{{--                                        <option value="1">سبز </option>--}}
{{--                                        <option value="2">آبی </option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <br>
                                <div class="cart">
                                    <div>
                                        <a href="{{route('cart.add', ['id' => $product->id])}}" type="button" id="button-cart" class="btn btn-primary btn-lg">افزودن به سبد</a>
                                    </div>
                                    <div>
                                        <a href="" data-toggle="tooltip" style="margin-right: 50px"> افزودن به علاقه مندی ها <i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-description" data-toggle="tab">توضیحات</a></li>
                        <li><a href="#tab-specification" data-toggle="tab">مشخصات</a></li>
                        <li><a href="#tab-review" data-toggle="tab">بررسی</a></li>
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
{{--                            <form class="form-horizontal">--}}
{{--                                <div id="review">--}}
{{--                                    <div>--}}
{{--                                        <table class="table table-striped table-bordered">--}}
{{--                                            <tbody>--}}
{{--                                            <tr>--}}
{{--                                                <td style="width: 50%;"><strong><span>هاروی</span></strong></td>--}}
{{--                                                <td class="text-right"><span>1395/1/20</span></td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td colspan="2"><p>ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>--}}
{{--                                                    <div class="rating"> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> </div></td>--}}
{{--                                            </tr>--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                        <table class="table table-striped table-bordered">--}}
{{--                                            <tbody>--}}
{{--                                            <tr>--}}
{{--                                                <td style="width: 50%;"><strong><span>اندرسون</span></strong></td>--}}
{{--                                                <td class="text-right"><span>1395/1/20</span></td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td colspan="2"><p>ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>--}}
{{--                                                    <div class="rating"> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> </div></td>--}}
{{--                                            </tr>--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-right"></div>--}}
{{--                                </div>--}}
{{--                                <h2>یک بررسی بنویسید</h2>--}}
{{--                                <div class="form-group required">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="input-name" class="control-label">نام شما</label>--}}
{{--                                        <input type="text" class="form-control" id="input-name" value="" name="name">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group required">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label for="input-review" class="control-label">بررسی شما</label>--}}
{{--                                        <textarea class="form-control" id="input-review" rows="5" name="text"></textarea>--}}
{{--                                        <div class="help-block"><span class="text-danger">توجه :</span> HTML بازگردانی نخواهد شد!</div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group required">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <label class="control-label">رتبه</label>--}}
{{--                                        &nbsp;&nbsp;&nbsp; بد&nbsp;--}}
{{--                                        <input type="radio" value="1" name="rating">--}}
{{--                                        &nbsp;--}}
{{--                                        <input type="radio" value="2" name="rating">--}}
{{--                                        &nbsp;--}}
{{--                                        <input type="radio" value="3" name="rating">--}}
{{--                                        &nbsp;--}}
{{--                                        <input type="radio" value="4" name="rating">--}}
{{--                                        &nbsp;--}}
{{--                                        <input type="radio" value="5" name="rating">--}}
{{--                                        &nbsp;خوب</div>--}}
{{--                                </div>--}}
{{--                                <div class="buttons">--}}
{{--                                    <div class="pull-right">--}}
{{--                                        <button class="btn btn-primary" id="button-review" type="button">ادامه</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
                        </div>
                    </div>
                    <h3 class="subtitle">محصولات مرتبط</h3>
                    <div class="owl-carousel related_pro">
                        @foreach($relatedProducts as $product)
                            <div class="product-thumb">
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
                        @endforeach()
                    </div>
                </div>
            </div>
            <!--Middle Part End -->
            <!--Right Part Start -->
            <aside id="column-right" class="col-sm-3 hidden-xs">
                <h3 class="subtitle">پرفروش ها</h3>
                <div class="side-item">
                    <div class="product-thumb clearfix">
                        <div class="image"><a href="product.html"><img src="/image/product/sony_vaio_1-50x75.jpg" alt="کفش راحتی مردانه" title="کفش راحتی مردانه" class="img-responsive" /></a></div>
                        <div class="caption">
                            <h4><a href="product.html">کفش راحتی مردانه</a></h4>
                            <p class="price"> <span class="price-new">32000 تومان</span> <span class="price-old">12 میلیون تومان</span> <span class="saving">-25%</span> </p>
                        </div>
                    </div>
                </div>
            </aside>
            <!--Right Part End -->
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        // Elevate Zoom for Product Page image
        $("#zoom_01").elevateZoom({
            gallery:'gallery_01',
            cursor: 'pointer',
            galleryActiveClass: 'active',
            imageCrossfade: true,
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 500,
            zoomWindowPosition : 11,
            lensFadeIn: 500,
            lensFadeOut: 500,
            loadingIcon: 'image/progress.gif'
        });
        //////pass the images to swipebox
        $("#zoom_01").bind("click", function(e) {
            var ez =   $('#zoom_01').data('elevateZoom');
            $.swipebox(ez.getGalleryList());
            return false;
        });
    </script>
@endsection
