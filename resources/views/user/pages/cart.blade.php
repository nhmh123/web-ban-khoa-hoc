@extends('layouts.user')

@section('user.content')
    <div class="container my-5">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        @if (count($cartItems) > 0)
            @php
                // $cartTotal = $cartItems->sum(function ($item) {
                //     $price = $item->course->sale_price ?? ($item->course->original_price ?? 0);
                //     return is_numeric($price) ? (float) $price : 0;
                // });

                $cartTotal = $cartItems->sum(function ($item) {
                    $price = $item->course->original_price;
                    return is_numeric($price) ? (float) $price : 0;
                });
            @endphp

            <div class="row">
                <!-- Cart Items -->
                <div class="col-md-8">
                    <form action="{{ route('user.cart.clear') }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ khóa học khỏi giỏ hàng?')">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <input type="checkbox" id="checkAll" checked>
                                <label for="checkAll">Chọn tất cả</label>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm">Xóa toàn bộ</button>
                        </div>

                        @foreach ($cartItems as $item)
                            <div class="card border-0 p-0 my-2">
                                <div class="row g-0">
                                    <!-- Checkbox + Thumbnail -->
                                    <div class="col-md-1 d-flex align-items-center justify-content-start">
                                        <input type="checkbox" name="ids[]" value="{{ $item->course->id }}" checked>
                                    </div>
                                    <div class="col-md-3">
                                        <img src="{{ $item->course->thumbnail }}" class="rounded-start w-100 h-100"
                                            style="object-fit: cover;" alt="Course Image">
                                    </div>

                                    <!-- Course Info -->
                                    <div class="col-md-8">
                                        <div class="card-body py-0 my-0 d-flex flex-column h-100">
                                            <h5 class="card-title fs-6 fw-bold">{{ $item->course->name }}</h5>
                                            <p class="card-text small mb-1">{{ $item->course->user->name }}</p>

                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <div>
                                                    {{-- @if ($item->course->sale_price)
                                                        <p class="mb-1">
                                                            <span class="text-decoration-line-through text-muted">
                                                                {{ $item->course->original_price_formatted }}đ
                                                            </span>
                                                            <span class="text-danger fw-bold ms-2">
                                                                {{ $item->course->sale_price }}đ
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p class="mb-1 fw-bold">
                                                            {{ $item->course->original_price_formatted }}đ
                                                        </p>
                                                    @endif --}}

                                                    <p class="mb-0 text-end fw-bold">
                                                        {{ $item->course->original_price_formatted }}đ
                                                    </p>
                                                </div>
                                                <form action="{{ route('user.cart.remove', $item->course->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Xóa khóa học này khỏi giỏ hàng?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">Xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                        @endforeach
                    </form>
                </div>


                <!-- Checkout Summary -->
                <div class="col-md-4">
                    {{-- Chọn phương thức thanh toán --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phương thức thanh toán</label>
                        <div class="list-group">
                            <label class="list-group-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="vnpay"
                                    checked>
                                <img src="https://vinadesign.vn/uploads/images/2023/05/vnpay-logo-vinadesign-25-12-57-55.jpg"
                                    alt="VNPAY" width="50" class="me-2">
                                VNPAY
                            </label>
                            <label class="list-group-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="momo">
                                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png"
                                    alt="MOMO" width="50" class="me-2">
                                MOMO
                            </label>
                            <label class="list-group-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="cod">
                                <img src="https://cdn-icons-png.flaticon.com/512/11237/11237490.png" alt="COD"
                                    width="50" class="me-2">
                                Thanh toán khi nhận hàng (COD / Test)
                            </label>
                        </div>
                    </div>

                    {{-- Khu vực nhập mã giảm giá --}}
                    {{-- <form method="POST" action="" class="mb-3">
                        @csrf
                        <label for="coupon_code" class="form-label fw-bold">Mã giảm giá</label>
                        <div class="input-group">
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control"
                                placeholder="Nhập mã giảm giá">
                            <button class="btn btn-outline-secondary" type="submit">Áp dụng</button>
                        </div>
                        @if (session('coupon_error'))
                            <small class="text-danger">{{ session('coupon_error') }}</small>
                        @elseif (session('coupon_success'))
                            <small class="text-success">{{ session('coupon_success') }}</small>
                        @endif
                    </form> --}}

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin thanh toán</h5>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tổng tiền:</span>
                                    <strong>{{ number_format($cartTotal) }}đ</strong>
                                </li>
                            </ul>
                            {{-- Checkout button after online checkout integrate --}}
                            {{-- <form action="{{ route('user.checkout') }}" method="POST" name="checkout-form">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Tiến hành thanh
                                    toán</button>
                            </form> --}}

                            <form action="{{ route('user.checkout.submit') }}" method="POST" name="checkout-form">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Tiến hành thanh
                                    toán</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Giỏ hàng của bạn đang trống. <a href="">Khám phá khóa học</a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let checkAll = $('#checkAll');
                let checkedCheckoutCourseIds = $('input[name="ids[]"]:checked').toArray().map(input => input.value);
                console.log(checkedCheckoutCourseIds);
                checkAll.on('change', function() {
                    let isChecked = this.checked;
                    $('input[name="ids[]"]').prop('checked', isChecked).trigger('change');
                });

                $('input[name="ids[]"]').on('change', function() {
                    let val = $(this).val();
                    if ($(this).is(':checked')) {
                        if (!checkedCheckoutCourseIds.includes(val)) {
                            checkedCheckoutCourseIds.push(val);
                        }
                    } else {
                        checkedCheckoutCourseIds = checkedCheckoutCourseIds.filter(id => id !== val);
                    }

                    console.log(checkedCheckoutCourseIds); // Xem kết quả mỗi lần thay đổi
                });

                let checkoutForm = $('form[name="checkout-form"]');
                checkoutForm.on('submit', function(e) {
                    e.preventDefault();
                    if (checkedCheckoutCourseIds.length === 0) {
                        alert('Vui lòng chọn ít nhất một khóa học để thanh toán.');
                        return false;
                    }

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'checkout_course',
                        value: JSON.stringify(checkedCheckoutCourseIds)
                    }).appendTo(checkoutForm);

                    checkoutForm.off('submit').submit();
                })



                // let removeFromCart = $('form[name="remove-from-cart"]');
                // removeFromCart.on('submit', function(e) {
                //     e.preventDefault();
                //     if (confirm('Bạn có chắc chắn muốn xóa khóa học này khỏi giỏ hàng?')) {
                //         let form = $(this);
                //         let url = form.attr('action');

                //         $.ajax({
                //             url: url,
                //             type: 'POST',
                //             data: $(this).serialize(),
                //             success: function(response) {
                //                 location.reload();
                //             },
                //             error: function(xhr, status, error) {
                //                 alert('Có lỗi xảy ra khi xóa khóa học khỏi giỏ hàng.');
                //             }
                //         });
                //     }
                // });
            })
        </script>
    @endpush
@endsection
