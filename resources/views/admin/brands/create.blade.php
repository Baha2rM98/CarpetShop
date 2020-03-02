@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ایجاد برند جدید</title>
@section('styles')
    <link rel="stylesheet" href="{{asset('/admin/dist/css/dropezone.css')}}">
@endsection
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد برند جدید</h3>
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
                        <form method="post" action="/administrator/brands">
                            @csrf
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="نام برند را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">توضیحات</label>
                                <textarea type="text" name="description" class="form-control"
                                          placeholder="توضیحات برند را وارد کنید..."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">تصویر</label>
                                <div id="photo" class="dropzone"></div>
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

@section('scripts')
    <script type="text/javascript" src="{{asset('/admin/dist/js/dropezone.js')}}"></script>
    <script>
        let drop = new Dropzone('#photo', {
            url: "{{route('photos.create')}}"
        });
    </script>
@endsection
