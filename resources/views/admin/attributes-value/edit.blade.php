@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ویرایش مقدار ویژگی</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش مقدار ویژگی {{$attributesValue->title}}</h3>
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
                        <form method="post" action="/administrator/attributes-value/{{$attributesValue->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">عنوان</label>
                                <input type="text" name="title" class="form-control" value="{{$attributesValue->title}}"
                                       placeholder="عنوان مقدار ویژگی را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">نوع ویژگی</label>
                                <select name="attribute_group_id" id="" class="form-control">
                                    @foreach($attributesGroup as $attribute)
                                        <option value="{{$attribute->id}}"
                                                @if($attribute->id === $attributesValue->attributeGroup->id) selected @endif>{{$attribute->title}}</option>
                                    @endforeach
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
