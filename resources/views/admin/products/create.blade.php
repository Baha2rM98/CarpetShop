@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ایجاد محصول جدید</title>
@section('styles')
    <link rel="stylesheet" href="{{asset('/admin/dist/css/dropezone.css')}}">
@endsection
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد محصول جدید</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if($errors->any())
                    <ul>
                        <div class="alert alert-warning">
                            @foreach($errors->all() as $error)
                                <ul>{{$error}}</ul>
                            @endforeach
                        </div>
                    </ul>
                @endif
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form method="post" action="/administrator/products">
                                @csrf
                                <div class="form-group">
                                    <label for="name">نام</label>
                                    <input type="text" name="title" class="form-control" placeholder="نام محصول را وارد کنید...">
                                </div>
                                <div class="form-group">
                                    <label for="name">نام مستعار</label>
                                    <input type="text" name="slug" class="form-control" placeholder="نام مستعار محصول را وارد کنید...">
                                </div>
                                <div class="form-group">
                                    <label for="name">دسته بندی</label>
                                    <select name="categories[]" id="" class="form-control" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @if(isset($category->children))
                                                @include('admin.partials.subcategory', ['categories' => $category->children, 'level' => 1])
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">برند</label>
                                    <select name="category" id="" class="form-control">
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">وضعیت نشر</label>
                                    <div>
                                        <input type="radio" name="status" value="0" checked> <span class="margin-l-10">منتشر نشده</span>
                                        <input type="radio" name="status" value="1"> <span>منتشر شده</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">قیمت</label>
                                    <input type="number" name="price" class="form-control" placeholder="قیمت محصول را وارد کنید...">
                                </div>
                                <div class="form-group">
                                    <label for="name">قیمت ویژه</label>
                                    <input type="number" name="discount_price" class="form-control" placeholder="قیمت ویژه محصول را وارد کنید...">
                                </div>
                                <div class="form-group">
                                    <label for="name">توضیحات</label>
                                    <textarea type="text" name="description" class="form-control" placeholder="توضیحات محصول را وارد کنید..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">تصویر (فایل آپلود شده حتما باید از نوع عکس باشد و حجم آن حداکثر 4 مگابایت باشد.)</label>
                                    <input type="hidden" name="photo_id" id="brand-photo">
                                    <div id="photo" class="dropzone"></div>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">عنوان سئو</label>
                                    <input type="text" name="meta_title" class="form-control" placeholder="عنوان سئو را وارد کنید...">
                                </div>
                                <div class="form-group">
                                    <label for="meta_desc">توضیحات سئو</label>
                                    <textarea name="meta_desc" class="form-control" placeholder="توضیحات سئو را وارد کنید..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">کلمات کلیدی سئو</label>
                                    <input type="text" name="meta_keywords" class="form-control" placeholder="کلمات کلیدی سئو را وارد کنید...">
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
