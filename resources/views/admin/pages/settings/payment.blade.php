@extends('layouts.admin')
@section('admin.content')
    <div class="container-fluid mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
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
            <div class="card-header">
                <h5>Tài khoản nhận thanh toán</h5>
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-payment-modal">
                    Thêm tài khoản
                </button>

                <div class="modal fade" id="add-payment-modal" tabindex="-1" aria-labelledby="add-payment-modal-label"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="add-payment-modal-label">Thêm tài khoản nhận thanh toán
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('settings.payment.store') }}" id="add-account-form" method="POST">
                                @csrf
                                <div class="modal-body">
                                    {{-- CARD: Chọn ngân hàng --}}
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header">
                                            <h5 class="mb-0">Chọn ngân hàng</h5>
                                        </div>

                                        <div class="card-body px-3 py-2" style="max-height: 220px; overflow-y: auto;">
                                            <div class="row">
                                                <input type="hidden" name="bank_name" id="bank_name">
                                                <input type="hidden" name="bank_bin" id="bank_bin">
                                                @foreach ($banks['data'] as $bank)
                                                    <div class="col-md-2 col-sm-4 col-6 mb-3">
                                                        <label
                                                            class="d-block text-center border p-2 rounded shadow-sm bank-item"
                                                            style="cursor: pointer; font-size: 0.85rem;">

                                                            <input type="radio" name="bank_code"
                                                                value="{{ $bank['code'] }}" class="form-check-input mb-1">

                                                            <img src="https://api.vietqr.io/img/{{ $bank['code'] }}.png"
                                                                alt="{{ $bank['name'] ?? 'Logo' }}" class="img-fluid mb-2"
                                                                style="max-height: 35px;"
                                                                onerror="this.onerror=null;this.src='{{ asset('images/default-bank-logo.png') }}';">

                                                            <div class="fw-normal text-truncate"
                                                                title="{{ $bank['name'] }}">
                                                                {{ $bank['name'] }}
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    {{-- CARD: Nhập thông tin tài khoản --}}
                                    <div class="card shadow-sm">
                                        <div class="card-header">
                                            <h5 class="mb-0">Nhập thông tin tài khoản</h5>
                                        </div>
                                        <div class="card-body px-3 py-2">
                                            <div class="mb-3">
                                                <label for="account_number" class="form-label">Số tài khoản / Số thẻ</label>
                                                <input type="text" class="form-control" id="account_number"
                                                    name="account_number" required>
                                            </div>

                                            <p class="btn btn-primary" id="check-btn">
                                                <span id="check-btn-text">Kiểm tra</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    id="loading-spinner" aria-hidden="true"></span>
                                            </p>

                                            <div id="check-result" class="mt-3"></div>

                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="is_default" name="is_default">
                                                <label class="form-check-label" for="is_default">
                                                    Đặt làm tài khoản mặc định
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <table id="payment-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ngân hàng</th>
                            <th>Số tài khoản</th>
                            <th>Chủ tài khoản</th>
                            <th>Trạng thái</th>
                            <th>Ngày thêm</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $index => $payment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $payment->bank_name }}</strong><br>
                                    <small class="text-muted">Mã: {{ $payment->bank_code }} | BIN:
                                        {{ $payment->bank_bin }}</small>
                                </td>
                                <td>{{ $payment->account_number }}</td>
                                <td>{{ $payment->account_name }}</td>
                                <td>
                                    @if ($payment->is_default)
                                        <button class="btn btn-sm btn-secondary" disabled>Mặc định</button>
                                    @else
                                        <form action="{{ route('settings.payment.set-default', $payment) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Đặt mặc
                                                định</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button type="button" class="btn btn-sm outline-none" data-bs-toggle="modal"
                                            data-bs-target="#payment-info-modal">
                                            <i class="bi bi-arrow-right-square text-dark fs-5"></i>
                                        </button>

                                        <div class="modal fade" id="payment-info-modal" tabindex="-1"
                                            aria-labelledby="payment-info-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="payment-info-modal">Thông tin
                                                            thanh toán
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="bank_name_info" class="form-label fw-bold">Ngân
                                                                hàng</label>
                                                            <input type="text" class="form-control"
                                                                id="bank_name_info" name="bank_name_info"
                                                                value="{{ $payment->bank_name }}" readonly>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="account_number_info" class="form-label fw-bold">Số
                                                                tài
                                                                khoản /
                                                                Số thẻ</label>
                                                            <input type="text" class="form-control"
                                                                id="account_number_info" name="account_number_info"
                                                                value="{{ $payment->account_number }}" readonly>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="account_name_info" class="form-label fw-bold">Tên
                                                                tài
                                                                khoản</label>
                                                            <input type="text" class="form-control"
                                                                id="account_name_info" name="account_name_info"
                                                                value="{{ $payment->account_name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('settings.payment.destroy', $payment) }}" method="POST"
                                            class="d-inline" name="delete-payment-form"
                                            data-payment-id="{{ $payment->id }}">
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
            $(document).ready(function() {
                const table = new DataTable('#payment-table', {
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
                const banks = @json($banks['data']);
                const bankRadio = $('input[type="radio"][name="bank_code"]');
                bankRadio.on('change', function(e) {
                    const bankCode = $(this).val();
                    const selectedBank = banks.find((bank) => bank.code == bankCode);

                    $('input#bank_name').val(selectedBank.name);
                    $('input#bank_bin').val(selectedBank.bin);
                })

                $('form[name="delete-payment-form"]').on('submit', function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const url = form.attr('action');
                    const csrf = $('meta[name="csrf-token"]').attr('content');
                    const paymentId = $(this).closest('form').data('payment-id');

                    Swal.fire({
                        title: 'Xoá tài khoản này?',
                        text: "Tài khoản thanh toán mặc định sẽ được chuyển về tài khoản tạo gần nhất.",
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
                                    payment_id: paymentId
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Đã xoá!',
                                        'Tài khoản đã được xoá thành công.',
                                        'success'
                                    ).then(() => {
                                        form.closest('tr').remove();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Lỗi!',
                                        'Không thể xoá tài khoản. Vui lòng thử lại.',
                                        'error'
                                    );
                                    console.log(xhr)
                                }
                            });
                        }
                    });
                });
            })
        </script>
    @endpush
@endsection
