@extends('client.shared.layout_client');
@section('styles')
<link href="/assets/client/css/info-customer.css" rel="stylesheet" />
<link href="/assets/client/css/order-history.css" rel="stylesheet" />
<link href="/assets/admin/css/Order.css" rel="stylesheet" />
@endsection
@section('scripts')
<script>
    /**uppload file */
    var clickFile = document.createElement('div') //lưu thẻ bọc 1 ảnh khi click để truy xuất đến các phẩn tử con
    function fileBoxClick(input) {
        clickFile = input
    }

    //Hiển thị hình ảnh vừa chọn lên view
    function uploadImg(input) {
        const reader = new FileReader()

        // Lấy thông tin tập tin được đăng tải
        const file = input.files
        // Đọc thông tin tập tin đã được đăng tải
        reader.readAsDataURL(file[0])
        // Lắng nghe quá trình đọc tập tin hoàn thành
        reader.addEventListener("load", (event) => {
            // Lấy chuỗi Binary thông tin hình ảnh
            const img = event.target.result;
            // Thực hiện hành động thêm chuỗi giá trị này vào thẻ IMG
            $(clickFile).find('.file-upload-image').attr('src', img);
            $(clickFile).find('.file-upload-content').show();
            $(clickFile).find('.image-upload-wrap').hide();
        })
    }

    function dropImg(event) {
        event.preventDefault();
        event.stopPropagation();
        this.file = event.dataTransfer.files[0];
        event.target.files = event.dataTransfer.files
        const reader = new FileReader();
        reader.onload = e => {
            this.url = reader.result;

            const dropDiv = $(event.target).parents(".wrap-file-box")
            $(dropDiv).find('.file-upload-image').attr('src', this.url);
            $(dropDiv).find('.file-upload-content').show();
            $(dropDiv).find('.image-upload-wrap').hide();
        };
        reader.readAsDataURL(this.file);
    }

    function DragEnter(event) {
        event.stopPropagation();
        event.preventDefault();
        const parent = $(event.target).parents(".image-upload-wrap")
        $(parent).find(".text-dragenter").show()
        $(parent).find(".text-nodragenter").hide()
        $(parent).css("border", "2px dashed #0a58ca")
    }


    function dragLeaveBox(event) {
        event.stopPropagation();
        event.preventDefault();
        const parent = $(event.target).parents(".image-upload-wrap")
        $(parent).find(".text-dragenter").hide()
        $(parent).find(".text-nodragenter").show()
        $(parent).css("border", "2px dashed #999")

    }

    function removeImg(input) {
        let parentBox = $(input).parents(".wrap-file-box")
        let file = $(parentBox).find('.input-file')
        $(file).val('')
        let Image = $(parentBox).find('.file-upload-image')
        $(Image).attr("src", "")
        $(parentBox).find('.file-upload-content').hide();
        $(parentBox).find('.image-upload-wrap').show();
    }

    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
    
