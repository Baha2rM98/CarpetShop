@extends('frontend.layout.master')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <!--Left Part Start -->
            <aside id="column-left" class="col-sm-3 hidden-xs">
                <h3 class="subtitle">دسته ها</h3>
                <div class="categories">
                    <ul id="cat_accordion">
                        @foreach($items as $item)
                            <li><a href="{{route('category.index', ['id' => $item->id])}}">{{$item->name}}</a><span
                                        class="down"></span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
            <!--Left Part End -->
            <!--Middle Part Start-->
            <div id="content" class="col-sm-9">
                <h1 class="title">{{$category->name}}</h1>
                <product-component :category="{{$category}}"></product-component>
            </div>
            <!--Middle Part End -->
        </div>
    </div>
@endsection

@section('script-vuejs')
    <script src="{{asset('/admin/js/app.js')}}"></script>
@endsection
