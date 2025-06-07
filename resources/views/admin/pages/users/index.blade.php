@extends('layouts.admin')
@section('admin.content')
    <div id="content" class="container-fluid">
        <div class="card">
            @session('success')
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endsession
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
            </div>
            <div class="card-body">
                <h6>Bộ lọc</h6>
                <form action="{{ route('users.index') }}" method="GET">

                    <div class="filter-group">
                        <div class="form-group">
                            <label for="role-select">Vai trò</label>
                            <select name="role" id="role-select" class="form-control">
                                <option value="all">Tất cả</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status-select">Trạng thái</label>
                            <select name="status" id="status-select" class="form-control">
                                <option value="0" selected>Tất cả</option>
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="Lọc" class="btn btn-primary">
                </form>
                <hr>
                {{-- <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="">
                        <option>Chọn</option>
                        <option>Tác vụ 1</option>
                        <option>Tác vụ 2</option>
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div> --}}
                <table id="example" class="table border-none">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Ảnh đại diện</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th>Vai trò</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $user->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <img src="{{ $user->avatar }}" alt="" class="img-fluid" width="50">
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d-m-Y H:m:s') }}</td>
                                <td>{{ $user->role?->name }}</td>
                                <td>
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                        class="btn btn-success">Sửa</a>
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <th>
                                <input type="checkbox" name="" id="">
                            </th>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Ảnh đại diện</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th>Tác vụ</th>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const table = new DataTable('#example', {
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                }],
                order: [
                    [1, 'asc']
                ]
            });
            $(document).ready(function() {
                var checkAll = $('#checkAll');
                checkAll.on('click', function() {
                    var checkboxes = $('input[name="ids[]"]');
                    if (checkAll.is(':checked')) {
                        checkboxes.prop('checked', true);
                    } else {
                        checkboxes.prop('checked', false);
                    }
                })
            })
        </script>
    @endpush
@endsection