</script>
<script src="/assets/client/js/OrderHistory.js"></script>
@endsection
@section('content')
<main ng-controller="orderHistoryController" ng-init="clickDetail = false" data-id="{{ $customer->CusID}}">
    <div class="topbar text-center text-white">
        <div>Thêm vào giỏ 200.000 ₫ để miễn phí vận chuyển</div>
        <div>ĐỔI HÀNG MIỄN PHÍ - Tại tất cả cửa hàng trong 30 ngày</div>
    </div>
    <div class="site-main">
        <div class="account-container my-account">
            <div class="page-title-wrapper">
                Đơn hàng của tôi
            </div>
            <div class="account-sidebar">
                <div class="profile">
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">{{ $customer->Name}}</div> <button class="btn btn-email">
                            <span class="count"></span>
                        </button>
                    </div>
                    <div class="profile-cpoint">

                    </div>
                    <div class="profile-usermenu">
                        <ul>
                            <li active="Tài khoản"
                                class="  profile-usermenu-account"><a href="{{ route('client.infoCustomer') }}">Tài khoản</a></li>
                                <li active="Tài khoản"
                                class="  profile-usermenu-order active"><a href="{{ route('client.orderHistory') }}">Đơn hàng của tôi</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-logout"><a href="/client/logout">Đăng xuất</a></li>
                        </ul>
                    </div>
                    <div class="profile-support">
                        <b>Bạn cần hỗ trợ?</b>
                        <p>Vui lòng gọi <a href="#">1800 6061</a> (miễn phí cước gọi)</p>
                    </div>
                </div>
            </div>
            <div class="account-column-main">
                <div class="listOrder" ng-if="clickDetail == false">
                    <div class="account-page-title">
                        <h1 class="title">Đơn hàng của tôi</h1>
                    </div>
                    <div class="account-page-filter">
                        <ul>
                            <li class="filer-order-0 active" ng-click="getOrder(0)" style="cursor:pointer"><a>Tất cả đơn hàng</a></li>
                            <li class="filer-order-1" ng-click="getOrder(1)" style="cursor:pointer"><a>Chờ xử lý</a></li>
                            <li class="filer-order-2" ng-click="getOrder(2)" style="cursor:pointer"><a>Đang vận chuyển</a></li>
                            <li class="filer-order-3" ng-click="getOrder(3)" style="cursor:pointer"><a>Thành công</a></li>
                            <li class="filer-order-4" ng-click="getOrder(4)" style="cursor:pointer"><a>Đã hủy</a></li>
                        </ul>
                    </div>
                    <div class="order-list">
                        <table class="table-order-items">
                            <thead>
                                <tr>
                                    <th class="col id">Đơn hàng</th>
                                    <th class="col date">Ngày mua</th>
                                    <th class="col total">Tổng tiền</th>
                                    <th class="col status">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="o in OrderList | itemsPerPage: 8">
                                    <td class="col id" ng-click="showDetail(o.OrdID)"><a href="#">ĐH@{{o.OrdID}}</a></td>
                                    <td class="col date">@{{o.OrderDate | date:"dd/MM/yyyy 'lúc' h:mma"}}</td>
                                    <td class="col total">@{{o.MoneyTotal | number}}₫</td>
                                    <td class="col status">@{{o.StatusOrder.Status}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3"><dir-pagination-controls></dir-pagination-controls></div>
                </div>
                <div class="detail" ng-if="clickDetail">
                    <div>
                        <div data-v-771669b3="" ng-click="OrderBackClick()" class="order-back-page"></div>
                        <div class="order-detail-top">
                            <div class="account-page-title">
                                <h1 class="title">
                                    Chi tiết đơn hàng <span>#ĐH@{{Order.OrdID}}</span>
                                </h1>
                            </div>

                            <div class="order-date"><span class="label">Ngày đặt hàng:</span> <span>@{{Order.OrderDate | date:"dd/MM/yyyy 'lúc' h:mma"}}</span>
                            </div> <span class="order-status" style="color: rgb(99, 177, 188);">@{{Order.status_order.Status}}</span>
                            <button ng-click="CancelOrder(Order.OrdID)" ng-if="Order.StatusOrderId == 1" class="btn-sm btn-danger btn-cancelOrder">Hủy đơn hàng</button>
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
                                            @{{Order.ReceivingName}} <br>
                                            @{{Order.ReceivingPhone}} <br>
                                            @{{Order.ReceivingMail}} <br>
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
                                                            <a href="https://donhang.ghn.vn/?order_code=ĐH1000044892" target="_blank">
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
                                                    <a href="/client/product-detail/@{{ item.product_variation.product.ProId }}" class="order-product-name">
                                                        @{{item.product_variation.product.ProName}}
                                                    </a>
                                                    <div class="order-product-option">
                                                        <span>Màu: @{{item.product_variation.product_color.NameColor}}</span>
                                                    </div>
                                                    <div class="order-product-option">
                                                        <span>Kích cỡ :</span> <span>
                                                            @{{item.product_variation.product_size.NameSize}}
                                                        </span>
                                                    </div>
                                                    <button ng-if="Order.StatusOrderId == 3 && item.product_variation.feedback==null" ng-click="AddF(item.ProVariationID)" data-bs-toggle="modal" data-bs-target="#AddReview" class="btn btn-sm mt-2 btn-primary">Đánh giá sản phẩm</button>
                                                    <button ng-if="Order.StatusOrderId == 3 && item.product_variation.feedback.FeedbackId > 0" ng-click="EditF(item.product_variation.feedback.FeedbackId)" data-bs-toggle="modal" data-bs-target="#AddReview" class="btn btn-sm mt-2 btn-primary">Sửa đánh giá</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col qty text-start">@{{item.Quantity}}</td>
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
            </div>
        </div>
    </div>
    <div class="modal fade " id="AddReview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-2 border-0">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 pb-5 text-center">
                    <h3 class="fw-bold">Đánh giá của bạn</h3>
                    <div class="d-flex justify-content-center">
                        <div class="feedback">
                            <div class="rating">
                                <input type="radio" name="rating" ng-click="ChangeStar(5)" id="rating-5">
                                <label for="rating-5" class="rating-5"></label>
                                <input type="radio" name="rating" ng-click="ChangeStar(4)" id="rating-4">
                                <label for="rating-4" class="rating-4"></label>
                                <input type="radio" name="rating" ng-click="ChangeStar(3)" id="rating-3">
                                <label for="rating-3" class="rating-3"></label>
                                <input type="radio" name="rating" ng-click="ChangeStar(2)" id="rating-2">
                                <label for="rating-2" class="rating-2"></label>
                                <input type="radio" name="rating" ng-click="ChangeStar(1)" id="rating-1">
                                <label for="rating-1" class="rating-1"></label>
                                <input type="radio" name="rating" id="rating-0">
                                <label for="rating-0" class="d-none rating-0"> </label>
                                <div class="emoji-wrapper">
                                    <div class="emoji">
                                        <svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                            <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534" />
                                            <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff" />
                                            <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347" />
                                            <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63" />
                                            <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff" />
                                            <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347" />
                                            <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63" />
                                            <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347" />
                                        </svg>
                                        <svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                            <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                            <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347" />
                                            <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534" />
                                            <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff" />
                                            <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347" />
                                            <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff" />
                                            <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534" />
                                            <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff" />
                                            <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347" />
                                            <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff" />
                                        </svg>
                                        <svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                            <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                            <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347" />
                                            <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff" />
                                            <circle cx="340" cy="260.4" r="36.2" fill="#3e4347" />
                                            <g fill="#fff">
                                                <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10" />
                                                <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z" />
                                            </g>
                                            <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347" />
                                            <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff" />
                                        </svg>
                                        <svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                            <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347" />
                                            <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                            <g fill="#fff">
                                                <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z" />
                                                <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81" />
                                            </g>
                                            <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347" />
                                            <g fill="#fff">
                                                <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1" />
                                                <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81" />
                                            </g>
                                            <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347" />
                                            <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff" />
                                        </svg>
                                        <svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                            <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                            <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b" />
                                            <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f" />
                                            <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff" />
                                            <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b" />
                                            <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f" />
                                            <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff" />
                                            <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347" />
                                            <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b" />
                                        </svg>
                                        <svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <g fill="#ffd93b">
                                                <circle cx="256" cy="256" r="256" />
                                                <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z" />
                                            </g>
                                            <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4" />
                                            <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea" />
                                            <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88" />
                                            <g fill="#38c0dc">
                                                <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z" />
                                            </g>
                                            <g fill="#d23f77">
                                                <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z" />
                                            </g>
                                            <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347" />
                                            <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b" />
                                            <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="wrap-file-box mx-auto" onclick="fileBoxClick(this)">
                                <div class="image-upload-wrap">
                                    <input class="input-file__main input-file" type="file" accept="image/*" onchange="angular.element(this).scope().setFile(this)" ondrop="dropImg(event)" ondragleave="dragLeaveBox(event)" ondragenter="DragEnter(event)">
                                    <div class="drag-text">
                                        <p class="text-dragenter text-secondary" style="font-size:12px"><i class="fa-solid fa-plus"></i> Thêm ảnh</p>
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <img class="file-upload-image rounded-2" src="#" alt="your image">
                                    <div class="image-title-wrap" ng-click="removeImg()">
                                        <button type="button" class="remove-image" onclick="removeImg(this)">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="form-floating mb-3">
                                <textarea maxlength="300" class="form-control" ng-model="Feedback.Content" placeholder="Nhập bình luận của bạn..." style="height: 100px;"></textarea>
                                <label for="floatingTextarea">Bình luận của bạn</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button ng-if="Feedback.FeedbackId == null" class="btn btn-dark w-50 mt-3 mx-auto" ng-click="AddFeedback()">Viết đánh giá</button>
                        <button ng-if="Feedback.FeedbackId != 0 && Feedback.FeedbackId != null" class="btn btn-dark w-50 mt-3 mx-auto" ng-click="EditFeedback()">Sửa đánh giá</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('sidebar')
<div class="offcanvas offcanvas-start" id="sidebar">
    <div class="offcanvas-header pt-4">
        <a class="offcanvas-title header-brand" href="{{ route('client.index') }}">
            <img src="/Assets/img/logo.svg" alt="" />
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="mb-3">
            <li class="header-item">
                <a class="header-link" href="{{ route('client.index') }}">TRANG CHỦ</a>
            </li>
            <li class="header-item">
                <a class="header-link " href="{{ route('client.man') }}">NAM</a>
            </li>
            <li class="header-item">
                <a class="header-link " href="{{ route('client.women') }}">NỮ</a>
            </li>
            <li class="header-item">
                <a class="header-link " href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
            </li>
            <li class="header-item">
                <a class="header-link " href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
            </li>
            <li class="header-item">
                <a class="header-link" href="{{ route('client.outlet') }}">OUTLET</a>
            </li>
        </ul>
        <div class="sidebar-form-wrap ">
            <form class="d-flex sidebar-form">
                <button class="search-btn">
                    <span></span>
                </button>
                <input type="text"
                       placeholder="Bạn tìm gì"
                       id="input-sidebar-search"
                       autocomplete="off" />
            </form>
            <div class="search-history">
                <div class="d-flex justify-content-between search-history__header">
                    <p>Lịch sử tìm kiếm</p>
                    <span style="cursor: pointer;">Xóa</span>
                </div>
                <div class="search-history-body pt-2">
                    <span>áo polo</span>
                </div>
            </div>

        </div>

    </div>
</div>
    <!-- Button to open the offcanvas sidebar -->
    <button class="btn-menu d-xl-none d-block" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
        <i class="fa-solid fa-bars"></i>
    </button>
    <ul class="header-list d-none d-xl-flex me-auto ms-5">
        <li class="header-item">
            <a class="header-link" href="{{ route('client.index') }}">TRANG CHỦ</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.man') }}">NAM</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.women') }}">NỮ</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.outlet') }}">OUTLET</a>
        </li>
    </ul>
@endsection