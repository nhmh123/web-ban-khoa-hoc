@extends('layouts.user')

@section('user.content')
    <div class="container my-5">
        <h3 class="text-start mb-4">Danh sách mong muốn</h3>
        <div class="row">
            <div class="col-md-12">
                @if ($wishlistCourses->isEmpty())
                    <p class="text-muted">Bạn chưa thêm khóa học nào vào danh sách mong muốn.</p>
                @else
                    <div class="row mt-3">
                        @foreach ($wishlistCourses as $course)
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm mb-4 h-100 d-flex flex-column">
                                    <img src="{{ $course->thumbnail }}" class="card-img-top"
                                        style="height: 150px; object-fit: cover;" alt="Course Image">

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fs-6 fw-bold">{{ $course->name }}</h5>
                                        <p class="card-text small text-muted mb-1">
                                            {{ Str::limit($course->sort_description, 80) }}</p>
                                        <p class="mb-1 small">{{ $course->user->name }}</p>
                                        <p class="mb-1 small">⭐⭐⭐⭐⭐ (4.8)</p>

                                        @if ($course->sale_price)
                                            <div class="d-flex align-items-center mb-2">
                                                <span
                                                    class="text-decoration-line-through text-muted me-2">{{ $course->original_price }}</span>
                                                <span class="fw-bold text-danger">{{ $course->sale_price }}</span>
                                            </div>
                                        @else
                                            <p class="fw-bold text-primary mb-2">{{ $course->original_price }}</p>
                                        @endif

                                        <div class="mt-auto d-flex gap-2">
                                            <!-- Add to Cart -->
                                            <form action="" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100">
                                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                                </button>
                                            </form>

                                            <!-- Remove from Wishlist -->
                                            <form action="{{ route('user.wishlist.remove', $course->id) }}" method="POST"
                                                name="remove-from-wishlist">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                    <i class="bi bi-heartbreak"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let removeFromWishlist = $('form[name="remove-from-wishlist"]');
                removeFromWishlist.on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let url = form.attr('action');

                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: form.serialize(),
                        success: function(response) {
                            console.log('Success:', response);
                            alert(response.message ||
                                'Khóa học đã được xóa khỏi danh sách yêu thích.');
                            location.reload();
                            // form.hide();
                            // addToWishlist.show();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error, status, xhr);
                            alert('Đã xảy ra lỗi khi xóa khóa học khỏi danh sách yêu thích.');
                        }
                    })
                });
            })
        </script>
    @endpush
@endsection
