<li class="dropdown-submenu">
    <a class="dropdown-item dropdown-toggle" href="{{ route('user.category.show', $category->full_slug_path) }}">
        {{ $category->cc_name }}
    </a>
    @if ($category->children->isNotEmpty())
        <ul class="dropdown-menu">
            @foreach ($category->children as $child)
                @include('user.partials.menu-item', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
