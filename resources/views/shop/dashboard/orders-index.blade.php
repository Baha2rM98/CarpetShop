@extends('shop.layout.master')
<title>پروفایل - سفارشات | فروشگاه اینترنتی کارپت مارکت</title>
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
            @if(isset($orders[0]))
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">کد سفارش</th>
                            <th class="text-center">وضعیت پرداخت</th>
                            <th class="text-center">نام تحویل گیرنده</th>
                            <th class="text-center">شماره تماس تحویل گیرنده</th>
                            <th class="text-center">تعداد مرسوله</th>
                            <th class="text-center">کد مرسوله</th>
                            <th class="text-center">تخفیف کوپن</th>
                            <th class="text-center">مبلغ قابل پرداخت</th>
                            <th class="text-center">تاریخ ثبت سغارش</th>
                            <th class="text-center">آدرس</th>
                            <th class="text-center">تکمیل پرداخت</th>
                            <th class="text-center">حذف سفارش</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(\Illuminate\Support\Facades\Session::has('error'))
                            <div class="alert alert-warning">
                                <div>{{session('error')}}</div>
                            </div>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::has('ok'))
                            <div class="alert alert-success">
                                <div>{{session('ok')}}</div>
                            </div>
                        @endif
                        @foreach($orders as $order)
                            @php $count = 0 @endphp
                            <tr>
                                <td class="text-center"><a href="{{route('order.details', ['id'=>$order->id])}}">{{$order->order_code}}</a></td>
                                @if($order->status === 1)
                                    <td class="text-center"><span class="label label-success">پرداخت شده</span></td>
                                @else
                                    <td class="text-center"><span class="label label-danger">پرداخت نشده</span></td>
                                @endif
                                <td class="text-center">{{$user->name . ' ' . $user->last_name}}</td>
                                <td class="text-center">{{$user->phone_number}}</td>
                                @foreach($order->products as $product)
                                    @php $count += intval($product->pivot->quantity) @endphp
                                @endforeach
                                <td class="text-center">{{$count}}</td>
                                <td class="text-center">{{$order->product_postcode}}</td>
                                @if(isset($order->coupon_discount))
                                <td class="text-center">{{$order->coupon_discount}}</td>
                                @else
                                    <td class="text-center">ندارد</td>
                                @endif
                                <td class="text-center">{{$order->price}}</td>
                                <td class="text-center">{{$order->created_at}}</td>
                                <td class="text-center">{{$order->address->province->name.' - '.$order->address->city->name.' - '.$order->address->address}}</td>
                                @if($order->status === 0)
                                    <td class="text-center"><a href="{{route('reckoning.unpaid', ['id'=>$order->id])}}" class="btn btn-primary">تکمیل پرداخت</a></td>
                                @endif
                                @if($order->status === 0)
                                    <td class="text-center">
                                        <div class="display-inline-block">
                                            <form method="post" name="_method" action="{{route('remove.order', ['id'=>$order->id])}}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @php $count = 0 @endphp
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: center">{{$orders->links()}}</div>
                </div>
            @else
                <br>
                <br>
                <div class="col-md-offset-3 label label-warning" style="font-size: x-large">سفارشی جهت نمایش موجود نیست!</div>
            @endif
        </div>
    </div>
@endsection
