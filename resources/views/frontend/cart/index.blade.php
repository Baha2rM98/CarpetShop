@extends('frontend.layout.master')

@section('content')
    <div class="col-sm-12" id="app">
        <h1 class="title">سبد خرید</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td class="text-center">تصویر</td>
                    <td class="text-left">نام محصول</td>
                    <td class="text-left">کد محصول</td>
                    <td class="text-left">تعداد</td>
                    <td class="text-right">قیمت واحد</td>
                    <td class="text-right">کل</td>
                </tr>
                </thead>
                <tbody>
                    @if(is_null($cart))
                        <p class="alert-warning">سبد خرید شما خالی است.</p>
                    @else
                    @foreach($cart->items as $product)
                        <tr>
                            <td class="text-center" width="10%"><a href=""><img src="{{$product['item']->photos[0]->path}}" class="img-thumbnail" /></a></td>
                            <td class="text-left"><a href="">{{$product['item']->title}}</a></td>
                            <td class="text-left">{{$product['item']->sku}}</td>
                            <td class="text-left">
                                <div class="input-group btn-block quantity">
                                    <p><span class="label label-success">{{$product['quantity']}}</span></p>
                                    <span class="input-group-btn">
                                        <a class="btn btn-primary" href="{{route('cart.add', ['id' => $product['item']->id])}}"><i class="fa fa-plus"></i></a>
                                        <button type="button" data-toggle="tooltip" title="حذف" class="btn btn-danger" onClick="event.preventDefault();
                                                document.getElementById('remove-cart-item_{{$product['item']->id}}').submit();"><i class="fa fa-times-circle"></i></button>
                                    </span>
                                    <form id="remove-cart-item_{{$product['item']->id}}" action="{{ route('cart.remove', ['id' => $product['item']->id]) }}" method="post" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </td>
                            <td class="text-right">{{$product['item']->discount_price ? $product['item']->discount_price : $product['item']->price}} تومان</td>
                            <td class="text-right">{{$product['price']}} تومان</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <h2 class="subtitle">حالا مایلید چه کاری انجام دهید؟</h2>
        <p>در صورتی که کد تخفیف در اختیار دارید میتوانید از آن در اینجا استفاده کنید.</p>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">استفاده از کوپن تخفیف</h4>
                    </div>
                    <div id="collapse-coupon" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <label class="col-sm-4 control-label" for="input-coupon">کد تخفیف خود را در اینجا وارد کنید</label>
                            <div class="input-group">
                                <input type="text" name="coupon" value="" placeholder="کد تخفیف خود را در اینجا وارد کنید" id="input-coupon" class="form-control" />
                                <span class="input-group-btn">
                      <input type="button" value="اعمال کوپن" id="button-coupon" data-loading-text="بارگذاری ..."  class="btn btn-primary" />
                      </span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">پیش بینی هزینه ی حمل و نقل و مالیات</h4>
            </div>
            <div id="collapse-shipping" class="panel-collapse collapse in">
                <div class="panel-body">
                    <p>مقصد خود را جهت براورد وارد کنید.</p>
                    <form class="form-horizontal">
                        <select-city-province-component></select-city-province-component>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-postcode">کد پستی</label>
                            <div class="col-sm-10">
                                <input type="text" name="postcode" value="" placeholder="کد پستی" id="input-postcode" class="form-control" />
                            </div>
                        </div>
                        <input type="button" value="دریافت پیش فاکتور" id="button-quote" data-loading-text="بارگذاری ..." class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
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
            </div>
        </div>
        <div class="buttons">
            <div class="pull-left"><a href="{{url('/')}}" class="btn btn-default">ادامه خرید</a></div>
            <div class="pull-right"><a href="" class="btn btn-primary">تسویه حساب</a></div>
        </div>
    </div>
@endsection

@section('script-vuejs')
    <script src="{{asset('/admin/js/app.js')}}"></script>
@endsection
