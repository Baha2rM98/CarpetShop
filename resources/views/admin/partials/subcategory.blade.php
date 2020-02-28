@foreach($categories as $subCategory)
    <option value="{{$subCategory->id}}">{{str_repeat('>>>', $level)}}{{' '}}{{$subCategory->name}}</option>
    @if(isset($subCategory->children))
        @include('admin.partials.subcategory', ['categories' => $subCategory->children, 'level' => $level + 1])
    @endif
@endforeach
