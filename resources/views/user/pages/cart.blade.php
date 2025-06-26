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
                $cartTotal = $cartItems->sum(function ($item) {
                    return $item->course->sale_price ?? $item->course->original_price;
                });
            @endphp
            <div class="row">
                <!-- Cart Items -->
                <div class="col-md-8">
                    <form action="{{ route('user.cart.clear') }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ khóa học khỏi giỏ hàng?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                        <table class="table">
                            <tr>
                                <th>
                                    <input type="checkbox" id="checkAll" checked>
                                </th>
                                <th>Tên khóa học</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $item->course->id }}" checked>
                                        </td>
                                        <td class="d-flex align-items-between">
                                            <div class="col-md-4">
                                                <img src="{{ $item->course->thumbnail }}" class="img-fluid"
                                                    alt="Course Thumbnail">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <a href="" class="card-title">{{ $item->course->name }}</a>
                                                    <p class="card-text small text-muted">
                                                        {{ $item->course->user->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p
                                                class="card-text fw-bold {{ $item->course->sale_price ? 'text-decoration-line-through' : '' }} ">
                                                {{ $item->course->original_price }}đ
                                            </p>
                                            <p class="card-text fw-bold text-danger">
                                                {{ $item->course->sale_price ?? $item->course->original_price }}đ
                                            </p>
                                        </td>
                                        <td>
                                            <form action="{{ route('user.cart.remove', $item->course->id) }}"
                                                method="POST" name="remove-from-cart">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>

                <!-- Checkout Summary -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin thanh toán</h5>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tổng tiền:</span>
                                    <strong>{{ number_format($cartTotal) }}đ</strong>
                                </li>
                            </ul>
                            {{-- Checkout button --}}
                            <button type="submit" class="btn btn-primary w-100">Tiến hành thanh
                                toán</button>
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
                checkAll.on('change', function() {
                    $('input[name="ids[]"]').prop('checked', this.checked);
                })

                let checks = $('input[name="ids[]"]');
                console.log(checks);
                checks.each(function() {
                    console.log($(this).val());
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
