<tr>
    <td>
        <input type="checkbox" name="ids[]" value="{{ $cat->cc_id }}">
    </td>
    {{-- <td>{{ $loop->iteration }}</td> --}}
    <td>
        {!! str_repeat('---', $level) !!} {{-- Thụt lề --}}
        {{ $cat->cc_name }}
    </td>
    <td>{{ $cat->parent?->cc_name }}</td>
    <td class="text-center">{{ $cat->courses()->count() }}</td>
    <td>{{ $cat->created_at->format('d-m-Y H:i:s') }}</td>
    <td>{{ $cat->updated_at?->format('d-m-Y H:i:s') }}</td>
    <td>
        <span class="badge {{ $cat->status ? 'badge-success' : 'badge-dark' }}">
            {{ $cat->status ? 'Hiển thị' : 'Ẩn' }}
        </span>
    </td>
    <td>
        <a href="{{ route('ccategories.edit', ['ccategory' => $cat->cc_id]) }}" class="btn">
            <i class="bi bi-pencil-square text-dark fs-5"></i>
        </a>
        <form name="delete-form" action="{{ route('ccategories.destroy', ['ccategory' => $cat->cc_id]) }}"
            method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">
                <i class="bi bi-trash text-dark fs-5"></i>
            </button>
        </form>
    </td>
</tr>

@if ($cat->children->isNotEmpty())
    @foreach ($cat->children as $child)
        @include('admin.pages.course-categories.category-item', ['cat' => $child, 'level' => $level + 1])
    @endforeach
@endif
