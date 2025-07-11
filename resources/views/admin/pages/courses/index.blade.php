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
                <h5 class="m-0 ">Danh sách khóa học</h5>
            </div>
            <div class="card-body">
                <table id="course-table" class="table border-none">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>#</th>
                            <th>Tên khóa học</th>
                            <th>Thumbnail</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Số lượng học viên</th>
                            <th>Đánh giá</th>
                            <th>Ngày tạo</th>
                            <th>Lần cuối cập nhật</th>
                            <th>Giảng viên</th>
                            <th>Trạng thái</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $course->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $course->name }}</td>
                                <td>
                                    <img src="{{ $course->thumbnail ?? asset('images/default-thumbnail.jpg') }}"
                                        alt="thumbnail" class="img-fluid" width="100">
                                </td>
                                <td>
                                    <span class="text-danger fw-bold">{{ number_format($course->original_price) }}đ</span>
                                </td>
                                <td>{{ $course->category->cc_name ?? 'Không rõ' }}</td>
                                <td class="text-center">{{ $course->enrollments()->count() }}</td>
                                <td>{{ number_format($course->rating, 1) }} ★</td>
                                <td>{{ $course->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $course->updated_at?->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $course->user->name ?? 'Không rõ' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $course->status == 'published' ? 'badge-success' : 'badge-dark' }}">
                                        {{ $course->status == 'published' ? 'Công khai' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                            class="d-inline" name="delete-form"
                                            onsubmit="return confirm('Xoá khóa học này?')">
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
            const table = new DataTable('#course-table', {
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
