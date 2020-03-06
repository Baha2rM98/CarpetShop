@foreach($categories as $subCategory)
    <tr>
        <td class="text-center">{{$subCategory->id}}</td>
        <td>{{str_repeat('>>>', $level)}}{{' '}}{{$subCategory->name}}</td>
        <td class="text-center">
            <a class="btn btn-warning"
               href="{{route('categories.edit', $subCategory->id)}}">ویرایش</a>
            <div class="display-inline-block">
                <form method="post" name="_method"
                      action="/administrator/categories/{{$subCategory->id}}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
            <a class="btn btn-primary" href="{{route('categories.attributes', $subCategory->id)}}">تنظیمات</a>
        </td>
    </tr>
    @if(count($subCategory->children) > 0)
        @include('admin.partials.categorylist', ['categories' => $subCategory->children, 'level' => $level + 1])
    @endif
@endforeach
