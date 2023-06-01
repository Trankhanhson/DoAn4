@extends('admin.layout')
@section('styles')
    
@endsection
@section('scripts')
<script src="/assets/framework/ng-file-upload-shim.min.js"></script>
<script src="/assets/framework/ng-file-upload.min.js"></script>

<!--để ckfinder trên editor-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.21.0/ckeditor.js"></script>
<script src="/assets/admin/FileAngularjs/New/CreateNewAngularjs.js"></script>

<script>
    CKEDITOR.replace('Content');
</script>
@endsection
@section('content')
<main id="main" class="main" ng-app="PostApp" ng-controller="PostController">
    <h4 class="fw-bold">Thêm bài viết</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <form name="createForm" novalidate>
                            <div class="form-horizontal">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Tiêu đề</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="Title" ng-model="Post.Title" required>
                                        <span ng-show="createForm.$submitted || createForm.Title.$dirty">
                                            <span class="error" ng-show="createForm.Title.$error.required">Tiêu đề không được để trống</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nhân viên</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" id="select-cat" aria-label="Default select example" ng-model="Post.UserID">
                    
                                            @foreach ($listUser as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label">Ảnh</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" id="formFile" onchange="angular.element(this).scope().setFile(this)">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Nội dung</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="Content" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" ng-click="SaveAdd()">Lưu</button>
                                <a class="btn btn-primary" href="{{ route('admin.Post') }}">Trang chủ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection