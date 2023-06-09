@extends('admin.layout')
@section('scripts')
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/admin/FileAngularjs/Discount/DiscountHome.js"></script>
@endsection
@section('styles')
<link href="/assets/admin/css/DiscountProduct.css" rel="stylesheet" />

@endsection
@section('content')
    <main id="main" class="main" ng-app="discountApp" ng-controller="discountController">
        <h4 class="fw-bold">Danh sách chương trình khuyến mại</h4>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" placeholder="Nhập tên để tìm kiếm" />
                                    <select ng-model="pageSize" class="limitShow">
                                        <option ng-click="getPageSize('5')" value="5">5</option>
                                        <option ng-click="getPageSize('10')" value="10">10</option>
                                        <option ng-click="getPageSize('15')" value="15">15</option>
                                        <option ng-click="getPageSize('20')" value="20">20</option>
                                    </select>
                                </div>
                                <a href="{{ route('admin.Discount.Create') }}" class="btn btn-primary me-2"><i class="fa-solid fa-plus"></i> Thêm chương trình khuyến mại</a>
                            </div>
                            <table class="table table-hover table-bordered table-listProduct mt-3">
                                <thead class="text-dark table-primary">
                                    <tr>
                                        <th>Tên chương trình</th>
                                        <th>Bắt đầu</th>
                                        <th>Kết thúc</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr dir-paginate="item in discountList | itemsPerPage: pageSize" total-items="totalCount" class="row-product">
                                        <td>@{{item.Name}}</td>
                                        <td class="col">
                                            @{{item.StartDate | date:"dd/MM/yyyy 'at' h:mma"}}
                                        </td>
                                        <td class="col">@{{item.EndDate | date:"dd/MM/yyyy 'at' h:mma"}}</td>
                                        <td>
                                            <a class="btn-update bg-primary" ng-click="showDetail(item.DiscountProductId)" data-bs-toggle="modal" data-bs-target="#SeeDtail"><i class="fa-solid fa-eye"></i></a>
                                            {{-- <a class="btn-update" href="/Admin/Discount/Edit/@{{item.DiscountProductId}}"><i class="fa-solid fa-pen-to-square" style="pointer-events:none;"></i></a> --}}
                                            <a class="btn-delete" ng-click="Delete($index,item)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
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
                                        Chương trình <span>@{{Discount.Name}}</span>
                                    </h1>
                                </div>
                                <div class="order-date">
                                    <div>Bắt đầu: <b>@{{Discount.StartDate | date:"dd/MM/yyyy '-' h:mma"}}</b></div>
                                    <div>Kết thúc: <b>@{{Discount.EndDate | date:"dd/MM/yyyy '-' h:mma"}}</b></div>
                                </div>
                            </div>
                            <div class="order-details-items mt-3">
                                <form class="search-form d-flex align-items-center position-relative mb-3">
                                    <input type="search" name="query" class="search-product w-100" ng-model="searchDetail" placeholder="Nhập để tìm kiếm" title="Enter search keyword">
                                    <button type="submit" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
                                <table class="table-order-items table-product-selected rounded-2">
                                    <thead>
                                        <tr>
                                            <th class="col name">Sản phẩm</th>
                                            <th class="col originPrice">Giá gốc</th>
                                            <th class="col priceAfter">Giá sau giảm</th>
                                            <th class="col price-sale">Giảm giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in Discount.DiscountDetails | filter : searchDetail">
                                            <td class="col name">
                                                <div class="order-product">
                                                    <div class="order-product-photo">
                                                        <img src="/storage/uploads/Product/@{{item.Product.firstImage}}" alt="">
                                                    </div>
                                                    <div class="order-product-details">
                                                        <div class="order-product-name">
                                                            @{{item.Product.ProName}}
                                                        </div>
                                                        <div class="order-product-option">
                                                            <span>Mã: @{{item.Product.ProId}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col originPrice">@{{item.Product.Price | number: 0}}đ</td>
                                            <td class="col priceAfter">
                                                @{{item.priceAfter | number: 0}}đ
                                            </td>
                                            <td class="col price-sale">
                                                <div class="flex-grow-1 d-flex">
                                                    @{{item.Amount}}@{{item.TypeAmount}}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
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