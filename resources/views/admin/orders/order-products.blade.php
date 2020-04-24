@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - جزئیات سفارش</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">جزئیات سفارش {{$order->order_code}}</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">وضعیت محصول</th>
                            <th class="text-center">عکس محصول</th>
                            <th class="text-center">نام محصول</th>
                            <th class="text-center">قیمت واحد</th>
                            <th class="text-center">کد محصول</th>
                            <th class="text-center">تعداد</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < count($products); $i++)
                            <tr>
                                @if(is_null($products[$i]->deleted_at))
                                    <td class="text-center"><span class="label label-success">فعال</span></td>
                                @else
                                    <td class="text-center"><span class="label label-danger">حذف شده</span></td>
                                @endif
                                <td class="image" width="15%"><img class="img-responsive" src="{{$products[$i]->photos[0]->path}}"></td>
                                <td class="text-center">{{$products[$i]->title}}</td>
                                @if(isset($products[$i]->discount_price))
                                    <td class="text-center">{{$products[$i]->discount_price}}</td>
                                @else
                                    <td class="text-center">{{$products[$i]->price}}</td>
                                @endif
                                <td class="text-center">{{$products[$i]->sku}}</td>
                                <td class="text-center">{{$pivots[$i]->quantity}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
