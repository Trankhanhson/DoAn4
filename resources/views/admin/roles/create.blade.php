@extends('admin.layout')

@section('content')
<main id="main" class="main">
    <h4 class="fw-bold">Thêm chức vụ</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                    
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                    
                            <div class="mb-3">
                                <label for="permissions" class="form-label">Danh sách quyền</label>
                                <select class="form-control" id="permissions" name="permissions[]" multiple required style="min-height:400px ;">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection
