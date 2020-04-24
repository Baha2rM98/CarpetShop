@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - آخرین نظرات</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">آخرین نظرات</h3>
            </div>
            <div class="box-body">
                @if(\Illuminate\Support\Facades\Session::has('confirmation'))
                    <div class="alert alert-success">
                        <div>{{session('confirmation')}}</div>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Session::has('duplicate'))
                    <div class="alert alert-warning">
                        <div>{{session('duplicate')}}</div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">نظر</th>
                            <th class="text-center">کاربر</th>
                            <th class="text-center">محصول</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td class="text-center">{{$comment->id}}</td>
                                <td class="text-center">{{$comment->comment}}</td>
                                <td class="text-center">{{$comment->user->name . ' ' .$comment->user->last_name}}</td>
                                <td class="text-center">{{$comment->product->title}}</td>
                                @if($comment->visibility === 0)
                                    <td class="text-center"><span class="tag tag-pill tag-danger">تایید نشده</span></td>
                                @else
                                    <td class="text-center"><span class="tag tag-pill tag-success">تایید شده</span></td>
                                @endif
                                <td class="text-center">
                                    <div class="display-inline-block">
                                        <form method="post" action="{{route('comment.confirmation', ['id' => $comment->id])}}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" name="confirmed" value="ack">تایید</button>
                                            <button type="submit" class="btn btn-danger" name="confirmed" value="nak">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
