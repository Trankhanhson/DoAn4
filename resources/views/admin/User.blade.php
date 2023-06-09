@extends('admin.layout')
@section('styles')
    
@endsection
@section('scripts')
<script src="/assets/framework//dirPagination.js"></script>
<script src="/assets/admin/FileAngularjs/UserAngular.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="UserApp" ng-controller="UserController">
    <h4 class="fw-bold">Danh sách nhân viên</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" placeholder="Nhập để tìm kiếm" />
                                <select ng-model="pageSize" ng-change="getPage(1)" class="limitShow">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <a class="btn btn-primary me-2" ng-click="Add()" href="" data-bs-toggle="modal" data-bs-target="#AddUser"><i class="fa-solid fa-plus"></i> Thêm nhân viên</a>

                        </div>
                        <table class="table table-striped table-hover table-bordered pt-4" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>Mã</th>
                                    <th>
                                        Tên
                                    </th>
                                    <th>
                                        Tài khoản
                                    </th>
                                    {{-- <th>
                                        Quyền
                                    </th> --}}
                                    <th>
                                        Số điện thoại
                                    </th>
                                    <th>
                                        Trạng thái
                                    </th>
                                    <th style="width:10%">
                                        Tùy chỉnh
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="u in listUser | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>
                                        @{{u.UserID}}
                                    </td>
                                    <td>
                                        @{{u.Name}}
                                    </td>
                                    <td>@{{u.UserName}}</td>
                                    {{-- <td>
                                        @{{u.UserGroup.Name}}
                                    </td> --}}
                                    <td>
                                        @{{u.UserPhone}}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch" ng-if="u.GroupId!=1">
                                            <input class="form-check-input" type="checkbox" ng-click="ChangeStatus(u.UserID)" ng-checked="@{{u.Status}}">
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn-update" ng-click="Edit(u,$index)" ng-if="u.GroupId!=1" data-bs-toggle="modal" data-bs-target="#EditUser" href=""><i class="fa-solid fa-pen-to-square" style="pointer-events:none;"></i></a>
                                        <a class="btn-delete btn-deleteHome" ng-click="Delete(u)" ng-if="u.GroupId!=1"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
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
    <div class="modal fade" id="AddUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="createForm" novalidate>
                        <div class="form-horizontal">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên nhân viên</label>
                                <div class="col-sm-8">
                                    <input type="text" name="Name" class="form-control" ng-model="user.Name" required>
                                    <span ng-show="createForm.$submitted">
                                        <span class="error" ng-show="createForm.Name.$error.required">Bạn chưa nhập tên nhân viên</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên tài khoản</label>
                                <div class="col-sm-8">
                                    <input type="text" name="UserName" class="form-control" maxlength="20" ng-model="user.UserName" required>
                                    <span ng-show="createForm.$submitted ">
                                        <span class="error" ng-show="createForm.UserName.$error.required">Bạn chưa nhập tên tài khoản</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Mật khẩu</label>
                                <div class="col-sm-8">
                                    <input type="password" name="Password" class="form-control" ng-model="user.Password" autocomplete="new-password" required>
                                    <span ng-show="createForm.$submitted ">
                                        <span class="error" ng-show="createForm.Password.$error.required">Bạn chưa nhập mật khẩu</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Xác nhận mật khẩu</label>
                                <div class="col-sm-8">
                                    <input type="password" name="comfirmPassword" class="form-control" ng-model="comfirmPassword" autocomplete="new-password" required>
                                    <span ng-show="createForm.$submitted">
                                        <span class="error" ng-show="createForm.comfirmPassword.$error.required">Xác nhận mật khẩu không đúng</span>
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Quyền</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="GroupId" ng-model="user.GroupId" required>
                                        @foreach (var i in ViewBag.ListGroups)
                                        {
                                            <option value="@i.GroupId">@i.Name</option>
                                        }
                                    </select>
                                    <span ng-show="createForm.$submitted">
                                        <span class="error" ng-show="createForm.GroupId.$error.required">Bạn chưa chọn trường này</span>
                                    </span>
                                </div>
                            </div> --}}
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Địa chỉ</label>
                                <div class="col-sm-8">
                                    <input type="text" name="UserAdress" class="form-control" ng-model="user.UserAdress">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Số điện thoại</label>
                                <div class="col-sm-8">
                                    <input type="text" name="UserPhone" class="form-control" maxlength="10" ng-model="user.UserPhone" required>
                                    <span ng-show="createForm.$submitted ">
                                        <span class="error" ng-show="createForm.UserPhone.$error.required">Bạn chưa nhập số điện thoại</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" ng-click="SaveAdd(true)">Lưu</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!--sửa danh mục nhân viên-->
    <div class="modal fade" id="EditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="editForm" novalidate>
                        <div class="form-horizontal">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên nhân viên</label>
                                <div class="col-sm-8">
                                    <input type="text" name="Name" class="form-control" ng-model="user.Name" required>
                                    <span ng-show="editForm.$submitted">
                                        <span class="error" ng-show="editForm.Name.$error.required">Bạn chưa nhập tên nhân viên</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Tên tài khoản</label>
                                <div class="col-sm-8">
                                    <input type="text" name="UserName" class="form-control" maxlength="20" ng-model="user.UserName" required>
                                    <span ng-show="editForm.$submitted ">
                                        <span class="error" ng-show="editForm.UserName.$error.required">Bạn chưa nhập tên tài khoản</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Mật khẩu mới</label>
                                <div class="col-sm-8">
                                    <input type="password" name="Password" class="form-control" ng-model="user.Password" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Xác nhận mật khẩu</label>
                                <div class="col-sm-8">
                                    <input type="password" name="comfirmPassword" class="form-control" ng-model="comfirmPassword" autocomplete="new-password">
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Quyền</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="GroupId" ng-model="user.GroupId" required>
                                        @foreach (var i in ViewBag.ListGroups)
                                        {
                                            <option value="@i.GroupId">@i.Name</option>
                                        }
                                    </select>
                                    <span ng-show="createForm.$submitted">
                                        <span class="error" ng-show="createForm.GroupId.$error.required">Bạn chưa chọn trường này</span>
                                    </span>
                                </div>
                            </div> --}}
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Địa chỉ</label>
                                <div class="col-sm-8">
                                    <input type="text" name="UserAdress" class="form-control" ng-model="user.UserAdress">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">Số điện thoại</label>
                                <div class="col-sm-8">
                                    <input type="text" name="UserPhone" class="form-control" maxlength="10" ng-model="user.UserPhone" required>
                                    <span ng-show="editForm.$submitted ">
                                        <span class="error" ng-show="editForm.UserPhone.$error.required">Bạn chưa nhập số điện thoại</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" ng-click="SaveEdit()">Lưu</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection