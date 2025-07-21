@extends('layouts.admin')

@section('admin.content')
    <div class="container-fluid mt-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách Slider</h5>
                <a href="{{ route('sliders.create') }}" class="btn btn-primary btn-sm">Thêm Slider</a>
            </div>

            <div class="card-body">
                <table id="slider-table" class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Thứ tự hiển thị</th>
                            <th>Thời gian tạo</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset($slider->image) }}" alt="Slider Image" class="img-thumbnail"
                                        style="width: 200px; height: auto;">
                                </td>
                                <td>
                                    <input type="number" name="order" class="form-control order-input"
                                        data-id="{{ $slider->id }}" value="{{ $slider->order }}" min="0"
                                        max="{{ $maxOrder }}" readonly>
                                </td>
                                <td class="text-center">{{ $slider->created_at }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('sliders.edit', $slider) }}" class="btn btn-sm p-0">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>
                                        <form action="{{ route('sliders.destroy', $slider) }}" method="POST"
                                            class="d-inline" name="delete-form" data-slide-id="{{ $slider->id }}">
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = new DataTable('#slider-table', {
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
                const sliderId = $(this).closest('form').data('slider-id');

                Swal.fire({
                    title: 'Xoá slide này?',
                    text: "Bạn sẽ không thể khôi phục lại slide này!",
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
                                slider_id: sliderId
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Đã xoá!',
                                    'Slider đã được xoá thành công.',
                                    'success'
                                ).then(() => {
                                    form.closest('tr').remove();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Lỗi!',
                                    'Không thể xoá Slider. Vui lòng thử lại.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        })
    </script>
@endpush
