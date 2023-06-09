@extends('admin.layout')
@section('scripts')
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/framework/jquery.validate.min.js"></script>
    <script src="/assets/admin/js/product/product.js"></script>
    <script src="/assets/admin/js/product/DeleteProduct.js"></script>
    <script src="/assets/admin/FileAngularjs/Product/IndexProductAngular.js"></script>
@endsection
@section('styles')
    <link href="/assets/admin/css/Product.css" rel="stylesheet" />
@endsection
@section('content')
<main id="main" class="main" ng-app="ProductApp" ng-controller="ProductController">
    <h4 class="fw-bold">Danh sách sản phẩm</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" style="width: 400px" ng-model="searchText" ng-change="getPage(1)" placeholder="Tìm kiếm theo tên" />
                                <select ng-model="pageSize" class="limitShow" ng-change="getPage(1)">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>

                                <select ng-model="minimumQuantity" class="limitShow ms-3" style="width: 200px;max-width: 200px" ng-change="getPage(1)">
                                    <option value="0">Hiện tất cả</option>
                                    <option value="1">Sản phẩm cần nhập</option>
                                </select>
                            </div>
                            <a href="{{ route('admin.Product.Create') }}" class="btn btn-primary me-2"><i class="fa-solid fa-plus"></i> Thêm sản phẩm</a>
                        </div>
                        <table class="table bg-white table-listProduct mt-3">
                            <thead class="text-dark">   
                                <tr>
                                    <th class="col-name">Sản phẩm</th>
                                    <th class="col-procat">Loại hàng</th>
                                    <th class="col-importPrice">Giá vốn</th>
                                    <th class="col-price">Giá bán</th>
                                    <th class="col-status">Trạng thái</th>
                                    <th class="col-quantity">Tồn kho</th>
                                    <th class="col-ordered">Đã đặt</th>
                                    <th style="width:8%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="item in products | itemsPerPage: pageSize" total-items="totalCount">
                                    <td colspan="10" class="p-0 border-0">
                                        <table class="w-100">
                                            <tbody>
                                                <tr class="row-product row-product-@{{item.ProId}}" ng-click="showVariation(item.ProId)">
                                                    <td class="col-name">@{{item.ProName}}</td>
                                                    <td class="col-procat">@{{item.product_cat.Name}}</td>
                                                    <td class="col-importPrice">@{{item.ImportPrice | number}}đ</td>
                                                    <td class="col-price">@{{item.Price | number}}đ</td>
                                                    <td class="col-status">
                                                        <div class="form-check form-switch d-inline-block" ng-click="ChangeStatus($event, item.ProId)">
                                                            <input class="form-check-input" style="cursor:pointer" type="checkbox" checked ng-if="item.Status ==true">
                                                            <input class="form-check-input" style="cursor:pointer" type="checkbox" ng-if="item.Status==false">
                                                        </div>
                                                    </td>
                                                    <td class="col-quantity"></td>
                                                    <td class="col-ordered"></td>
                                                    <td style="width:8%">
                                                        <a class="btn-update" href="http://localhost:8000/admin/product/updateView/@{{ item.ProId }}"><i class="fa-solid fa-pen-to-square" style="pointer-events:none;"></i></a>
                                                        <a class="btn-delete" ng-click="deleteProduct(item.ProId)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
                                                    </td>
                                                </tr>
                                                <tr class="row-variation-@{{item.ProId}} row-variation">
                                                    <td colspan="8" class=" py-0 pb-4  px-0">
                                                        <ul class="ps-4 d-flex mb-0 border-start border-bottom" ng-repeat="variation in item.product_variations">
                                                            <li class="col-name d-flex h-100 align-content-center">
                                                                <img src="/storage/uploads/Product/@{{variation.DisplayImage}}" class="me-2 variation-image" alt="" width="30px">
                                                                <div>@{{variation.product_color.NameColor}} - @{{variation.product_size.NameSize}}</div>
                                                            </li>
                                                            <li class="col-procat"></li>
                                                            <li class="col-importPrice"></li>
                                                            <li class="col-price"></li>
                                                            <li class="col-status"></li>
                                                            <li class="col-quantity">@{{variation.Quantity}}</li>
                                                            <li class="col-ordered">@{{variation.Ordered}}</li>
                                                            <li style="width:8%"></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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