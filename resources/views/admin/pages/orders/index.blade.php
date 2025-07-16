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
                <h5 class="m-0">Danh sách đơn hàng</h5>
            </div>
            <div class="card-body">
                <table id="example" class="table border-none">
                    <thead>
                        <tr>
                            
                            <th>#</th>
                            <th>Mã đơn hàng</th>
                            <th>Người dùng</th>
                            <th>Tổng tiền</th>
                            <th>Số lượng khóa học</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}">
                                        {{ $order->order_id }}
                                    </a>
                                </td>
                                <td>{{ $order->user_id }}</td>
                                <td class="text-center">{{ number_format($order->total_amount) }}đ</td>
                                <td>{{ $order->sub_total }}</td>
                                <td>
                                    <span class="badge {{ $order->status_color }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d-m-Y H:m:s') }}</td>
                                <td class="tex-center">
                                    <a href="{{ route('orders.show', $order) }}" class="btn outline-none">
                                        <i class="bi bi-arrow-right-square text-dark fs-5"></i>
                                    </a>
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
                    targets: 0,
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
