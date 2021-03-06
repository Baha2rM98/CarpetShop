<html dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/image/favicon.png" rel="icon" />
    <title>فروشگاه اینترنتی کارپت مارکت</title>
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
                        <div id="logo"><a href="{{url('/')}}"><img class="img-responsive" width="220" height="50" src="/image/logo.png" title="کارپت مارکت" alt="کارپت مارکت" /></a></div>
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
        @yield('menu')
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
                        <h5>درباره کارپت مارکت</h5>
                        <p>کارپت مارکت یک فروشگاه آنلاین فرش و تابلو فرش است که...</p>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>اطلاعات</h5>
                        <ul>
                            <li><a href="">درباره ما</a></li>
                            <li><a href="">حریم خصوصی</a></li>
                            <li><a href="">شرایط و قوانین</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>خدمات مشتریان</h5>
                        <ul>
                            <li><a href="">تماس با ما</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="fpart-second">
            <div class="container">
                <div id="powered" class="clearfix">
                    <div class="powered_text pull-left flip">
                        <p>کلیه حقوق محفوظ است © Carpet Market</p>
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
