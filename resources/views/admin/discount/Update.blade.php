@extends('admin.layout')
@section('scripts')
    <script>
        /*hiển thị giá*/
        function convertPrice(price) {
            let tg = "";
            let length = price.length;
            let count = 0;
            for (var i = length - 1; i >= 0; --i) {
                if (count % 3 == 0 && count != 0) {
                    tg = price[i] + '.' + tg;
                }
                else {
                    tg = price[i] + tg;
                }
                count++;
            }
            return tg + "đ";
        }
    </script>
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/admin/FileAngularjs/Discount/EditDiscountAngular.js"></script>
@endsection
@section('styles')
    <link href="/assets/admin/css/DiscountProduct.css" rel="stylesheet" />
@endsection
@section('content')
<main id="main" class="main" data-Id="{{ $id }}" ng-app="discountApp" ng-controller="discountController" ng-init="checkProduct = true">
    <h4 class="fw-bold">Sửa danh chương trình khuyến mại</h4>
    <form name="discountForm" novalidate>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="d-flex mb-4">
                                    <label for="inputText" class="label-create col-form-label">Tên chương trình</label>
                                    <div class="flex-grow-1 position-relative">
                                        <input type="text" id="Name" name="Name" class="form-control text-dark" ng-model="discountPro.Name" required>
                                        <span ng-show="discountForm.$submitted">
                                            <span class="error" ng-show="discountForm.Name.$error.required">Bạn chưa nhập trường này</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex mb-4 col-6">
                                    <label for="inputText" class="label-create col-form-label">Thời gian bắt đầu</label>
                                    <div class="flex-grow-1 position-relative">
                                        <input type="datetime-local" id="StartDate" name="StartDate" ng-model="discountPro.StartDate" class="form-control text-dark" required>
                                        <span ng-show="discountForm.$submitted">
                                            <span class="error" ng-show="discountForm.StartDate.$error.required">Bạn chưa nhập trường này</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 col-6">
                                    <label for="inputText" class="label-create col-form-label">Thời gian kết thúc</label>
                                    <div class="flex-grow-1 position-relative">
                                        <input type="datetime-local" id="EndDate" name="EndDate" ng-model="discountPro.EndDate" class="form-control text-dark" required>
                                        <span ng-show="discountForm.$submitted">
                                            <span class="error" ng-show="discountForm.EndDate.$error.required">Bạn chưa nhập trường này</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-4">
                            <div class="text-end">
                                <a class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#ExtralargeModal"><i class="fa-solid fa-plus"></i> Thêm sản phẩm</a>
                                <button class="btn btn-primary me-2" type="submit" ng-click="submit()"><i class="fa-solid fa-check"></i> Hoàn tất</button>
                                <a href="/Admin/Discount/Index" class="btn-cancel btn bg-secondary text-white"><i class="fa-solid fa-backward"></i> Về danh sách</a>
                            </div>
                            <div ng-if="checkProduct">
                                <div class="border rounded-1 p-3 my-3">
                                    <p class="mb-3 fw-bold">Thiết lập hàng loạt</p>
                                    <div class="row setting-all align-items-center">
                                        <div class="d-flex col-4 me-5" style="height:38px;">
                                            <label for="inputText" class="col-form-label">Giá khuyến mãi</label>
                                            <div class="flex-grow-1 d-flex  position-relative">
                                                <input type="number" ng-change="ChangeDiscountPrice()" ng-model="generalSetting.Amount" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : 1" class="form-control text-dark" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                <select class="form-select" ng-change="ChangeDiscountPrice()" ng-model="generalSetting.TypeAmount" style="cursor:pointer;outline:none; width:100px;border-top-left-radius:0;border-bottom-left-radius:0;" id="TypeAmount">
                                                    <option value="0">đ</option>
                                                    <option value="1">%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex col-4">
                                            <label for="inputText" class="label-create col-form-label">Số sản phẩm mỗi khách hàng mua</label>
                                            <div class="flex-grow-1 position-relative d-flex align-items-center">
                                                <input type="number" ng-model="generalSetting.MaxQuantityPerUser" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : 1" class="form-control text-dark">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="btn btn-primary" ng-click="setAll()">Thiết lập</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-details-items">
                                    <table class="table-order-items table-product-selected rounded-2">
                                        <thead>
                                            <tr>
                                                <th class="col name">Sản phẩm</th>
                                                <th class="col originPrice">Giá gốc</th>
                                                <th class="col priceAfter">Giá sau giảm</th>
                                                <th class="col price-sale">Giảm giá</th>
                                                <th class="col maxOrder">Giới hạn đặt hàng</th>
                                                <th class="col">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr ng-repeat="item in listProConfirmed" class="product-@{{$index}}" data-proid="@{{item.ProId}}">
                                                <td class="col name">
                                                    <div class="order-product">
                                                        <div class="order-product-photo">
                                                            <img src="/storage/uploads/Product//@{{item.firstImage}}" alt="">
                                                        </div>
                                                        <div class="order-product-details">
                                                            <div class="order-product-name">
                                                                @{{item.ProName}}
                                                            </div>
                                                            <div class="order-product-name">
                                                                Mã: @{{item.ProId}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="col originPrice">@{{item.Price | number: 0}}đ</td>
                                                <td class="col priceAfter">
                                                    @{{item.priceAfter | number: 0}}đ
                                                </td>
                                                <td class="col price-sale">
                                                    <div class="flex-grow-1 d-flex">
                                                        <input type="number" class="amount-sale text-dark input-discount" ng-change="changePriceAfter(item)" ng-model="item.Amount" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : 1">
                                                        <select class="TypeAmount" ng-model="item.TypeAmount" ng-change="changePriceAfter(item)" style="outline: none; border: 1px solid #c6c6c6; border-radius: 2px; " name="TypeAmount">
                                                            <option value="0">đ</option>
                                                            <option value="1">%</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="col maxOrder"><input type="number" class="input-discount" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : 1" ng-model="item.MaxQuantityPerUser" /></td>
                                                <td class="col"><a class="btn-delete" ng-click="deleteProductSelect($index)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <div class="modal fade" id="ExtralargeModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chọn sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="search-form d-flex align-items-center position-relative">
                        <input type="search" name="query" class="search-product w-100" ng-model="searchText" ng-change="getPage(1)" placeholder="Nhập tên để tìm kiếm" title="Enter search keyword">
                        <button type="submit" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <div class="order-details-items mt-4">
                        <table class="table-order-items rounded-2">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th class="col" style="width: 60%;">Sản phẩm</th>
                                    <th class="col" style="width:15%">Giá</th>
                                    <th class="col" style="width:15%;">Kho</th>
                                </tr>
                            </thead>
                            <tbody ng-app>
                                <!-- ngRepeat: item in Order.OrderDetailDTOs -->
                                <tr dir-paginate="item in productList | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>
                                        <input type="checkbox" ng-model="item.Check" ng-click="selectProduct(item)" name="name" style="width:17px;height:17px;cursor:pointer" />
                                    </td>
                                    <td class="col">
                                        <div class="order-product">
                                            <div class="order-product-photo">
                                                <img src="/storage/uploads/Product//@{{item.firstImage}}" alt="">
                                            </div>
                                            <div class="order-product-details">
                                                <div class="order-product-name">
                                                    @{{item.ProName}}
                                                </div>
                                                <p>Mã: @{{item.ProId}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <th class="col">@{{item.Price | number: 0}}đ</th>
                                    <th class="col">@{{item.TotalQty}}</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination sortPagiBar ms-auto">
                            <dir-pagination-controls max-size="maxSize"
                                                     boundary-links="true"
                                                     direction-links="true"
                                                     on-page-change="getPage(newPageNumber)"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection