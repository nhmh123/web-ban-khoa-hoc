@extends('layouts.admin')
@section('admin.content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                @session('success')
                    <div class="alert alert-success">{{ session('success') }}</div>
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
                    <div class="card-header font-weight-bold">
                        Thêm quyền
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('permissions.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên quyền</label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <small class="form-text text-muted pb-2">Ví dụ: posts.add</small>
                                <input class="form-control" type="text" name="slug" id="slug"
                                    value="{{ old('slug') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" type="text" name="description" id="description"> </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($permissions as $moduleName => $modulePermissions)
                                    <tr>
                                        <td scope="row"></td>
                                        <td><strong>{{ ucfirst($moduleName) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                        @foreach ($modulePermissions as $permission)
                                    <tr>
                                        <td scope="row">{{ $i++ }}</td>
                                        <td>|--- {{ $permission->name }}</td>
                                        <td>{{ $permission->slug }}</td>
                                        <td>{{ $permission->description }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm p-0">
                                                <i class="bi bi-pencil-square text-dark fs-5"></i>
                                            </a>
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm p-0">
                                                    <i class="bi bi-trash text-dark fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
