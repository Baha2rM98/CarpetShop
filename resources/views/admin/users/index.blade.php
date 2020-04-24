@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - کاربران</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">کاربران</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">نام خانوادگی</th>
                            <th class="text-center">شماره تماس</th>
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">تاریخ عضویت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                @if(isset($user->deleted_at))
                                    <td class="text-center"><span class="label label-danger">غیر فعال</span></td>
                                @else
                                    <td class="text-center"><span class="label label-success">فعال</span></td>
                                @endif
                                <td class="text-center">{{$user->name}}</td>
                                <td class="text-center">{{$user->last_name}}</td>
                                <td class="text-center">{{$user->phone_number}}</td>
                                <td class="text-center">{{$user->email}}</td>
                                <td class="text-center">{{$user->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: center">{{$users->links()}}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
