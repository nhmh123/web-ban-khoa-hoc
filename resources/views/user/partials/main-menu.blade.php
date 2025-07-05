{{-- <li class="nav-item fw-bold mx-2 align-content-center dropdown"> --}}
    <div class="mx-2 fw-bold dropdown">
        <a class="nav-link dropdown-toggle text-dark" href="#" id="courseDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Danh mục
        </a>
        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
            @foreach ($categories as $category)
                @include('user.partials.menu-item', ['category' => $category])
            @endforeach
        </ul>
    </div>
{{-- </li> --}}
