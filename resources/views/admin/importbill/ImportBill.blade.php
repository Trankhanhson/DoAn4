@extends('admin.layout')
@section('styles')
<link href="/assets/admin/css/Order.css" rel="stylesheet" />
@endsection
@section('scripts')
<script src="/assets/framework/dirPagination.js"></script>
<script src="/assets/admin/FileAngularjs/ImportBill/ImportBillHome.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="importBillApp" ng-controller="importBillController">
    <h4 class="fw-bold">Danh sách hóa đơn nhập</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" placeholder="Tìm kiếm" />
                                <select ng-model="pageSize" class="limitShow">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('admin.ImportBill.Create') }}" class="btn btn-primary me-2"><i class="fa-solid fa-plus"></i> Tạo hóa đơn nhập</a>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered pt-4">
                            <thead class="table-primary">
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>
                                        Nhân viên tạo
                                    </th>
                                    <th>
                                        Thời gian
                                    </th>
                                    <th>Tổng tiền</th>
                                    <th>
                                        Chi tiết
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="i in ImportBills | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>@{{i.ImpId}}</td>
                                    <td>
                                        @{{i.user.name}}
                                    </td>
                                    <td>
                                        @{{i.created_at | date:"dd/MM/yyyy '-' h:mma"}}
                                    </td>
                                    <td>@{{i.MoneyTotal | number}}đ</td>
                                    <td>
                                        <a class="btn-tool bg-primary" ng-click="showDetail(i)" data-bs-toggle="modal" data-bs-target="#SeeDtail"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn-tool btn-delete" ng-click="cancel($index,i)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
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
    <div class="modal fade" id="SeeDtail" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div>
                        <div class="order-detail-top">
                            <div class="account-page-title">
                                <h1 class="title">
                                    Chi tiết đơn hàng <span>#CNF@{{ImportBill.ImpId}}</span>
                                </h1>
                            </div>
                            <div class="order-date">
                                <div>Ngày tạo: <b>@{{ImportBill.created_at | date:"dd/MM/yyyy '-' h:mma"}}</b></div>
                                <div>Người tạo: <b>@{{ImportBill.user.id}} @{{ImportBill.user.name}}</b></div>
                            </div>
                        </div>
                        <div class="order-details-items mt-3">
                            <table class="table-order-items">
                                <thead>
                                    <tr>
                                        <th class="col name">Sản phẩm</th>
                                        <th class="col">Số lượng</th>
                                        <th class="col ">Giá nhập</th>
                                        <th class="col total">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in ImportBill.import_bill_details">
                                        <td class="col name">
                                            <div class="order-product">
                                                <div class="order-product-photo">
                                                    <img src="/storage/uploads/Product/@{{item.product_variation.DisplayImage}}" alt="Không ảnh">
                                                </div>
                                                <div class="order-product-details">
                                                    <div class="order-product-name">
                                                        @{{item.product_variation.product.ProName}}
                                                    </div>
                                                    <div class="order-product-option d-flex align-items-center">
                                                        <span>Màu: @{{item.product_variation.product_color.NameColor}}</span>
                                                    </div>
                                                    <div class="order-product-option">
                                                        <span>Kích cỡ :</span> <span>
                                                            @{{item.product_variation.product_size.NameSize}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col qty">@{{item.Quantity}}</td>
                                        <td class="col">
                                            @{{item.ImportPrice | number}}đ
                                        </td>
                                        <td class="col total">@{{item.ImportPrice * item.Quantity | number}}đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="order-details-totals">
                            <table>
                                <tbody>
                                    <tr class="quantity">
                                        <th>Tổng sản phẩm</th>
                                        <td>@{{ListDetail.length}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="grand-totals">
                                        <th style="color: rgb(51, 63, 72); font-weight: 600;">Tổng tiền thanh toán</th>
                                        <td style="font-weight: 600;">@{{ImportBill.MoneyTotal | number}}đ</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection