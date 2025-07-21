@extends('layouts.admin')
@section('admin.content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">SỐ LƯỢNG NGƯỜI DÙNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalUsers) }}</h5>
                        <p class="card-text">Người dùng hoạt động</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">SỐ LƯỢNG KHÓA HỌC</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalCourses) }}</h5>
                        <p class="card-text">Khóa học có trong hệ thống</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH THU</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalCanceledOrders) }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->

    </div>
@endsection
