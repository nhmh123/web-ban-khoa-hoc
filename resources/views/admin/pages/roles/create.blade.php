@extends('layouts.admin')
@section('admin.content')
    <div id="content" class="container-fluid">
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
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Thêm mới vai trò</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-strong" for="name">Tên vai trò</label>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label class="text-strong" for="description">Mô tả</label>
                        <textarea class="form-control" type="text" name="description" id="description">{{ old('description') }}</textarea>
                    </div>
                    <strong>Vai trò này có quyền gì?</strong>
                    <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                        quyền.</small>
                    <!-- List Permission  -->

                    @php
                        $i = 1;
                    @endphp
                    @foreach ($permissions as $moduleName => $permissionModel)
                        <div class="card my-4 border">
                            <div class="card-header">
                                <input type="checkbox" class="check-all form-check-input" name=""
                                    id="{{ $moduleName }}">
                                <label for="{{ $moduleName }}"
                                    class="m-0 form-check-label"><strong>{{ $moduleName }}</strong></label>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($permissionModel as $permission)
                                        <div class="col-md-3">
                                            <input type="checkbox" class="permission form-check-input"
                                                value="{{ $permission->id }}" name="permission_id[]"
                                                id="{{ $permission->slug }}"
                                                {{ in_array($permission->id, old('permission_id', [])) ? 'checked' : '' }}>
                                            <label for="{{ $permission->slug }}"
                                                class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <input type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.check-all').click(function() {
            $(this).closest('.card').find('.permission').prop('checked', this.checked)
        })
    </script>
@endsection
