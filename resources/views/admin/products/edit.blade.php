@extends('admin.layout.master')
<title>صفحه مدیریت فروشگاه - ویرایش محصول</title>
@section('styles')
    <link rel="stylesheet" href="{{asset('/admin/dist/css/dropezone.css')}}">
@endsection
@section('content')
    <section class="content" id="app">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش محصول {{$product->title}}</h3>
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
                        <form method="post" action="/products/{{$product->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" name="title" class="form-control" value="{{$product->title}}"
                                       placeholder="نام محصول را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label for="name">نام مستعار</label>
                                <input type="text" name="slug" class="form-control" value="{{$product->slug}}"
                                       placeholder="نام مستعار محصول را وارد کنید...">
                            </div>

                            <admin-product-component :product="{{$product}}"
                                                    :brands="{{$brands}}"></admin-product-component>

                            <div class="form-group">
                                <label>وضعیت نشر</label>
                                <div>
                                    <input type="radio" name="status" value="0"
                                           @if($product->status === 0) checked @endif> <span class="margin-l-10">منتشر نشده</span>
                                    <input type="radio" name="status" value="1"
                                           @if($product->status === 1) checked @endif> <span>منتشر شده</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>قیمت</label>
                                <input type="number" name="price" class="form-control" value="{{$product->price}}"
                                       placeholder="قیمت محصول را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label>قیمت ویژه</label>
                                <input type="number" name="discount_price" class="form-control"
                                       value="{{$product->discount_price}}"
                                       placeholder="قیمت ویژه محصول را وارد کنید...">
                            </div>
                            <div class="form-group">
                                <label>توضیحات</label>
                                <textarea id="textareaDescription" type="text" name="description"
                                          class="ckeditor form-control"
                                          placeholder="توضیحات محصول را وارد کنید...">{{$product->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">گالری تصاویر محصول</label>
                                <input type="hidden" name="photo_id[]" id="product-photo">
                                <div id="photo" class="dropzone"></div>
                                <div class="row">
                                    @foreach($product->photos as $photo)
                                        <div class="col-sm-3" id=updated_photo_{{$photo->id}}">
                                            <img class="img-responsive" src="{{$photo->path}}">
                                            <button type="button" class="btn btn-danger"
                                                    onclick="removeImage({{$photo->id}})">حذف عکس
                                                محصول
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" onclick="productGallery()" class="btn btn-facebook pull-left">ویرایش
                                کردن
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-footer -->
    </section>
@endsection

@section('script-vuejs')
    <script src="{{asset('/admin/js/app.js')}}"></script>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('/admin/dist/js/dropezone.js')}}"></script>
    <script type="text/javascript" src="{{asset('/admin/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        Dropzone.autoDiscover = false;
        let photosGallery = [];
        let photos = [].concat({{$product->photos->pluck('id')}});
        let drop = new Dropzone('#photo', {
            addRemoveLinks: true,
            url: "{{route('photos.upload')}}",
            sending: function (file, xhr, formData) {
                formData.append('_token', "{{csrf_token()}}")
            },
            success: function (file, response) {
                photosGallery.push(response.photo_id);
            }
        });

        function productGallery() {
            document.getElementById('product-photo').value = photosGallery.concat(photos)
        }

        CKEDITOR.replace('textareaDescription', {
            customConfig: 'config.js',
            toolbar: 'simple',
            language: 'fa',
            removePlugins: 'cloudservices, easyimage',
        });

        function removeImage(id) {
            let index = photos.indexOf(id);
            photos.splice(index, 1);
            document.getElementById('updated_photo_' + id).remove();
        }
    </script>
@endsection
