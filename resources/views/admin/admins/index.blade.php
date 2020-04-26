@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - مدیریت ادمین ها</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">مدیریت ادمین ها</h3>
                <div class="text-left">
                    <a class="btn btn-app" href="{{route('admin.register.form')}}"><i class="fa fa-plus"></i>ایجاد ادمین
                        جدید</a>
                </div>
            </div>
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('ok'))
                    <div class="alert alert-success">
                        <div>{{session('ok')}}</div>
                    </div>
                @endif
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
                            <th class="text-center">تغییر وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                @if(is_null($admin->deleted_at))
                                    <td class="text-center"><span class="label label-success">فعال</span></td>
                                @else
                                    <td class="text-center"><span class="label label-danger">غیر فعال</span></td>
                                @endif
                                <td class="text-center">{{$admin->name}}</td>
                                <td class="text-center">{{$admin->last_name}}</td>
                                <td class="text-center">{{$admin->phone_number}}</td>
                                <td class="text-center">{{$admin->email}}</td>
                                <td class="text-center">{{$admin->created_at}}</td>
                                <td class="text-center">
                                    <div class="display-inline-block">
                                        <form method="post"
                                              action="{{route('change.admin.status', ['id'=>$admin->id])}}">
                                            @csrf
                                            <input type="hidden" name="_method" value="PATCH">
                                            <button type="submit" class="btn btn-primary">تغییر وضعیت</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12" style="text-align: center">{{$admins->links()}}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
