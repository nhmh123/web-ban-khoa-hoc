@extends('layouts.user')
@section('user.content')
    <div class="container">
        <h5 class="fw-bold">Lich su mua hang</h5>
        <table id="order-detail-table" class="table">
            <thead>
                <tr>
                    <th>ten khoa hoc</th>
                    <th>so tien</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td>
                            <a href="">
                                {{ $item->course_title }}
                            </a>
                        </td>
                        <td>{{ number_format($item->price_amount) }}đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            const table = new DataTable('#order-detail-table', {
                columnDefs: [{
                    searchable: true,
                    orderable: true,
                    targets: 0
                }],
                order: [
                    [1, 'asc']
                ],
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
