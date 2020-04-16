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
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">قیمت</th>
                            <th class="text-center">وضعیت سفارش</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="text-center">{{$order->id}}</td>
                                <td class="text-center">{{$order->price}}</td>
                                @if($order->status === 0)
                                    <td class="text-center"><span class="label label-danger">پرداخت نشده</span></td>
                                @else
                                    <td class="text-center"><span class="label label-success">پرداخت شده</span></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: center">{{$orders->links()}}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
