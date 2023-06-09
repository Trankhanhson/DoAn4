@extends('admin.layout')
@section('styles')
    
@endsection
@section('scripts')
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/admin/FileAngularjs/CategoryAngular.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="CategoryApp" ng-controller="CategoryController">
    <h4 class="fw-bold">Danh mục sản phẩm</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" style="width:300px;" placeholder="Tìm kiếm theo tên hoặc đối tượng" />
                                <select ng-model="pageSize" class="limitShow">
                                    <option ng-click="getPageSize('5')" value="5">5</option>
                                    <option ng-click="getPageSize('10')" value="10">10</option>
                                    <option ng-click="getPageSize('15')" value="15">15</option>
                                    <option ng-click="getPageSize('20')" value="20">20</option>
                                </select>
                            </div>
                            <a class="btn btn-primary me-2" ng-click="Add()" href="" data-bs-toggle="modal" data-bs-target="#Addcategory"><i class="fa-solid fa-plus"></i> Thêm danh mục</a>
                        </div>
                        <table class="table table-striped table-hover table-bordered pt-4" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>
                                        Tên danh mục
                                    </th>
                                    <th>
                                        Đối tượng
                                    </th>
                                    <th>
                                        Tùy chỉnh
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="category-wrap">
                                <tr dir-paginate="cat in categories | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>
                                        @{{$index}}
                                    </td>
                                    <td>
                                        @{{cat.Name}}
                                    </td>
                                    <td>
                                        @{{cat.type}}
                                    </td>
                                    {{-- <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ng-click="ChangeStatusCategory(cat.CatID)" ng-checked="@{{cat.Active}}">
                                        </div>
                                    </td> --}}
                                    <td>
                                        <a class="btn-update" ng-click="Edit(cat,$index)" data-bs-toggle="modal" data-bs-target="#Editcategory" href=""><i class="fa-solid fa-pen-to-square" style="pointer-events:none;"></i></a>
                                        <a class="btn-delete btn-deleteHome" ng-click="Delete(cat)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination sortPagiBar">
                            <dir-pagination-controls max-size="maxSize"
                                                     boundary-links="true"
                                                     direction-links="true"
                                                     on-page-change="getPage(newPageNumber)"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal thêm danh mục-->
    <div class="modal fade" id="Addcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="createForm" novalidate>
                        <div class="form-horizontal">

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên danh mục</label>
                                <div class="col-sm-8">
                                    <input type="text" name="Name" class="form-control" ng-model="category.Name" required>
                                    <span ng-show="createForm.$submitted || createForm.Name.$dirty">
                                        <span class="error" ng-show="createForm.Name.$error.required">Tên danh mục không được để trống</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Đối tượng</label>
                                <div class="col-sm-8">
                                    <select class="form-select" aria-label="Default select example" ng-model="category.type">
                                        @foreach ($listType as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button class="btn btn-primary" ng-click="SaveAdd(true)">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <!--sửa danh mục-->
    <div class="modal fade" id="Editcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="editForm" novalidate>
                        <div class="form-horizontal">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Mã danh mục</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" ng-model="category.CatID" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên danh mục</label>
                                <div class="col-sm-8">
                                    <input type="text" name="Name" class="form-control" ng-model="category.Name" required>
                                    <span ng-show="editForm.$submitted || editForm.Name.$dirty">
                                        <span class="error" ng-show="editForm.Name.$error.required">Tên danh mục không được để trống</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Select</label>
                                <div class="col-sm-8">
                                    <select class="form-select" aria-label="Default select example" ng-model="category.type">
                                        @foreach ($listType as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button class="btn btn-primary" ng-click="SaveEdit()">Lưu</button>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection