@extends('layouts.user')
@section('user.content')
    <div class="container my-5">
        <h3 class="fw-bold">Lịch sử mua hàng</h3>
        <div class="mt-5">
            <table id="order-table" class="table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Số lượng khóa học</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($userOrders->count() > 0)
                        @foreach ($userOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('user.orders.detail', $order) }}">
                                        {{ $order->order_id }}
                                    </a>
                                </td>
                                <td>{{ $order->sub_total }}</td>
                                <td>{{ number_format($order->total_amount) }}đ</td>
                                <td>
                                    <span class="badge {{ $order->status_color}}">
                                        {{ $order->status }}
                                    </span>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    @else
                        <p>Khong co don hang</p>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            const table = new DataTable('#order-table', {
                columnDefs: [{
                    searchable: false,
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
