@extends('admin.layout')
@section('styles')
    
@endsection
@section('scripts')
<script src="/assets/framework/dirPagination.js"></script>
<script src="/assets/admin/FileAngularjs/New/HomeNewAngular.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="PostApp" ng-controller="PostController">
    <h4 class="fw-bold">Danh sách bài viết</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" placeholder="Tìm kiếm theo tên" />
                                <select ng-model="pageSize" ng-change="getPage(1)" class="limitShow">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <a href="{{ route('admin.Post.Create') }}" class="btn btn-primary me-2"><i class="fa-solid fa-plus"></i> Thêm Bài viết</a>
                        </div>
                        <table class="table table-striped table-hover table-bordered pt-4" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>
                                        Tiêu đề
                                    </th>
                                    <th>
                                        Nhân viên lập
                                    </th>
                                    <th>
                                        Ngày lập
                                    </th>
                                    <th>
                                        Trạng thái
                                    </th>
                                    <th>
                                        Tùy chỉnh
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="category-wrap">
                                <tr dir-paginate="n in PostList | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>@{{$index}}</td>
                                    <td class="text-center"><img src="/storage/uploads/Post/@{{n.Image}}" alt="" style="width:100px;" /></td>
                                    <td>
                                        @{{n.Title}}
                                    </td>
                                    <td>
                                        @{{n.user.name}}
                                    </td>
                                    <td>@{{n.PublicDate | date:"dd/MM/yyyy 'at' h:mma"}}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ng-click="" ng-checked="@{{n.Status}}">
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn-update" href="http://localhost:8000/admin/post/updateView/@{{n.PostId}}"><i class="fa-solid fa-pen-to-square" style="pointer-events:none;"></i></a>
                                        <a class="btn-delete btn-deleteHome" ng-click="Delete(n)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
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

</main>
@endsection