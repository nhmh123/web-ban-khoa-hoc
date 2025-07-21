@extends('layouts.user')
@section('user.content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1 class="mb-4 fw-bold">{{ $page->title }}</h1>

                <div class="page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
