@extends('layouts.admin')

@section('admin.content')
    <div id="content" class="container-fluid mt-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách đánh giá</h5>
            </div>

            <div class="card-body">
                <table id="reviewsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Khóa học</th>
                            <th>Học viên</th>
                            <th>Đánh giá</th>
                            <th>Điểm</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="">
                                        {{ $review->course->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($review->comment, 50) }}</td>
                                <td class="fw-bold">{{ number_format($review->rating,1) }} ⭐</td>
                                <td>{{ $review->created_at }}</td>
                                <td class="text-nowrap">
                                    {{-- <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                            class="d-inline" name="delete-form" data-review-id="{{ $review->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm p-0">
                                                <i class="bi bi-trash text-dark fs-5"></i>
                                            </button>
                                        </form>
                                    </div> --}}
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
                const table = new DataTable('#reviewsTable', {
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

                // $('form[name="delete-form"]').on('submit', function(e) {
                //     e.preventDefault();

                //     const form = $(this);
                //     const url = form.attr('action');
                //     const csrf = $('meta[name="csrf-token"]').attr('content');
                //     const reviewId = form.data('review-id');

                //     Swal.fire({
                //         title: 'Xoá đánh giá này?',
                //         text: "Bạn sẽ không thể khôi phục lại đánh giá này!",
                //         icon: 'warning',
                //         showCancelButton: true,
                //         confirmButtonColor: '#3085d6',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'Xoá',
                //         cancelButtonText: 'Huỷ'
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             $.ajax({
                //                 type: "DELETE",
                //                 url: url,
                //                 headers: {
                //                     "X-CSRF-TOKEN": csrf,
                //                 },
                //                 data: {
                //                     review_id: reviewId
                //                 },
                //                 success: function(response) {
                //                     Swal.fire(
                //                         'Đã xoá!',
                //                         'Đánh giá đã được xoá thành công.',
                //                         'success'
                //                     ).then(() => {
                //                         form.closest('tr').remove();
                //                     });
                //                 },
                //                 error: function(xhr) {
                //                     Swal.fire(
                //                         'Lỗi!',
                //                         'Không thể xoá đánh giá. Vui lòng thử lại.',
                //                         'error'
                //                     );
                //                 }
                //             });
                //         }
                //     });
                // });
            });
        </script>
    @endpush
@endsection
