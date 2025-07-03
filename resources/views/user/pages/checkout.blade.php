@extends('layouts.user')
@section('user.content')
    <div class="container">
        <div class="row">
            <div class="col-ml-8">
                <h3>Course list</h3>
                @foreach ($courses as $course)
                    {{ $loop->iteration }} - {{ $course->name }} - {{ number_format($course->original_price) }}đ<br>
                @endforeach
            </div>
            <div class="col-md-4">
                <h3>Total: {{ number_format($summary) }}đ</h3>
                <form action="{{ route('user.checkout.submit') }}" method="POST" name="checkout-form">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="course_ids" value="{{ implode(',', $courses->pluck('id')->toArray()) }}">
                    <button type="submit" class="btn btn-primary w-100">Checkout</button>
                </form>
            </div>
        </div>
    </div>
@endsection
