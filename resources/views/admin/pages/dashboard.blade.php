@extends('layouts.admin')
@section('admin.content')
    <div class="container-fluid py-5">
        <div class="row">
            @can('user.view')
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                        <div class="card-header">SỐ LƯỢNG NGƯỜI DÙNG</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($totalUsers) }}</h5>
                            <p class="card-text">Người dùng hoạt động</p>
                        </div>
                    </div>
                </div>
            @endcan
            @can('course.view')
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                        <div class="card-header">SỐ LƯỢNG KHÓA HỌC</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($totalCourses) }}</h5>
                            <p class="card-text">Khóa học có trong hệ thống</p>
                        </div>
                    </div>
                </div>
            @endcan
            @can('order.view')
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header">DOANH THU</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h5>
                            <p class="card-text">Doanh số hệ thống</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header">ĐƠN HÀNG HỦY</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($totalCanceledOrders) }}</h5>
                            <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-4">
                    <form method="GET" id="revenue-form" action="{{ route('admin.dashboard') }}" class="mb-3">
                        <div class="form-group mb-2">
                            <label for="time_type">Thống kê theo:</label>
                            <select id="time_type" name="time_type" class="form-control" onchange="toggleInputFields()">
                                <option value="month" {{ request('time_type') == 'month' ? 'selected' : '' }}>Tháng</option>
                                <option value="quarter" {{ request('time_type') == 'quarter' ? 'selected' : '' }}>Quý</option>
                                <option value="year" {{ request('time_type') == 'year' ? 'selected' : '' }}>Năm</option>
                            </select>
                        </div>

                        <div class="form-group mb-2" id="monthInput">
                            <label>Chọn tháng:</label>
                            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                        </div>

                        <div class="form-group mb-2" id="quarterInput" style="display: none;">
                            <label>Chọn quý:</label>
                            <select name="quarter" class="form-control">
                                @for ($i = 1; $i <= 4; $i++)
                                    <option value="{{ $i }}" {{ request('quarter') == $i ? 'selected' : '' }}>Quý
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            <label>Năm:</label>
                            <input type="number" name="quarter_year" class="form-control" min="2020"
                                value="{{ request('quarter_year') ?? now()->year }}">
                        </div>

                        <div class="form-group mb-2" id="yearInput" style="display: none;">
                            <label>Chọn năm:</label>
                            <input type="number" name="year" class="form-control" min="2020"
                                value="{{ request('year') ?? now()->year }}">
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Xem thống kê</button>
                    </form>
                </div>

            </div>
        @endcan

        <!-- end analytic  -->
    </div>

    @push('scripts')
        <script>
            function toggleInputFields() {
                const timeType = document.getElementById('time_type').value;
                document.getElementById('monthInput').style.display = (timeType === 'month') ? 'block' : 'none';
                document.getElementById('quarterInput').style.display = (timeType === 'quarter') ? 'block' : 'none';
                document.getElementById('yearInput').style.display = (timeType === 'year') ? 'block' : 'none';
            }
            window.addEventListener('DOMContentLoaded', toggleInputFields);
        </script>
    @endpush
@endsection
