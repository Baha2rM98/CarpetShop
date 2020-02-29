@if(isset($selectedCategory))
    @foreach($categories as $subCategory)
        <option value="{{$subCategory->id}}"
                @if($selectedCategory->parent_id === $subCategory->id) selected @endif>{{str_repeat('>>>', $level)}}{{' '}}{{$subCategory->name}}</option>
        @if(isset($subCategory->children))
            @include('admin.partials.subcategory', ['categories' => $subCategory->children, 'level' => $level + 1, 'selectedCategory' => $selectedCategory])
        @endif
    @endforeach
@else
    @foreach($categories as $subCategory)
        <option value="{{$subCategory->id}}">{{str_repeat('>>>', $level)}}{{' '}}{{$subCategory->name}}</option>
        @if(isset($subCategory->children))
            @include('admin.partials.subcategory', ['categories' => $subCategory->children, 'level' => $level + 1])
        @endif
    @endforeach
@endif
