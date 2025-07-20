@extends('layouts.admin')
@section('admin.content')
    <div id="content "class="container-fluid mt-3">
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
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('pages.edit', $page) }}">
                                        {{ $page->title }}
                                </td>
                                </a>
                                <td>{{ $page->slug }}</td>
                                <td>{{ \App\Enums\StaticPageTypeEnum::from($page->type)->label() }}
                                </td>
                                <td>
                                    @if ($page->is_active)
                                        <span class="badge bg-success">Hiển thị</span>
                                    @else
                                        <span class="badge bg-dark">Ẩn</span>
                                    @endif
                                </td>
                                <td>{{ $page->created_at }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
                                        <form action="{{ route('pages.destroy', $page->id) }}" method="POST"
                                            class="d-inline" name="delete-form" data-page-id="{{ $page->id }}">
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
            $(document).ready(function() {
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
                $('form[name="delete-form"]').on('submit', function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const url = form.attr('action');
                    const csrf = $('meta[name="csrf-token"]').attr('content');
                    const pageId = $(this).closest('form').data('page-id');

                    Swal.fire({
                        title: 'Xoá trang này?',
                        text: "Bạn sẽ không thể khôi phục lại trang này!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xoá',
                        cancelButtonText: 'Huỷ'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                headers: {
                                    "X-CSRF-TOKEN": csrf,
                                },
                                data: {
                                    page_id: pageId
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Đã xoá!',
                                        'Trang đã được xoá thành công.',
                                        'success'
                                    ).then(() => {
                                        form.closest('tr').remove();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Lỗi!',
                                        'Không thể xoá trang. Vui lòng thử lại.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
