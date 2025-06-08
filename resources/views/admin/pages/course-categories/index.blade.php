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
                <h5 class="m-0 ">Danh sách Danh mục khóa học</h5>
            </div>
            <div class="card-body">
                <table id="example" class="table border-none">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>#</th>
                            <th>Tên danh mục</th>
                            <th>Icon</th>
                            <th>Danh mục cha</th>
                            <th>Số lượng khóa học</th>
                            <th>Ngày tạo</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $cat)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $cat->cc_id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cat->cc_name }}</td>
                                <td>
                                    <img src="{{ $cat->icon_path }}" alt="" class="img-fluid" width="50">
                                </td>
                                <td>{{ $cat->parent?->cc_name }}</td>
                                <td>10</td>
                                <td>{{ $cat->created_at->format('d-m-Y H:m:s') }}</td>
                                <td>
                                    <a href="" class="btn btn-success">Sửa</a>
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
