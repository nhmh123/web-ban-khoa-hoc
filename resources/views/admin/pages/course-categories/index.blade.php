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
                <h5 class="m-0">Danh mục khóa học</h5>
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
                            <th>Lần cuối cập nhật</th>
                            <th>Trạng thái</th>
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
                                    <img src="{{ asset($cat->icon_path) }}" alt="" class="img-fluid" width="50">
                                </td>
                                <td>{{ $cat->parent?->cc_name }}</td>
                                <td class="text-center">{{ $cat->courses()->count() }}</td>
                                <td>{{ $cat->created_at->format('d-m-Y H:m:s') }}</td>
                                <td>{{ $cat->updated_at?->format('d-m-Y H:m:s') }}</td>
                                <td>
                                    <span class="badge {{ $cat->status ? 'badge-success' : 'badge-dark' }}">
                                        {{ $cat->status ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('ccategories.edit', ['ccategory' => $cat->cc_id]) }}" class="btn">
                                        <i class="bi bi-pencil-square text-dark fs-5"></i>
                                    </a>
                                    <form name="delete-form"
                                        action="{{ route('ccategories.destroy', ['ccategory' => $cat->cc_id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">
                                            <i class="bi bi-trash text-dark fs-5"></i>
                                        </button>
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
                ],
            });

            const deleteForms = document.querySelectorAll('form[name="delete-form"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Bạn chắc chắn muốn xóa?",
                        text: "Thao tác không thể hoàn tác!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
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
