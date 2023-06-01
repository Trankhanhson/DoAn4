@extends('admin.layout')

@section('content')
<main id="main" class="main">
    <h4 class="fw-bold">Danh sách chức vụ</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">

                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Thêm chức vụ</a>

                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Danh sách quyền</th>
                                    <th style="width:15%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">Sửa</a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this role?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
