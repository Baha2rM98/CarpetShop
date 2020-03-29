<html dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/image/favicon.png" rel="icon" />
    <title>فروشگاه اینترنتی دیجی فرش</title>
    <meta name="description" content="فروشگاه آنلاین فرش و تابلو فرش.">
    <!-- CSS Part Start-->
    <link rel="stylesheet" type="text/css" href="/js/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/js/bootstrap/css/bootstrap-rtl.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/stylesheet.css" />
    <link rel="stylesheet" type="text/css" href="/css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="/css/owl.transitions.css" />
    <link rel="stylesheet" type="text/css" href="/css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="/css/stylesheet-rtl.css" />
    <link rel="stylesheet" type="text/css" href="/css/responsive-rtl.css" />
    <link rel="stylesheet" type="text/css" href="/css/stylesheet-skin2.css" />
    <meta name="csrf_token" content="{{csrf_token()}}">
    <!-- CSS Part End-->
</head>
<body>
<div class="wrapper-wide">

    <div id="header">
        <!-- Top Bar Start-->
        <nav id="top" class="htop">
            <div class="container">
                <div class="row"> <span class="drop-icon visible-sm visible-xs"><i class="fa fa-align-justify"></i></span>
                    <div id="top-links" class="nav pull-right flip">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <ul>
                                <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">خروج</a></li>
                                <li><a href="{{route('user.dashboard')}}">{{\Illuminate\Support\Facades\Auth::user()->name}}</a></li>
                            </ul>
                            <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none">
                                @csrf
                            </form>
                        @else
                        <ul>
                            <li><a href="{{route('login')}}">ورود</a></li>
                            <li><a href="{{route('register')}}">ثبت نام</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <!-- Top Bar End-->
        <!-- Header Start-->
        <header class="header-row">
            <div class="container">
                <div class="table-container">
                    <!-- Logo Start -->
                    <div class="col-table-cell col-lg-6 col-md-6 col-sm-12 col-xs-12 inner">
                        <div id="logo"><a href="{{url('/')}}"><img class="img-responsive" src="/image/logo.png" title="MarketShop" alt="MarketShop" /></a></div>
                    </div>
                    <!-- Logo End -->
                    <!-- Mini Cart Start-->
                    <div class="col-table-cell col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div id="cart">
                            <button type="button" data-toggle="dropdown" class="heading dropdown-toggle">
                                <span class="cart-icon pull-left flip"></span>
                                <span id="cart-total">{{\Illuminate\Support\Facades\Session::has('cart') ? \Illuminate\Support\Facades\Session::get('cart')->totalQuantity. ' آیتم' : ''}} {{\Illuminate\Support\Facades\Session::has('cart') ? \Illuminate\Support\Facades\Session::get('cart')->totalPrice . ' تومان' : ''}}</span></button>
                            <ul class="dropdown-menu">
                                @if(\Illuminate\Support\Facades\Session::has('cart'))
                                    <li>
                                        <table class="table">
                                            @foreach(\Illuminate\Support\Facades\Session::get('cart')->items as $product)
                                                <tbody>
                                                <tr>
                                                    <td class="text-center" width="20%"><img class="img-thumbnail" src="{{$product['item']->photos[0]->path}}"></td>
                                                    <td class="text-left">{{$product['item']->title}}</td>
                                                    <td class="text-right">x {{$product['quantity']}}</td>
                                                    <td class="text-right">{{$product['price']}} تومان</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-xs remove" title="حذف" onclick="event.preventDefault();
                                                                document.getElementById('remove-cart-item_{{$product['item']->id}}').submit();" type="button"><i class="fa fa-times"></i></button>
                                                    </td>
                                                    <form id="remove-cart-item_{{$product['item']->id}}" action="{{ route('cart.remove', ['id' => $product['item']->id]) }}" method="post" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </tr>

                                                </tbody>
                                            @endforeach
                                        </table>
                                    </li>
                                    <li>
                                        <div>
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td class="text-right"><strong>جمع کل</strong></td>
                                                    <td class="text-right">{{\Illuminate\Support\Facades\Session::get('cart')->totalPurePrice}} تومان</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><strong>تخفیف</strong></td>
                                                    <td class="text-right">{{\Illuminate\Support\Facades\Session::get('cart')->totalDiscountPrice}} تومان</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><strong>قابل پرداخت</strong></td>
                                                    <td class="text-right">{{\Illuminate\Support\Facades\Session::get('cart')->totalPrice}} تومان</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <p class="checkout"><a href="{{route('cart.cart')}}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> مشاهده سبد</a></p>
                                        </div>
                                    </li>

                                @else
                                    <p>سبد خرید شما خالی است.</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- Mini Cart End-->
                    <!-- جستجو Start-->
                    <div class="col-table-cell col-lg-3 col-md-3 col-sm-6 col-xs-12 inner">
                        <div id="search" class="input-group">
                            <input id="filter_name" type="text" name="search" value="" placeholder="جستجو" class="form-control input-lg" />
                            <button type="button" class="button-search"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <!-- جستجو End-->
                </div>
            </div>
        </header>
        <!-- Header End-->
        <!-- Main آقایانu Start-->

        <nav id="menu" class="navbar">
            <div class="navbar-header"> <span class="visible-xs visible-sm"> منو <b></b></span></div>
            <div class="container">
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li><a class="home_link" title="خانه" href="{{url('/')}}">خانه</a></li>
                        <li class="dropdown"><a href="category.html">مد و زیبایی</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="category.html">آقایان <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته ها </a> </li>
                                                <li><a href="category.html">زیردسته ها </a> </li>
                                                <li><a href="category.html">زیردسته ها </a> </li>
                                                <li><a href="category.html">زیردسته ها </a> </li>
                                                <li><a href="category.html">زیردسته جدید </a> </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="category.html" >بانوان</a> </li>
                                    <li><a href="category.html">دخترانه<span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته ها </a></li>
                                                <li><a href="category.html">زیردسته جدید</a></li>
                                                <li><a href="category.html">زیردسته جدید</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="category.html">پسرانه</a></li>
                                    <li><a href="category.html">نوزاد</a></li>
                                    <li><a href="category.html">لوازم <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته های جدید</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown"> <a href="category.html">الکترونیکی</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li> <a href="category.html">لپ تاپ <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li> <a href="category.html">زیردسته های جدید </a> </li>
                                                <li> <a href="category.html">زیردسته های جدید </a> </li>
                                                <li> <a href="category.html">زیردسته جدید </a> </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li> <a href="category.html">رومیزی <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li> <a href="category.html">زیردسته های جدید </a> </li>
                                                <li> <a href="category.html">زیردسته جدید </a> </li>
                                                <li> <a href="category.html">زیردسته جدید </a> </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li> <a href="category.html">دوربین <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li> <a href="category.html">زیردسته های جدید</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="category.html">موبایل و تبلت <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته های جدید</a></li>
                                                <li><a href="category.html">زیردسته های جدید</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="category.html">صوتی و تصویری <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته های جدید </a> </li>
                                                <li><a href="category.html">زیردسته جدید </a> </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="category.html">لوازم خانگی</a> </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown"><a href="category.html">کفش</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="category.html">آقایان</a> </li>
                                    <li><a href="category.html">بانوان <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته های جدید </a> </li>
                                                <li><a href="category.html">زیردسته ها </a> </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="category.html">دخترانه</a> </li>
                                    <li><a href="category.html">پسرانه</a> </li>
                                    <li><a href="category.html">نوزاد</a> </li>
                                    <li><a href="category.html">لوازم <span>&rsaquo;</span></a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a href="category.html">زیردسته های جدید</a></li>
                                                <li><a href="category.html">زیردسته های جدید</a></li>
                                                <li><a href="category.html">زیردسته ها</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown"> <a href="category.html">ساعت</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li> <a href="category.html">ساعت مردانه</a></li>
                                    <li> <a href="category.html">ساعت زنانه</a></li>
                                    <li> <a href="category.html">ساعت بچگانه</a></li>
                                    <li> <a href="category.html">لوازم</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown"><a href="category.html">زیبایی و سلامت</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li> <a href="category.html">عطر و ادکلن</a></li>
                                    <li> <a href="category.html">آرایشی</a></li>
                                    <li> <a href="category.html">ضد آفتاب</a></li>
                                    <li> <a href="category.html">مراقبت از پوست</a></li>
                                    <li> <a href="category.html">مراقبت از چشم</a></li>
                                    <li> <a href="category.html">مراقبت از مو</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu_brands dropdown"><a href="#">برند ها</a>
                            <div class="dropdown-menu">
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/apple_logo-60x60.jpg" title="اپل" alt="اپل" /></a><a href="#">اپل</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/canon_logo-60x60.jpg" title="کنون" alt="کنون" /></a><a href="#">کنون</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"> <a href="#"><img src="/image/product/hp_logo-60x60.jpg" title="اچ پی" alt="اچ پی" /></a><a href="#">اچ پی</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/htc_logo-60x60.jpg" title="اچ تی سی" alt="اچ تی سی" /></a><a href="#">اچ تی سی</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/palm_logo-60x60.jpg" title="پالم" alt="پالم" /></a><a href="#">پالم</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/sony_logo-60x60.jpg" title="سونی" alt="سونی" /></a><a href="#">سونی</a> </div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/canon_logo-60x60.jpg" title="test" alt="test" /></a><a href="#">تست</a> </div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/apple_logo-60x60.jpg" title="test 3" alt="test 3" /></a><a href="#">تست 3</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/canon_logo-60x60.jpg" title="test 5" alt="test 5" /></a><a href="#">تست 5</a> </div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/canon_logo-60x60.jpg" title="test 6" alt="test 6" /></a><a href="#">تست 6</a></div>
                                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6"><a href="#"><img src="/image/product/apple_logo-60x60.jpg" title="test 7" alt="test 7" /></a><a href="#">تست 7</a> </div>


                            </div>
                        </li>
                        <li class="dropdown wrap_custom_block hidden-sm hidden-xs"><a>بلاک سفارشی</a>
                            <div class="dropdown-menu custom_block">
                                <ul>
                                    <li>
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td><img alt="" src="/image/banner/cms-block.jpg"></td>
                                                <td><img alt="" src="/image/banner/responsive.jpg"></td>
                                                <td><img alt="" src="/image/banner/cms-block.jpg"></td>
                                            </tr>
                                            <tr>
                                                <td><h4>بلاک های محتوا</h4></td>
                                                <td><h4>قالب واکنش گرا</h4></td>
                                                <td><h4>پشتیبانی ویژه</h4></td>
                                            </tr>
                                            <tr>
                                                <td>این یک بلاک مدیریت محتواست. شما میتوانید هر نوع محتوای html نوشتاری یا تصویری را در آن قرار دهید.</td>
                                                <td>این یک بلاک مدیریت محتواست. شما میتوانید هر نوع محتوای html نوشتاری یا تصویری را در آن قرار دهید.</td>
                                                <td>این یک بلاک مدیریت محتواست. شما میتوانید هر نوع محتوای html نوشتاری یا تصویری را در آن قرار دهید.</td>
                                            </tr>
                                            <tr>
                                                <td><strong><a class="btn btn-primary btn-sm" href="#">ادامه مطلب</a></strong></td>
                                                <td><strong><a class="btn btn-primary btn-sm" href="#">ادامه مطلب</a></strong></td>
                                                <td><strong><a class="btn btn-primary btn-sm" href="#">ادامه مطلب</a></strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown information-link"><a>برگه ها</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="login.html">ورود</a></li>
                                    <li><a href="register.html">ثبت نام</a></li>
                                    <li><a href="category.html">دسته بندی (شبکه/لیست)</a></li>
                                    <li><a href="product.html">محصولات</a></li>
                                    <li><a href="cart.html">سبد خرید</a></li>
                                    <li><a href="checkout.html">تسویه حساب</a></li>
                                    <li><a href="compare.html">مقایسه</a></li>
                                    <li><a href="wishlist.html">لیست آرزو</a></li>
                                    <li><a href="search.html">جستجو</a></li>
                                </ul>
                                <ul>
                                    <li><a href="about-us.html">درباره ما</a></li>
                                    <li><a href="404.html">404</a></li>
                                    <li><a href="elements.html">عناصر</a></li>
                                    <li><a href="faq.html">سوالات متداول</a></li>
                                    <li><a href="sitemap.html">نقشه سایت</a></li>
                                    <li><a href="contact-us.html">تماس با ما</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="custom-link-right"><a href="#" target="_blank"> همین حالا بخرید!</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main آقایانu End-->
    </div>


    <div id="container">
        <div class="container">
            @yield('content')
        </div>
    </div>


    <!--Footer Start-->
    <footer id="footer">
        <div class="fpart-first">
            <div class="container">
                <div class="row">
                    <div class="contact col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <h5>درباره دیجی فرش</h5>
                        <p>دیچی فرش یک فروشگاه آنلاین فرش و تابلو فرش است که...</p>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>اطلاعات</h5>
                        <ul>
                            <li><a href="about-us.html">درباره ما</a></li>
                            <li><a href="about-us.html">حریم خصوصی</a></li>
                            <li><a href="about-us.html">شرایط و قوانین</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>خدمات مشتریان</h5>
                        <ul>
                            <li><a href="contact-us.html">تماس با ما</a></li>
                            <li><a href="sitemap.html">نقشه سایت</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="fpart-second">
            <div class="container">
                <div id="powered" class="clearfix">
                    <div class="powered_text pull-left flip">
                        <p>کلیه حقوق محفوظ است © Digi Carpet</p>
                    </div>
                    <div class="social pull-right flip"> <a href="#" target="_blank"> <img data-toggle="tooltip" src="/image/socialicons/facebook.png" alt="Facebook" title="Facebook"></a></div>
                </div>
            </div>
        </div>
        <div id="back-top"><a data-toggle="tooltip" title="بازگشت به بالا" href="javascript:void(0)" class="backtotop"><i class="fa fa-chevron-up"></i></a></div>
    </footer>
    <!--Footer End-->

</div>
@yield('script-vuejs')
<!-- JS Part Start-->
<script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.easing-1.3.min.js"></script>
<script type="text/javascript" src="/js/jquery.dcjqaccordion.min.js"></script>
<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/js/jquery.elevateZoom-3.0.8.min.js"></script>
<script type="text/javascript" src="/js/swipebox/lib/ios-orientationchange-fix.js"></script>
<script type="text/javascript" src="/js/swipebox/src/js/jquery.swipebox.min.js"></script>
<script type="text/javascript" src="/js/custom.js"></script>
<!-- JS Part End-->
@yield('script')
</body>
</html>
