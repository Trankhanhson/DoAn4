@extends('admin.layout')
@section('styles')
<link href="/assets/admin/css/Order.css" rel="stylesheet" />
@endsection
@section('scripts')
<script src="/assets/framework/dirPagination.js"></script>
<script src="/assets/admin/FileAngularjs/orderAngularj.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="OrderApp" ng-controller="OrderController" data-statusId="2">
    <h4 class="fw-bold">Danh sách đơn hàng đang vận chuyển</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" style="width:300px;" ng-model="searchText" ng-change="getPage(1)" placeholder="Tìm kiếm theo số điện thoại" />
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
                                    <th>Mã</th>
                                    <th>
                                        Số điện thoại
                                    </th>
                                    <th>
                                        Thời gian đặt
                                    </th>
                                    <th style="width:10%">
                                        Tùy chỉnh
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="category-wrap">
                                <tr dir-paginate="o in OrderList | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>@{{o.OrdID}}</td>
                                    <td>
                                        @{{o.ReceivingPhone}}
                                    </td>
                                    <td>
                                        @{{o.OrderDate | date:"dd/MM/yyyy 'lúc' h:mma"}}
                                    </td>
                                    <td>
                                        <a class=" btn-tool bg-primary" title="Chi tiết" ng-click="showDetail($index,o.OrdID)" data-bs-toggle="modal" data-bs-target="#SeeDtail"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn-delete btn-tool" title="Hủy" ng-click="cancel($index,o)"><i class="fa-solid fa-ban" style="pointer-events:none;"></i></a>

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
                                    Chi tiết đơn hàng <span>#ĐH@{{Order.OrdID}}</span>
                                </h1>
                            </div>
                            <div class="order-date"><span class="label">Ngày đặt hàng:</span> <span>@{{Order.OrderDate | date:"dd/MM/yyyy 'lúc' h:mma"}}</span></div> <span class="order-status" style="color: rgb(99, 177, 188);">@{{Order.status_order.Status}}</span>
                        </div>
                        <div class="order-details-view">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="box box-order-shipping-address">
                                        <strong class="box-title">
                                            Địa
                                            chỉ nhận hàng
                                        </strong>
                                        <div class="box-content">
                                            @{{Order.CustomerName}} <br>
                                            @{{Order.ReceivingPhone}} <br>
                                            @{{Order.ReceivingAddress}}, @{{Order.ReceivingWard}},
                                            @{{Order.ReceivingDistrict}},@{{Order.ReceivingCity}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="box box-order-billing-method">
                                        <strong class="box-title">
                                            Phương
                                            thức thanh toán
                                        </strong>
                                        <div class="box-content">
                                            <p>Thanh toán khi nhận hàng (@{{Order.PaymentType}})</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="box box-order-status">
                                        <strong class="box-title">
                                            Theo dõi đơn
                                            hàng
                                        </strong>
                                        <div class="box-content">
                                            <div class="status">
                                                <div class="icon">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.0888 12L11.9893 21.6385" stroke="#333F48" stroke-width="1.5" stroke-linecap="round"
                                                              stroke-linejoin="round"></path>
                                                        <path d="M20.6143 16.4372V7.56241C20.6143 7.4296 20.579 7.29917 20.5121 7.18445C20.4451 7.06973 20.3489 6.97485 20.2333 6.90949L12.3583 2.45841C12.2457 2.39477 12.1186 2.36133 11.9893 2.36133C11.8599 2.36133 11.7328 2.39477 11.6202 2.45841L3.74521 6.90949C3.62959 6.97485 3.53339 7.06973 3.46646 7.18445C3.39953 7.29917 3.36426 7.4296 3.36426 7.56241V16.4372C3.36426 16.57 3.39953 16.7005 3.46646 16.8152C3.53339 16.9299 3.62959 17.0248 3.74521 17.0901L11.6202 21.5412C11.7328 21.6049 11.8599 21.6383 11.9893 21.6383C12.1186 21.6383 12.2457 21.6049 12.3583 21.5412L20.2333 17.0901C20.3489 17.0248 20.4451 16.9299 20.5121 16.8152C20.579 16.7005 20.6143 16.57 20.6143 16.4372V16.4372Z"
                                                              stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M20.512 7.18463L12.0892 12.0008L3.46802 7.18359" stroke="#333F48" stroke-width="1.5"
                                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M16.5955 13.9227V9.42269L7.89746 4.5625" stroke="#333F48" stroke-width="1.5"
                                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                                <div class="detail">
                                                    <strong>@{{Order.Status}}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-dropdown">
                                            <div>
                                                <div class="status">
                                                    <!---->
                                                    <!---->
                                                    <div class="icon">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.0888 12L11.9893 21.6385" stroke="#333F48" stroke-width="1.5" stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                            <path d="M20.6143 16.4372V7.56241C20.6143 7.4296 20.579 7.29917 20.5121 7.18445C20.4451 7.06973 20.3489 6.97485 20.2333 6.90949L12.3583 2.45841C12.2457 2.39477 12.1186 2.36133 11.9893 2.36133C11.8599 2.36133 11.7328 2.39477 11.6202 2.45841L3.74521 6.90949C3.62959 6.97485 3.53339 7.06973 3.46646 7.18445C3.39953 7.29917 3.36426 7.4296 3.36426 7.56241V16.4372C3.36426 16.57 3.39953 16.7005 3.46646 16.8152C3.53339 16.9299 3.62959 17.0248 3.74521 17.0901L11.6202 21.5412C11.7328 21.6049 11.8599 21.6383 11.9893 21.6383C12.1186 21.6383 12.2457 21.6049 12.3583 21.5412L20.2333 17.0901C20.3489 17.0248 20.4451 16.9299 20.5121 16.8152C20.579 16.7005 20.6143 16.57 20.6143 16.4372V16.4372Z"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M20.512 7.18463L12.0892 12.0008L3.46802 7.18359" stroke="#333F48" stroke-width="1.5"
                                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.5955 13.9227V9.42269L7.89746 4.5625" stroke="#333F48" stroke-width="1.5"
                                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                    <!---->
                                                    <div class="detail">
                                                        <strong>Giao hàng thành công</strong>
                                                        <!---->
                                                        <!---->
                                                        <!---->
                                                        <p>Đang cập nhật...</p>
                                                    </div>
                                                </div>
                                                <div class="status pending active">
                                                    <!---->
                                                    <div class="icon">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M22.5 11.25H16.5V7.5H20.4922C20.6421 7.5 20.7886 7.54491 20.9127 7.62895C21.0368 7.71298 21.1329 7.83228 21.1886 7.97146L22.5 11.25Z"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M1.5 13.5H16.5" stroke="#333F48" stroke-width="1.5" stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                            <path d="M17.625 20.25C18.8676 20.25 19.875 19.2426 19.875 18C19.875 16.7574 18.8676 15.75 17.625 15.75C16.3824 15.75 15.375 16.7574 15.375 18C15.375 19.2426 16.3824 20.25 17.625 20.25Z"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M6.375 20.25C7.61764 20.25 8.625 19.2426 8.625 18C8.625 16.7574 7.61764 15.75 6.375 15.75C5.13236 15.75 4.125 16.7574 4.125 18C4.125 19.2426 5.13236 20.25 6.375 20.25Z"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.375 18H8.625" stroke="#333F48" stroke-width="1.5" stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                            <path d="M4.125 18H2.25C2.05109 18 1.86032 17.921 1.71967 17.7803C1.57902 17.6397 1.5 17.4489 1.5 17.25V6.75C1.5 6.55109 1.57902 6.36032 1.71967 6.21967C1.86032 6.07902 2.05109 6 2.25 6H16.5V16.0514"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.5 16.0514V11.25H22.5V17.25C22.5 17.4489 22.421 17.6397 22.2803 17.7803C22.1397 17.921 21.9489 18 21.75 18H19.875"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                    <div class="detail">
                                                        <strong>Đang vận chuyển</strong>
                                                        <p>Đơn hàng đã được giao cho Đơn vị vận chuyển</p>
                                                        <div class="date">
                                                            12:23 Thứ Sáu 11/11/2022
                                                        </div>
                                                        <div class="ship">
                                                            <a href="https://donhang.ghn.vn/?order_code=CNF1000044892" target="_blank">
                                                                tra cứu
                                                                vận chuyển
                                                            </a>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <div class="status active">
                                                    <div class="icon">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.125 13.4318V4.875C4.125 4.67609 4.20402 4.48532 4.34467 4.34467C4.48532 4.20402 4.67609 4.125 4.875 4.125H19.125C19.3239 4.125 19.5147 4.20402 19.6553 4.34467C19.796 4.48532 19.875 4.67609 19.875 4.875V19.125C19.875 19.3239 19.796 19.5147 19.6553 19.6553C19.5147 19.796 19.3239 19.875 19.125 19.875H12.7159"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12 14.25L6 20.25L3 17.25" stroke="#333F48" stroke-width="1.5" stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                    <div class="detail">
                                                        <strong>Xác nhận đơn hàng</strong>
                                                        <!---->
                                                        <div class="date">
                                                            09:37 Thứ Năm 10/11/2022
                                                        </div>
                                                        <!---->
                                                        <!---->
                                                    </div>
                                                </div>
                                                <div class="status active">
                                                    <div class="icon">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.125 13.4318V4.875C4.125 4.67609 4.20402 4.48532 4.34467 4.34467C4.48532 4.20402 4.67609 4.125 4.875 4.125H19.125C19.3239 4.125 19.5147 4.20402 19.6553 4.34467C19.796 4.48532 19.875 4.67609 19.875 4.875V19.125C19.875 19.3239 19.796 19.5147 19.6553 19.6553C19.5147 19.796 19.3239 19.875 19.125 19.875H12.7159"
                                                                  stroke="#333F48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12 14.25L6 20.25L3 17.25" stroke="#333F48" stroke-width="1.5" stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                    <div class="detail">
                                                        <strong>Đặt hàng thành công</strong>
                                                        <!---->
                                                        <div class="date">
                                                            09:37 Thứ Năm 10/11/2022
                                                        </div>
                                                        <!---->
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-details-items">
                            <table class="table-order-items">
                                <thead>
                                    <tr>
                                        <th class="col name">Sản phẩm</th>
                                        <th class="col qty">Số lượng</th>
                                        <th class="col">Giá gốc</th>
                                        <th class="col price-sale">Giá giảm</th>
                                        <th class="col total">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in Order.order_details">
                                        <td class="col name">
                                            <div class="order-product">
                                                <div class="order-product-photo">
                                                    <img src="/storage/uploads/Product/@{{item.product_variation.DisplayImage}}" alt="@{{item.NameProduct}}">
                                                </div>
                                                <div class="order-product-details">
                                                    <div class="order-product-name">
                                                        @{{item.product_variation.product.ProName}}
                                                    </div>
                                                    <div class="order-product-option">
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
                                            @{{item.Price | number}}₫
                                        </td>
                                        <td class="col price-sale">
                                            <span ng-if="item.DiscountPrice ==0">@{{item.Price | number}}₫</span>
                                            <span ng-if="item.DiscountPrice > 0">@{{item.DiscountPrice | number}}₫</span>

                                        </td>
                                        <td class="col total">
                                            <span ng-if="item.DiscountPrice == 0">@{{item.Price * item.Quantity | number}}₫</span>
                                            <span ng-if="item.DiscountPrice > 0">@{{item.DiscountPrice * item.Quantity | number}}₫</span>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="order-details-totals">
                            <table>
                                <tbody>
                                    <tr class="sub-totals">
                                        <th>Tổng giá bán</th>
                                        <td>@{{TotalOriginPrice | number}}₫</td>
                                    </tr>
                                    <tr>
                                        <th>Chiết khấu</th>
                                        <td>@{{TotalOriginPrice - Order.MoneyTotal | number}} ₫</td>
                                    </tr>
                                    <tr>
                                        <th>Vận chuyển</th>
                                        <td>25.000 ₫</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="grand-totals">
                                        <th style="color: rgb(51, 63, 72); font-weight: 600;">Tổng tiền thanh toán</th>
                                        <td style="font-weight: 600;">@{{Order.MoneyTotal + 25000 | number}}₫</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a ng-click="ChangeStatus(Order.OrdID)" title="Xác nhận giao hàng" class="btn text-white" style=" background: #4bac4d;"><i class="fa-solid fa-check"></i> Xác nhận giao hàng</a>
                    <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection