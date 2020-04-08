@extends('frontend.layout.master')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <product-component :category="{{$category}}"></product-component>
        </div>
    </div>
@endsection

@section('script-vuejs')
    <script src="{{asset('/admin/js/app.js')}}"></script>
@endsection
