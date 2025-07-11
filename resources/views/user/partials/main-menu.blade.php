{{-- <li class="nav-item fw-bold mx-2 align-content-center dropdown"> --}}
<div class="mx-2 fw-bold dropdown">
    <a class="nav-link dropdown-toggle text-dark d-flex align-items-center gap-1" href="#" id="courseDropdown"
        role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-list-ul fs-3"></i>
        <span>Danh mục</span>
    </a>

    <ul class="dropdown-menu" aria-labelledby="courseDropdown">
        @foreach ($categories as $category)
            @include('user.partials.menu-item', ['category' => $category])
        @endforeach
    </ul>
</div>
{{-- </li> --}}
