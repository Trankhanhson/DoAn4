@extends('admin.layout')
@section('styles')
<link href="/assets/admin/css/ImportBill.css" rel="stylesheet" />
<style>
    .btn-delete__import, .btn-delete__detail {
        color: #808080;
        cursor: pointer;
    }

    .row-product.active {
        background-color: #d6e4ff;
    }

</style>
@endsection
@section('scripts')
    <script>
        function showVariation(input) {
            let proId = $(input).attr("data-proId")
            $(`.row-variation-${proId}`).toggle()
        }
        function showImportDetail(input) {
            let proId = $(input).attr("data-proId")
            $(input).toggleClass("active")
            $(`.row-importDetail-${proId}`).toggle()
        }

        function addActive(input) {
            $(input).toggleClass("active")
        }

        function stopPropagation(event) {
            event.stopPropagation()
        }

    </script>
    <script src="/assets/admin/FileAngularjs/ImportBill/CreateImportBill.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="importBillApp" ng-controller="importBillController">
    <h4 class="fw-bold">Thêm hóa đơn nhập</h4>
    <section class="section">

        <div class="card-body px-0 pt-4">
            <div class="row">
                <div class="col-7">
                    <div class="bg-white shadow p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-3">
                                <select class="form-select" aria-label="Default select example" id="StaffId">
                                    @foreach ($listUser as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                Tổng tiền: <span id="totalImportBill">@{{totalBill | number}}đ</span>
                            </div>

                            <div>
                                <button class="btn btn-primary me-2" ng-click="saveClick()">Tạo</button>
                                <a href="{{ route('admin.ImportBill') }}" class="btn-cancel btn bg-secondary text-white"><i class="fa-solid fa-backward"></i> Về danh sách</a>
                            </div>
                        </div>
                        <div>
                            <table class="mt-3 cart-list w-100 table table-importBill">
                                <thead style="background-color: #333f48; color:white;">
                                    <tr>
                                        <th class="col col-name">Sản phẩm</th>
                                        <th class="col col-quantity">Số lượng</th>
                                        <th class="col col-importPrice ">Giá nhập</th>
                                        <th class="col col-price ">Giá bán</th>
                                        <th class="col col-subtotal ">Thành tiền</th>
                                        <th class="col col-action"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="row-product" onclick="showImportDetail(this)" data-proId="@{{pd.ProId}}" ng-repeat-start="pd in productImport">
                                        <td class="col-name">@{{pd.ProName}}</td>
                                        <td class="col-quantity">
                                        </td>
                                        <td class="col-importPrice">
                                            <input type="number" class="input-price" min="0" ng-change="countTotalBill()" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0" onclick="stopPropagation(event)" ng-model="pd.ImportPrice" value="@{{pd.ImportPrice}}">
                                        </td>
                                        <td class="col-price">
                                            <input type="number" class="input-price" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0" onclick="stopPropagation(event)" ng-model="pd.Price" value="@{{pd.Price}}">
                                        </td>
                                        <td class="col-subtotal price"></td>
                                        <td class="col-action">
                                            <a class="btn-delete__import" ng-click="DeleteProImport($index)"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a>
                                        </td>
                                    </tr>
                                    <tr class="row-importDetail-@{{pd.ProId}} row-importDetail" ng-repeat-end>
                                        <td colspan="10" class=" pb-4" style="padding: 0;">
                                            <ul class=" d-flex mb-0 importDetail-item" data-idVariation="@{{pv.ProVariationID}}" ng-repeat="pv in pd.listVariation">
                                                <li class="col-name  ps-4">
                                                    <div class="d-flex py-1 ps-3 align-items-start border-bottom border-start h-100">
                                                        <img src="/storage/uploads/Product/@{{pv.DisplayImage}}" class="me-2" alt="" width="30px">
                                                        <div class="d-flex align-items-center">
                                                            <span class="item-size">@{{pv.NameSize}}</span>
                                                            <span>&nbsp;/&nbsp;</span>
                                                            <span>@{{pv.NameColor}}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-quantity p-2 d-flex align-items-center border-bottom">
                                                    <input type="number" class="input-quantity" ng-model="pv.Quantity" ng-change="countTotalBill()" value="@{{pv.Quantity}}" oninput="this.value = !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : 1">
                                                </li>
                                                <li class="col-importPrice p-2 border-bottom"></li>
                                                <li class="col-price p-2 border-bottom"></li>
                                                <li class="col-subtotal p-2 border-bottom">@{{pd.ImportPrice * pv.Quantity | number}}đ</li>
                                                <li class="border-bottom col-action p-2" ng-click="DeleteDetail($parent.$index,$index)"><a class="btn-delete__detail"><i class="fa-solid fa-trash" style="pointer-events:none;"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="search-bar dropdown">
                        <div class="bg-white shadow p-2">
                            <form class="search-form d-flex align-items-center position-relative">
                                <input type="search" name="query" class="search-product w-100" ng-model="searchText" ng-change="getPage(1)" placeholder="Nhập tên hoặc đối tượng để tìm kiếm" title="Enter search keyword" />
                                <button type="submit" title="Search">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                            <div class="wrap-product-search mt-3">
                                <table class=" cart-list w-100 table">
                                    <thead style="background-color: #333f48; color:white;">
                                        <tr>
                                            <th class="col col-name">Sản phẩm</th>
                                            <th class="col col-importPrice ">Giá nhập</th>
                                            <th class="col col-price">Giá bán</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="row-product row-product-@{{p.ProId}}" style="cursor:pointer" ng-repeat-start="p in products" data-proId="@{{p.ProId}}" onclick="showVariation(this)">
                                            <td class="col-product-name">@{{p.ProName}}</td>
                                            <td data-importPrice="@{{p.ImportPrice}}" class="col-product-importPrice">
                                                @{{p.ImportPrice | number}}đ
                                            </td>
                                            <td data-price="@{{p.Price}}" class="col-product-price">
                                                @{{p.Price | number}}đ
                                            </td>
                                        </tr>
                                        <tr class="row-variation-@{{p.ProId}} row-variation" ng-repeat-end>
                                            <td colspan="10" class=" pb-4" style="padding: 0;">
                                                <div class=" d-flex mb-0 variation-item" ng-repeat="v in p.product_variations" onclick="addActive(this)" data-idVariation="@{{v.ProVariationID}}">
                                                    <div class="col-product-name ps-4 bg-white">
                                                        <div class="d-flex py-1 ps-3 align-items-start border-bottom border-start col-product-name__inner">
                                                            <img src="/storage/uploads/Product/@{{v.DisplayImage}}" class="me-2 variation-image" alt="" width="30px">
                                                            <div class="d-flex align-items-center">
                                                                <span class="sizeValue">@{{v.product_size.NameSize}}</span>
                                                                <span>&nbsp;/&nbsp;</span>
                                                                <span class="colorValue">@{{v.product_color.NameColor}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-product-importPrice p-2 border-bottom"></div>
                                                    <div class="col-product-price p-2 border-bottom"></div>
                                                </div>
                                                <div class="text-end">
                                                    <div class=" btn btn-primary btn-sm mt-3 me-3" ng-click="selectProduct(p)">Chọn</div>
                                                </div>
                                            </td>
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

</main>
@endsection