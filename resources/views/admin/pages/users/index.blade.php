@extends('layouts.admin')
@section('admin.content')
    <div id="content" class="container-fluid">

        @session('success')
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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
                <h5 class="m-0 ">Danh sách thành viên</h5>
            </div>
            <div class="card-body">
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
                                <td>{{ $user->created_at }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
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
