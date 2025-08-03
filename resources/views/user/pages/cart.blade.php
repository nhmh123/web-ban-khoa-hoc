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
                                    <input class="form-check-input me-2" type="radio" name="payment_method"
                                        value="bank_transfer_qr">
                                    <img src="https://play-lh.googleusercontent.com/22cJzF0otG-EmmQgILMRTWFPnx0wTCSDY9aFaAmOhHs30oNHxi63KcGwUwmbR76Msko"
                                        alt="VietQR" width="50" class="me-2">
                                    Chuyển khoản ngân hàng (VietQR)
                                </label>
                                <div id="vietqr-wrapper"
                                    class="d-none d-flex flex-column justify-content-center align-items-center"
                                    style="max-width: 500px; height: 500px;">
                                    <img id="qr-image" src="" class="img-fluid d-none">
                                    <div id="qr-loading" class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <label class="list-group-item d-flex align-items-center">
                                    <input class="form-check-input me-2" type="radio" name="payment_method"
                                        value="momo_qr">
                                    <img src="https://developers.momo.vn/v3/vi/assets/images/static-qr-banner-4ccada6ade3eb8ce5236eab5cabc5894.png"
                                        alt="MOMO QR" width="50" class="me-2">
                                    MOMO QR
                                </label>
                                <label class="list-group-item d-flex align-items-center">
                                    <input class="form-check-input me-2" type="radio" name="payment_method" value="momo"
                                        checked>
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

                                <form action="{{ route('user.checkout.momo') }}" method="POST" name="checkout-form">
                                    @csrf
                                    <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                    <input type="hidden" name="selected_payment_method">
                                    <button type="submit" class="btn btn-primary w-100">Tiến hành thanh
                                        toán</button>
                                </form>

                                <div class="modal fade" id="vietqr-modal" tabindex="-1"
                                    aria-labelledby="vietqr-modal-label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="vietqr-modal-label">Thông tin chuyển khoản
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Đóng"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img id="vietqrImage"
                                                    src="https://img.vietqr.io/image/VCB-0123456789-compact2.png?amount=500000&addInfo=NAPKHOAHOC123"
                                                    alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">

                                                <p><strong>Ngân hàng:</strong> Vietcombank</p>
                                                <p><strong>Số tài khoản:</strong> 0123456789</p>
                                                <p><strong>Chủ tài khoản:</strong> NGUYEN VAN A</p>
                                                <p><strong>Nội dung chuyển khoản:</strong> <code>NAPKHOAHOC123</code></p>

                                                <button class="btn btn-success mt-3" data-bs-dismiss="modal">Tôi đã thanh
                                                    toán</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('user.checkout.qr.generate') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Test generate</button>
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

                // $('input[name="ids[]"]').on('change', function() {
                //     let amountText = $(this).closest('.card').find('.course-price').text();
                //     amountText = amountText.split('.').join('');
                //     let amount = parseInt(amountText);

                //     if ($(this).is(':checked')) {
                //         totalCartRaw += amount;
                //         $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                //     } else {
                //         totalCartRaw -= amount;
                //         $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                //     }
                // });

                $('input[name="ids[]"]').on('change', function() {
                    totalCartRaw = 0;
                    $('input[name="ids[]"]:checked').each(function() {
                        let price = $(this).closest('.card').find('.course-price').text().split('.')
                            .join('');
                        totalCartRaw += parseInt(price);
                    });
                    $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));
                    $('form[name="checkout-form"]').find('input[type="hidden"][name="total_amount"]').val(
                        totalCartRaw);
                    generateCheckoutQr(totalCartRaw);
                });

                let checkoutForm = $('form[name="checkout-form"]');
                checkoutForm.on('submit', function(e) {
                    e.preventDefault();

                    let checkedCheckoutCourseElement = $('input[name="ids[]"]:checked')
                    let checkedIds = [];
                    checkedCheckoutCourseElement.each(function() {
                        checkedIds.push(parseInt($(this).val()));
                    })

                    console.log(checkedIds);
                    if (checkedIds.length === 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi!",
                            text: "Vui lòng chọn ít nhất một khóa học để thanh toán",
                        });
                        return;
                    }

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'checkout_course',
                        value: JSON.stringify(checkedIds)
                    }).appendTo(checkoutForm);

                    console.log(checkoutForm)
                    this.submit();
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
                            // let removedCoursePriceText = form.closest('.card').find('.course-price')
                            //     .text();
                            // let removedCoursePrice = parseInt(removedCoursePriceText.split('.')
                            //     .join(''), 10);
                            // totalCartRaw -= removedCoursePrice;
                            // $('.amount').text(Number(totalCartRaw).toLocaleString('vi-VN'));

                            form.closest('.card').remove();
                            $('input[name="ids[]"]').trigger('change');

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
                });

                let buyNowCourseId = '{{ $buyNowCourseId ?? '' }}';
                if (buyNowCourseId) {
                    totalCartRaw = 0;
                    $('input[name="ids[]"]').each(function() {
                        if ($(this).val() == buyNowCourseId) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
                        }
                    });
                    $('input[name="ids[]"]').trigger('change');
                }
                console.log(buyNowCourseId);

                const paymentMethod = $('input[name="payment_method"]');
                $('input[name="selected_payment_method"]').val($('input[name="payment_method"]:checked').val());
                paymentMethod.on('change', function() {
                    $('input[name="selected_payment_method"]').val($(this).val());
                    if ($('input[name="selected_payment_method"]').val() == "bank_transfer_qr") {
                        checkoutForm.attr('action', "");
                        $('#vietqr-wrapper').removeClass('d-none');
                        // checkoutForm.on('submit', function(e) {
                        //     alert("OK")
                        //     e.preventDefault();
                        //     const vietqrModal = $('#vietqr-modal');
                        //     vietqrModal.show();
                        // })
                        generateCheckoutQr(totalCartRaw);

                    } else {
                        $('#vietqr-wrapper').addClass('d-none');
                    }
                })

                function generateCheckoutQr(totalCartRaw) {
                    console.log("Send amount: " + totalCartRaw);
                    let csrf = $('meta[name="csrf-token"]').attr('content');

                    $('#vietqr-wrapper').removeClass('d-none');
                    $('#qr-image').addClass('d-none');
                    $('#qr-loading').removeClass('d-none');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.checkout.qr.generate') }}",
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        data: {
                            amount: totalCartRaw
                        },
                        success: function(response) {
                            let qrUrl = response.data.qrDataURL;
                            const qrImg = $('#qr-image');
                            qrImg.attr('src', qrUrl);
                            qrImg.on('load', function() {
                                $('#qr-loading').addClass('d-none');
                                qrImg.removeClass('d-none');
                            });
                        },
                        error: function(xrh) {
                            console.log(xhr)
                        }
                    });
                }
            })
        </script>
    @endpush
@endsection
