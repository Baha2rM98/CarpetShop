@foreach($categories as $subCategory)
    <tr>
        <td class="text-center">{{$subCategory->id}}</td>
        <td>{{str_repeat('>>>', $level)}}{{' '}}{{$subCategory->name}}</td>
        <td class="text-center">
            <a class="btn btn-warning"
               href="{{route('categories.edit', $subCategory->id)}}">ویرایش</a>
            <a class="btn btn-danger"
               href="{{route('categories.destroy', $subCategory->id)}}">حذف</a>
        </td>
    </tr>
    @if(isset($subCategory->children))
        @include('admin.partials.categorylist', ['categories' => $subCategory->children, 'level' => $level + 1])
    @endif
@endforeach
