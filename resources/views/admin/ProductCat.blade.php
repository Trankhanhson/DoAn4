@extends('admin.layout')
@section('scripts')
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/framework/ng-file-upload-shim.min.js"></script>
    <script src="/assets/framework/ng-file-upload.min.js"></script>
    <script src="/assets/admin/FileAngularjs/productCatAngular.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="ProCatApp" ng-controller="ProCatController">
    <h4 class="fw-bold">Danh sách loại sản phẩm</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" style="width:300px;" ng-model="searchText" ng-change="GetPageProCat(1)" placeholder="Tìm kiếm theo tên hoặc theo đối tượng" />
                                <select ng-model="pageSize" class="limitShow">
                                    <option ng-click="getPageSize('5')" value="5">5</option>
                                    <option ng-click="getPageSize('10')" value="10">10</option>
                                    <option ng-click="getPageSize('15')" value="15">15</option>
                                    <option ng-click="getPageSize('20')" value="20">20</option>
                                </select>
                            </div>
                            <a ng-click="Add()" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#AddProCat"><i class="fa-solid fa-plus"></i> Thêm loại sản phẩm</a>
                        </div>
                        <table class="table table-hover pt-4" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>
                                        Tên loại sản phẩm
                                    </th>
                                    <th>
                                        Danh mục cha
                                    </th>
                                    <th>
                                        Tùy chỉnh
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="category-wrap">
                                <tr dir-paginate="pc in ProCatList | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>@{{$index+1}}</td>
                                    <td>
                                        <img  src="/storage/uploads/ProductCat/@{{ pc.Image }}" alt="" style="width: 50px;height:50px;" />
                                        {{-- <img ng-if="pc.Image==false" src="/assets/image/ProductCat/no-image.jpg" alt="" style="width: 50px;height:50px;" /> --}}
                                    </td>
                                    <td>
                                        @{{pc.Name}}
                                    </td>
                                    <td>
                                        @{{pc.category.Name}} - @{{pc.category.type}}
                                    </td>
                                    <td>
                                        <a class="btn-update" ng-click="Edit(pc,$index)" data-bs-toggle="modal" data-bs-target="#Editcategory" href=""><i class="fa-solid fa-pen-to-square" style="pointer-events:none;"></i></a>
                                        <a class="btn-delete btn-deleteHome" ng-click="Delete(pc)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination sortPagiBar">
                            <dir-pagination-controls max-size="maxSize"
                                                     boundary-links="true"
                                                     direction-links="true"
                                                     on-page-change="GetPageProCat(newPageNumber)"></dir-pagination-controls>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Thêm loại sản phẩm-->
    <div class="modal fade" id="AddProCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label for="inputText" class="col-sm-4 col-form-label">Tên loại sản phẩm</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Name" ng-model="proCat.Name" required>
                                    <span ng-show="createForm.$submitted || editForm.Name.$dirty">
                                        <span class="error" ng-show="createForm.Name.$error.required">Tên loại sản phẩm không được để trống</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Select</label>
                                <div class="col-sm-8">
                                    <select class="form-select" aria-label="Default select example" ng-model="proCat.CatID">
                                        @foreach ($CatList as $item)
                                            <option value="{{ $item->CatID }}">{{ $item->Name }} - {{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-4 col-form-label">Ảnh</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" onchange="angular.element(this).scope().setFile(this)">
                                    <span>
                                        <span class="error" ng-show="errorImage">Bạn cần chọn hình ảnh</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button class="btn btn-primary" ng-click="SaveAdd()">Lưu</button>
                </div>

            </div>
        </div>
    </div>

    <!--sửa loại sản phẩm-->
    <div class="modal fade" id="Editcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa loại sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="editForm" novalidate>
                        <div class="form-horizontal">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên loại sản phẩm</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="Name" ng-model="proCat.Name" required>
                                    <span ng-show="editForm.$submitted || editForm.Name.$dirty">
                                        <span class="error" ng-show="editForm.Name.$error.required">Tên loại sản phẩm không được để trống</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Select</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="select-cat" aria-label="Default select example" ng-model="proCat.CatID">
                                        @foreach ($CatList as $item)
                                            <option value="{{ $item->CatID }}">{{ $item->Name }} - {{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-4 col-form-label">Ảnh</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" onchange="angular.element(this).scope().setFile(this)">
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