@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ویرایش برند</title>
@section('styles')
    <link rel="stylesheet" href="{{asset('/admin/dist/css/dropezone.css')}}">
@endsection
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش برند {{$brand->name}}</h3>
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
                        <form method="post" action="/brands/{{$brand->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">تصویر برند</label>
                                {{--                                --}}
                                <img src="{{$brand->photo->path}}"  style="height:50vh">
                            </div>
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" name="title" class="form-control" value="{{$brand->title}}"
                                       placeholder="نام برند را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">توضیحات</label>
                                <textarea type="text" name="description" class="form-control"
                                          placeholder="توضیحات برند را وارد کنید...">{{$brand->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">تصویر (فایل آپلود شده حتما باید از نوع عکس باشد و حجم آن حداکثر 4
                                    مگابایت باشد.)</label>
                                <input type="hidden" name="photo_id" id="brand-photo" value="{{$brand->photo_id}}">
                                <div id="photo" class="dropzone"></div>
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

@section('scripts')
    <script type="text/javascript" src="{{asset('/admin/dist/js/dropezone.js')}}"></script>
    <script>
        let drop = new Dropzone('#photo', {
            addRemoveLinks: true,
            maxFiles: 1,
            url: "{{route('photos.upload')}}",
            sending: function (file, xhr, formData) {
                formData.append('_token', "{{csrf_token()}}")
            },
            success: function (file, response) {
                document.getElementById('brand-photo').value = response.photo_id
            }
        });
    </script>
@endsection
