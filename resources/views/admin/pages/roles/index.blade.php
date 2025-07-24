@extends('layouts.admin')
@section('admin.content')
    <div id="content" class="container-fluid">
        @session('success')
            <div class="alert alert-success">{{ session('success') }}</div>
        @endsession
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách vai trò</h5>
            </div>
            <div class="card-body">
                <table id="role-table" class="table table-striped table-checkall">
                    <thead>
                        <tr>

                            <th scope="col">#</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td><a href="{{ route('roles.edit', $role) }}">{{ $role->name }}</a></td>
                                <td>{{ $role->description }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-start gap-2">
                                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->role_id) }}" method="POST"
                                            class="d-inline" name="delete-form" data-role-id="{{ $role->role_id }}">
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
                const table = new DataTable('#role-table', {
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

                let deleteForm = $('form[name="delete-form"]');
                console.log(deleteForm);
                deleteForm.on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this)
                    let deleteId = form.data('role-id');
                    let deleteUrl = form.attr('action');
                    let csrf = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Xoá vai trò này?',
                        text: "Bạn sẽ không thể khôi phục lại!",
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
                                url: deleteUrl,
                                headers: {
                                    "X-CSRF-TOKEN": csrf
                                },
                                data: {
                                    role_id: deleteId
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Đã xoá!',
                                        'Vai trò đã được xoá thành công.',
                                        'success'
                                    ).then(() => {
                                        form.closest('tr').remove();
                                    })
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr, status, error);
                                    Swal.fire(
                                        'Lỗi!',
                                        'Không thể xoá vai trò. Vui lòng thử lại.',
                                        'error'
                                    );
                                }
                            });
                        }
                    })
                })
            })
        </script>
    @endpush
@endsection
