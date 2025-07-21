@extends('layouts.user')

@section('user.content')
    <div class="container my-5">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>

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

        <div class="cart-wrapper">
            @if (count($cartItems) > 0)
                @php
                    $cartTotal = $cartItems->sum(function ($item) {
                        $price = $item->course->original_price;
                        return is_numeric($price) ? (float) $price : 0;
                    });
                @endphp

                <div class="row">
                    <div class="col-md-8">
                        <div id="cart-container">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <input type="checkbox" id="checkAll" checked>
                                    <label for="checkAll">Chọn tất cả</label>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm" name="clear-cart-button">Xóa toàn
                                    bộ</button>
                            </div>
                            @foreach ($cartItems as $item)
                                <div class="card border-0 p-0 my-2">
                                    <div class="row g-0">
                                        <div class="col-md-1 d-flex align-items-center justify-content-start">
                                            <input type="checkbox" name="ids[]" value="{{ $item->course->id }}" checked>
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ $item->course->thumbnail }}" class="rounded-start w-100 h-100"
                                                style="object-fit: cover;" alt="Course Image">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0 my-0 d-flex flex-column h-100">
                                                <h5 class="card-title fs-6 fw-bold">{{ $item->course->name }}</h5>
                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                    <div>
                                                        <div class="mb-0 text-end fw-bold">
                                                            <span class="course-price">
                                                                {{ $item->course->original_price }}</span>
                                                            <span>đ</span>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('user.cart.remove', $item->course->id) }}"
                                                        method="POST" name="remove-cart-item-form"
                                                        data-course-id="{{ $item->course->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm p-0 outline-none border-none">
                                                            <i class="bi bi-trash text-dark fs-5"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="col-md-4">
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
                                    <input class="form-check-input me-2" type="radio" name="payment_method"
                                        value="momo">
                                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png"
                                        alt="MOMO" width="50" class="me-2">
                                    MOMO
                                </label>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Thông tin thanh toán</h5>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Tổng tiền:</span>
                                        <div class="text-end fw-bold">
                                            <span class="amount">{{ $cartTotal }}</span>
                                            <span>đ</span>
                                        </div>
                                    </li>
                                </ul>

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
                    Giỏ hàng của bạn đang trống. <a href="/">Khám phá khóa học</a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let checkAll = $('#checkAll');
                checkAll.on('change', function() {
                    let isChecked = this.checked;
                    $('input[name="ids[]"]').prop('checked', isChecked).trigger('change');
                });

                let totalCartRaw = parseInt($('.amount').text(), 10)
                $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                $('.course-price').each(function() {
                    let price = parseInt($(this).text(), 10);
                    $(this).text(Number(price).toLocaleString('vi-VN'));
                });

                $('input[name="ids[]"]').on('change', function() {
                    let amountText = $(this).closest('.card').find('.course-price').text();
                    amountText = amountText.split('.').join('');
                    let amount = parseInt(amountText);

                    if ($(this).is(':checked')) {
                        totalCartRaw += amount;
                        $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                    } else {
                        totalCartRaw -= amount;
                        $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                    }
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

                $('form[name="remove-cart-item-form"]').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const url = form.attr('action');
                    const csrf = $('meta[name="csrf-token"]').attr('content');
                    const courseId = form.data('course-id');

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            course: courseId
                        },
                        success: function(response) {
                            console.log(response);
                            let removedCoursePriceText = form.closest('.card').find('.course-price')
                                .text();
                            let removedCoursePrice = parseInt(removedCoursePriceText.split('.')
                                .join(''), 10);
                            totalCartRaw -= removedCoursePrice;
                            $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                            form.closest('.card').remove();

                            if ($('form[name="remove-cart-item-form"]').length === 0) {
                                $('.cart-wrapper').html(
                                    '<div class="alert alert-info">Giỏ hàng của bạn đang trống. <a href="/">Khám phá khóa học</a></div>'
                                );
                            }

                            updateCartTotal(
                                    '{{ route('user.cart.get-total') }}');
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                        }
                    });
                })

                let clearCartButton = $('button[name="clear-cart-button"]');
                clearCartButton.on('click', function() {
                    let removedCourseList = $('input[name="ids[]"]:checked');
                    let removedCourseIds = [];
                    removedCourseList.each(function() {
                        removedCourseIds.push(parseInt($(this).val()));
                    })
                    console.log(removedCourseIds);

                    let clearCartUrl = "{{ route('user.cart.clear') }}";
                    let csrf = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                        title: 'Làm sạch giỏ hàng?',
                        text: "Bạn muốn xóa tất cả khóa học khỏi giỏ hàng!",
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
                                url: clearCartUrl,
                                headers: {
                                    "X-CSRF-TOKEN": csrf,
                                },
                                success: function(response) {
                                    console.log(response);

                                    Swal.fire(
                                        'Đã xóa!',
                                        'Làm sạch giỏ hàng thành công.',
                                        'success'
                                    ).then(() => {
                                        $('.cart-wrapper').html(
                                            '<div class="alert alert-info">Giỏ hàng của bạn đang trống. <a href="/home">Khám phá khóa học</a></div>'
                                        );
                                        updateCartTotal(
                                            '{{ route('user.cart.get-total') }}'
                                        );
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr);
                                }
                            });
                        }
                    });


                })
            })
        </script>
    @endpush
@endsection
