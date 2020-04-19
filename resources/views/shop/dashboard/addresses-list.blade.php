@extends('shop.layout.master')
<title>پروفایل - آدرس ها | فروشگاه اینترنتی کارپت مارکت</title>
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
                    <li><a href="">ویرایش پروفایل</a></li>
                    <li><a href="{{route('address.index')}}">لیست آدرس ها</a></li>
                    <li><a href="{{route('address.create')}}">اضافه کردن آدرس</a></li>
                    <li><a href="{{route('favorite.index')}}">لیست علاقه مندی</a></li>
                    <li><a href="">تاریخچه سفارشات</a></li>
                </ul>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th class="text-center">نوع آدرس</th>
                        <th class="text-center">شرکت</th>
                        <th class="text-center">آدرس</th>
                        <th class="text-center">کدپستی</th>
                        <th class="text-center">استان</th>
                        <th class="text-center">شهر</th>
                        <th class="text-center">ویرایش</th>
                        <th class="text-center">حذف</th>
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
                    @foreach($addresses as $address)
                        <tr>
                            @if($address->primary === 1)
                                <td class="text-center"><span class="label label-success">اصلی</span></td>
                            @else
                                <td class="text-center"><span class="label label-danger">غیر اصلی</span></td>
                            @endif
                            <td class="text-center">{{$address->company}}</td>
                            <td class="text-center">{{$address->address}}</td>
                            <td class="text-center">{{$address->post_code}}</td>
                            <td class="text-center">{{$address->province->name}}</td>
                            <td class="text-center">{{$address->city->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-warning"
                                   href="{{route('address.edit', ['id'=>$address->id])}}">ویرایش</a>
                            </td>
                            <td class="text-center">
                                <div class="display-inline-block">
                                    <form method="post" name="_method"
                                          action="{{route('address.delete', ['id'=>$address->id])}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12" style="text-align: center">{{$addresses->links()}}</div>
            </div>
        </div>
    </div>
@endsection
