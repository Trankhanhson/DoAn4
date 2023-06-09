@extends('admin.layout')
@section('styles')
    
@endsection
@section('scripts')
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/admin/FileAngularjs/CustomerAngular.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="CustomerApp" ng-controller="CustomerController">
    <h4 class="fw-bold">Danh sách khách hàng</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" placeholder="Tìm kiếm theo tên hoặc số điện thoại" />
                                <select ng-model="pageSize" ng-change="getPage(1)" class="limitShow">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered pt-4" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>
                                        Số điện thoại
                                    </th>

                                    <th>
                                        Địa chỉ
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="category-wrap">
                                <tr dir-paginate="cus in customers | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>
                                        @{{$index}}
                                    </td>
                                    <td>
                                        @{{cus.Name}}
                                    </td>
                                    <td>
                                        @{{cus.Phone}}
                                    </td>
 
                                    <td>@{{cus.Address}}</td>
                                    {{-- <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" ng-click="ChangeStatus(cus.CusID)" ng-checked="@{{cus.Status}}">
                                        </div>
                                    </td> --}}

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