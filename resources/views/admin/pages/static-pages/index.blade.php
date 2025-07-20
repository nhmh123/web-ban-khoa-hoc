@extends('layouts.admin')

@section('admin.content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách trang tĩnh</h5>
                <a href="{{ route('pages.create') }}" class="btn btn-primary btn-sm">Tạo mới</a>
            </div>

            <div class="card-body">
                <table id="example" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th>Slug</th>
                            <th>Loại</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>{{ \App\Enums\StaticPageTypeEnum::from($page->type)->label() }}
                                </td>
                                <td>{{ $page->created_at }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
                                        <form action="" method="POST"
                                            class="d-inline" name="delete-form"
                                            onsubmit="return confirm('Xoá trang này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm p-0">
                                                <i class="bi bi-trash text-dark fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const table = new DataTable('#example', {
                language: {
                    lengthMenu: "Hiển thị _MENU_ dòng mỗi trang",
                    zeroRecords: "Không tìm thấy kết quả nào",
                    info: "Hiển thị _START_ đến _END_ trong tổng _TOTAL_ mục",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(lọc từ tổng _MAX_ mục)",
                    search: "Tìm kiếm:",
                    paginate: {
                        first: "Đầu",
                        last: "Cuối",
                        next: "Tiếp",
                        previous: "Trước"
                    }
                }
            });
        </script>
    @endpush
@endsection
