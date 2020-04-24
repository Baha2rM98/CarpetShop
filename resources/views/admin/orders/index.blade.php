@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - سفارشات</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">سفارشات</h3>
            </div>
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('orders'))
                    <div class="alert alert-success">
                        <div>{{session('orders')}}</div>
                    </div>
                @endif
                @if(isset($orders[0]))
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th class="text-center">وضعیت سفارش</th>
                                <th class="text-center">کد سفارش</th>
                                <th class="text-center">وضعیت پرداخت</th>
                                <th class="text-center">نام تحویل گیرنده</th>
                                <th class="text-center">شماره تماس تحویل گیرنده</th>
                                <th class="text-center">تعداد مرسوله</th>
                                <th class="text-center">کد مرسوله</th>
                                <th class="text-center">تخفیف کوپن</th>
                                <th class="text-center">عنوان کوپن</th>
                                <th class="text-center">مبلغ قابل پرداخت</th>
                                <th class="text-center">تاریخ ثبت سفارش</th>
                                <th class="text-center">استان</th>
                                <th class="text-center">شهر</th>
                                <th class="text-center">آدرس</th>
                                <th class="text-center">اطلاعات پرداخت(RefID)</th>
                                <th class="text-center"> اطلاعات پرداخت(authority)</th>
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
                                    @if(is_null($order->deleted_at))
                                        <td class="text-center"><span class="label label-success">فعال</span></td>
                                    @else
                                        <td class="text-center"><span class="label label-danger">حذف شده</span></td>
                                    @endif
                                    @if($order->status === 1)
                                        <td class="text-center"><a href="{{route('admin.order.products', ['id'=>$order->id])}}">{{$order->order_code}}</a></td>
                                    @else
                                        <td class="text-center">{{$order->order_code}}</td>
                                    @endif
                                    @if($order->status === 1)
                                        <td class="text-center"><span class="label label-success">پرداخت شده</span></td>
                                    @else
                                        <td class="text-center"><span class="label label-danger">پرداخت نشده</span></td>
                                    @endif
                                    <td class="text-center">{{$order->user->name . ' ' . $order->user->last_name}}</td>
                                    <td class="text-center">{{$order->user->phone_number}}</td>
                                    @foreach($order->products as $product)
                                        @php $count += intval($product->pivot->quantity) @endphp
                                    @endforeach
                                    <td class="text-center">{{$count}}</td>
                                    @if(isset($order->product_postcode))
                                        <td class="text-center">{{$order->product_postcode}}</td>
                                    @else
                                        <td class="text-center">هنوز تنظیم نشده است.</td>
                                    @endif
                                    @if(isset($order->coupon_discount))
                                        <td class="text-center">{{$order->coupon_discount}}</td>
                                    @else
                                        <td class="text-center">ندارد</td>
                                    @endif
                                    @if(isset($order->coupon->title))
                                        <td class="text-center">{{$order->coupon->title}}</td>
                                    @else
                                        <td class="text-center">ندارد</td>
                                    @endif
                                    <td class="text-center">{{$order->price}}</td>
                                    <td class="text-center">{{$order->created_at}}</td>
                                    <td class="text-center">{{$order->address->province->name}}</td>
                                    <td class="text-center">{{$order->address->city->name}}</td>
                                    <td class="text-center">{{$order->address->address}}</td>
                                    @if($order->status === 1)
                                        <td class="text-center">{{$order->payment->refId}}</td>
                                        <td class="text-center">{{$order->payment->authority}}</td>
                                    @else
                                        <td class="text-center"><span class="label label-danger">ندارد</span></td>
                                        <td class="text-center"><span class="label label-danger">ندارد</span></td>
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
                    <div class="col-md-offset-3 label label-warning" style="font-size: x-large">سفارشی جهت نمایش موجود
                        نیست!
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
