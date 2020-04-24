@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - داشبورد</title>
@section('content')
    <br>
    <section class="content-header">
        <h1>داشبورد</h1>
    </section>
    <br>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$orders}}</h3>
                        <p>سفارشات جدید</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('admin.latest.orders.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> مشاهده </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$comments}}</h3>
                        <p>نظرات جدید</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-comments"></i>
                    </div>
                    <a href="{{route('admin.latest.comments.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> مشاهده </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$users}}</h3>
                        <p>کاربران ثبت شده</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{route('registered.users')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> مشاهده </a>
                </div>
            </div>
            @if($admin->super_admin === 1)
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$admins}}</h3>
                            <p>مدیریت ادمین ها</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> مشاهده </a></div>
                </div>
            @endif
        </div>
    </section>
@endsection
