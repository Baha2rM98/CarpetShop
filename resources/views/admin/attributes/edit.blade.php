@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ویرایش گروه ویژگی</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش گروه ویژگی {{$attributesGroup->title}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if($errors->any())
                    <ul>
                        <div class="alert alert-warning">
                            @foreach($errors->all() as $error)
                                {{$error}}
                            @endforeach
                        </div>
                    </ul>
                @endif
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="post" action="/attribute-groups/{{$attributesGroup->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">عنوان</label>
                                <input type="text" name="title" class="form-control" value="{{$attributesGroup->title}}"
                                       placeholder="عنوان گروه بندی ویژگی را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">نوع</label>
                                <select name="type" id="" class="form-control">
                                    <option value="تکی" @if($attributesGroup->type === 'تکی') selected @endif>
                                        لیست تکی
                                    </option>
                                    <option value="چنتایی"
                                            @if($attributesGroup->type === 'چنتایی') selected @endif>لیست چنتایی
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-facebook pull-left">ویرایش کردن</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-footer -->
    </section>
@endsection
