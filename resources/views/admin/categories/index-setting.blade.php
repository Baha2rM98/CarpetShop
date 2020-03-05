@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - تعیین ویژگی دسته بندی</title>
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">تعیین ویژگی دسته بندی {{$category->name}}</h3>
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
                        <form method="post" action="/administrator/categories/{{$category->id}}/settings">
                            @csrf
                            <div class="form-group">
                                <label for="name">ویژگی های دسته بندی {{$category->name}}</label>
                                <select name="attributeGroups[]" id="" class="form-control" multiple>
                                    @foreach($attributeGroups as $attributeGroup)
                                        <option value="{{$attributeGroup->id}}" @if(in_array($attributeGroup->id, $category->attributeGroups->pluck('id')->toArray())) selected @endif>{{$attributeGroup->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success pull-left">ذخیره</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-footer -->
    </section>
@endsection
