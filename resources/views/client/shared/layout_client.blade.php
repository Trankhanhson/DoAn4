<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Canifa</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="/assets/client/fonts/fonts/fontawesome-free-6.0.0-web/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/client/css/main.css" />
    <link rel="stylesheet" href="/assets/client/css/BaseClient.css" />
    <link rel="stylesheet" href="/assets/client/css/resposiveIndex.css">
    @yield('styles')
</head>

<body ng-app="ClientApp">
    <!--Header-->
    <header class="container-main">
        <div class="header-menu flex-grow-1 d-flex align-items-center h-100">
            <a class="header-brand me-auto me-xl-0 ms-xl-0 ms-sm-5" href="{{ route('client.index') }}">
                <img src="/assets/client/img/logo.svg" alt="" />
            </a>
                <!-- Offcanvas Sidebar -->
    @yield('sidebar')

            <div class="header-form-wrap d-none d-xl-block" ng-controller="searchProController">
                <form class="d-flex sidebar-form">
                    <button class="search-btn">
                        <span></span>
                    </button>
                    <input type="search"
                           placeholder="Bạn tìm gì"
                           id="input-search"
                           autocomplete="off" ng-model="searchText" ng-change="getData()" />
                </form>
                <div class="search-history">
                    <div class="spotlight-search is-active">
                        <div rel-script="spotlight-search" class="spotlight-search__wrapper is-active">
                            <a ng-repeat="p in productResult" class="product-search p-2" href="http://localhost:8000/client/product-detail/@{{ p.ProId }}">
                                <div class="box-img-search">
                                    <img src="/storage/uploads/Product/@{{p.firstImage}}" alt="">
                                </div>
                                <div class="product-search__content">
                                    <h4 class="product-search__title">
                                        @{{p.ProName}}
                                    </h4>
                                    <div class="product-search__prices">
                                        <ins>@{{p.Price | number}}đ</ins>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div rel-script="spotlight-search" ng-if="emptyProduct" class="spotlight-search__wrapper is-active">
                            <p class="text-center text-secondary">Không có sản phẩm nào</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="header-group-icon d-flex justify-content-between me-xl-0 me-sm-5">
            <div>
                @if (!request()->hasCookie('CustomerId'))
                <button data-bs-toggle="modal" href="#ModalLogin" style="background-color:transparent" class="header-icon header-login"></button>
            @else
                <a href="{{ route('client.infoCustomer') }}" class="header-icon header-login"></a>
            @endif

            </div>
            <div class="header-cart-wrap">
                <div class="header-icon header-cart" type="button" id="miniCart" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="header-cart__quantity">3</span>
                </div>

                <div class="header-cart__inner block-minicart dropdown-menu rounded-0 border-0" aria-labelledby="dropdownMenuButton1">
                    <div class="empty-minicart__inner">
                        <img src="/assets/client/img/cart-empty.svg" alt="">
                        <p class="px-5 pt-3 text-center">chưa có sản phẩm trong giỏ hàng của bạn.</p>
                        <button class="btn-close cart-close"></button>
                    </div>
                    <div class="haveItem-Minicart">
                        <div class="block-minicart-heading w-100 fs-6">
                            (<span></span>) sản phẩm trong giỏ hàng
                        </div>
                        <ol class="minicart-items w-100">
                            <li class="minicart-item">
                                <div class="minicart-item-info">
                                    <div class="minicart-item-photo">
                                        <div class="minicart-item-photo">
                                            <a href="/vay-lien-be-gai-1ds22w012" class="router-link-exact-active router-link-active">
                                                <img src="https://canifa.com/img/210/300/resize/1/d/1ds22w012-sp247-2-thumb.webp" alt="">
                                            </a>
                                            <div class="minicart-item-label">
                                                -10%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="minicart-item-details">
                                        <h3 class="minicart-item-name">
                                            <a href="/vay-lien-be-gai-1ds22w012" class="router-link-exact-active router-link-active">Váy liền bé gái có hình in</a>
                                        </h3>
                                        <div class="minicart-item-options">
                                            <div class="minicart-item-option"><span class="value">140</span></div>
                                            <div class="minicart-item-option">
                                                <span class="swatch-option" style="background-image: url(&quot;https://media.canifa.com/attribute/swatch/images/sp247.png&quot;);"></span>
                                            </div>
                                        </div>
                                        <div class="minicart-item-action"><a class="minicart-item-remove" onclick="deleteMiniCart()"></a></div>
                                        <div class="minicart-item-bottom">
                                            <div class="minicart-item-price"><span class="price">224000</span></div>
                                            <div>x1</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ol>
                        <!---->
                        <!---->
                        <!---->
                        <div class="minicart-actions w-100">
                            <a href="{{ route('client.cart') }}" class="action checkout text-center">
                                Xem giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--Body-->
    @yield('content')

    <!--Site footer-->
    <footer class="footer-site">
        <div class="container-main pb-5">
            <div class="row">
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="footer-column">
                        <h5>CÔNG TY CỔ PHẦN CANIFA</h5>
                        <ul class="footer-list">
                            <li>Số ĐKKD: 0107574310, ngày cấp: 23/09/2016, nơi cấp: Sở Kế hoạch và đầu tư Hà Nội</li>
                            <li>Trụ sở chính: Số 688, Đường Quang Trung, Phường La Khê, Quận Hà Đông, Hà Nội, Việt Nam</li>
                            <li>Địa chỉ liên hệ: Phòng 301 Tòa nhà GP Invest, 170 La Thành, P. Ô Chợ Dừa, Q. Đống Đa, Hà Nội</li>
                            <li>Số điện thoại: +8424 - 7303.0222</li>
                            <li>Fax: +8424 - 6277.6419</li>
                            <li>Địa chỉ email: hello@canifa.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-3 d-flex justify-content-center">
                    <div class="footer-column d-inline-block">
                        <h5>THƯƠNG HIỆU</h5>
                        <ul class="footer-list">
                            <li><a href="#">Giới thiệu</a></li>
                            <li><a href="#">Tin tức</a></li>
                            <li><a href="#">Tuyển dụng</a></li>
                            <li><a href="#">Với cộng đồng</a></li>
                            <li><a href="#">Hệ thống cửa hàng</a></li>
                            <li><a href="#">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-3  d-flex justify-content-start justify-content-md-center">
                    <div class="footer-column d-inline-block ">
                        <h5>HỖ TRỢ</h5>
                        <ul class="footer-list">
                            <li><a href="#">Hỏi đáp</a></li>
                            <li><a href="#">Chính sách KHTT</a></li>
                            <li><a href="#">Chính sách vận chuyển</a></li>
                            <li><a href="#">Hướng dẫn chọn size</a></li>
                            <li><a href="#">Kiểm tra đơn hàng</a></li>
                            <li><a href="#">Quy định đổi hàng</a></li>
                            <li><a href="#">Tra cứu điểm thẻ</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="footer-column ">
                        <h5>TẢI ỨNG DỤNG TRÊN ĐIỆN THOẠI</h5>
                        <div class="download-app mb-5">
                            <a href="" class="me-1">
                                <img src="https://canifa.com/assets/images/bancode.png" alt="">
                            </a>
                            <a href="" class="me-1">
                                <img src="https://canifa.com/assets/images/googleplay.png" alt="">
                            </a>
                            <a href="" class="me-1">
                                <img src="https://canifa.com/assets/images/appstore.png" alt="">
                            </a>
                        </div>
                        <h5>PHƯƠNG THỨC THANH TOÁN</h5>
                        <div>
                            <img class="mb-3" src="	https://canifa.com/assets/images/pay.svg" alt="">
                            <img src="https://canifa.com/assets/images/bocongthuong.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-bottom:1px solid #d0d2d3;margin: 0;">
        <div class="text-center py-4">Design by Trần Khánh Sơn</div>
    </footer>

    <!--modal login-->
    <div class="modal fade" id="ModalLogin" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="position-relative d-flex ">
                    <div class="btn-login active">Đăng nhập</div>
                    <div class="btn-register" data-bs-toggle="modal" href="#ModalRigister" role="button">Khách hàng mới</div>

                    <button type="button" class="btn-close btn-close-modal position-absolute top-0 start-100 translate-middle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formLogin">
                    <div class="modal-body">
                        <p class="modal-title fs-6">Cảm ơn bạn đã trở lại.</p>
                        <input type="text" id="userName" name="userName" class="input-loginAndRegis NameAccount mt-4" placeholder="Số điện thoại của bạn">
                        <label id="userName-error" class="error" for="userName" style="display: none;"></label>
                        <input type="password" id="passwordLogin" name="passwordLogin" class="input-loginAndRegis PassWord mt-3" placeholder="Mật khẩu">
                        <label id="passwordLogin-error" class="error" for="passwordLogin" style="display: none;"></label>
                    </div>
                    <div class="modal-footer">
                        <div onclick="Login()" class="submit-regisLogin submit-modal fw-bold text-white py-3 text-center w-100" style="background-color: #333f48;">
                            Tiếp tục
                        </div>
                        <a data-bs-toggle="modal" class="mt-3" href="#ModalGetPassword" role="button">Quên mật khẩu</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--modal forget pass-->
    <div class="modal fade" id="ModalGetPassword" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="position-relative d-flex ">
                    <div class="pt-4 text-center w-100">
                        <h3>Lấy lại mật khẩu</h3>
                        <p>Vui lòng nhập số điện thoại của bạn để xác nhận</p>
                    </div>
                    <button type="button" class="btn-close btn-close-modal position-absolute top-0 start-100 translate-middle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <input type="text" id="PhoneConfirm" name="PhoneConfirm" class="input-loginAndRegis NameAccount mt-4" placeholder="Số điện thoại của bạn">
                        <label id="PhoneConfirm-error" class="error" for="PhoneConfirm" style="display: none;"></label>
                    </div>
                    <div class="modal-footer">
                        <div onclick="confirmPhone()" class="submit-regisLogin submit-modal fw-bold text-white py-3 text-center w-100" style="background-color: #333f48;">
                            Tiếp tục
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade block-login" id="ConfirmOtp" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div data-v-07844138="" class="block-content p-3">
                    <h4>Xác thực số điện thoại</h4>
                    <div class="note">
                        Mã OTP vừa được gửi đến số điện thoại
                        <span class="toPhone text-dark"></span>
                        <div class="my-4 text-center">
                            <input id="partitioned" class="border border-secondary p-2" placeholder="Nhập mã OTP" type="text" maxlength="6" />
                        </div>
                    </div>

                    <div class="actions">
                        <div class="submit-regisLogin submit-modal fw-bold text-white py-3 text-center w-100" style="background-color: #333f48;" onclick="codeverity()">Xác thực</div>
                        <div class="d-none" id="Confirm"></div>
                    </div>
                    <div class="actions-secondary mt-4" onclick="Resend()"><a>Gửi lại Mã</a></div>
                </div>
            </div>
        </div>
    </div>

    <!--resigter-->
    <div class="modal fade" id="ModalRigister" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="position-relative d-flex ">
                    <div class="btn-login" data-bs-toggle="modal" href="#ModalLogin" role="button">Đăng nhập</div>
                    <div class="btn-register active">Khách hàng mới</div>
                    <button type="button" class="btn-close btn-close-modal position-absolute top-0 start-100 translate-middle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formRegister">
                    <div class="modal-body">
                        <p class="modal-title fs-6">Đăng ký để Canifa có cơ hội phục vụ bạn tốt hơn.</p>
                        <input type="text" name="Name" id="Name" class="input-loginAndRegis mt-3" placeholder="Tên của bạn">
                        <input type="text" name="Address" id="Address" class="input-loginAndRegis mt-3" placeholder="Địa chỉ">
                        <input type="text" name="Phone" id="Phone" class="input-loginAndRegis mt-3" placeholder="SĐT của bạn">
                        <label id="Phone-error" class="error" for="Phone" style="display: none;"></label>
                        <input type="password" autocomplete="new-password" name="Password" id="Password" class="input-loginAndRegis mt-3" placeholder="Mật khẩu">
                        <input type="password" autocomplete="new-password" name="ConfirmPassword" id="ConfirmPassword" class="input-loginAndRegis mt-3" placeholder="Nhập lại mật khẩu">
                    </div>
                    <div class="modal-footer">
                        <div class="submit-regisLogin submit-modal fw-bold text-white py-3 text-center w-100" onclick="RegisterSubmit()" style="background-color: #333f48;">
                            Tiếp tục
                        </div>
                        <p class="fw-normal my-4">Bằng việc chọn tiếp tục, bạn đã đồng ý với <a class="fw-normal" href="#" style="color: #63b1bc;"> Điều khoản & Điều kiện</a> cùng <a href="#" class="fw-normal" style="color: #63b1bc;"> Chính sách bảo mật và chia sẻ thông tin</a> của CANIFA</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--toast when like-->
    <div class="toast toast-like position-fixed rounded-0" style="top:30px; right:20px;z-index: 101;" data-bs-animation="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header py-3 border-none">
            <img src="/assets/client/img/cart-like.svg" alt="">
            <p class="px-3 fw-normal" style="font-size: 17px;">Sản phẩm đã được thêm vào danh sách yêu thích!</p>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <div class="toast toast-successClient position-fixed rounded-0" style="top:30px; right:20px;z-index: 101;" data-bs-animation="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header py-3 border-none">
            <img src="/assets/client/img/cart-like.svg" style="width:30px;height:30px" alt="">
            <p class="px-3 fw-normal flex-grow-1" style="font-size: 17px;"></p>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <div class="toast toast-errorClient position-fixed rounded-0" style="top:30px; right:20px;z-index: 101;" data-bs-animation="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header py-3 border-none">
            <img src="/assets/client/img/errorClient.svg" style="width:30px;height:30px" alt="">
            <p class="px-3 fw-normal flex-grow-1" style="font-size: 17px;"></p>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <!--alert-->
    <div class="position-fixed " style="z-index: 100000;top:60px; right: 10px;">
        <div id="successToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" style=" color: #0f5132; border-color: #badbcc; background: #d1e7dd;">
            <div class="toast-body text-dark d-flex justify-content-between align-items-center">
                <p class="m-0 text-toast"> <i class="bi bi-check-circle me-1"></i>Thành công</p>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="position-fixed " style="z-index: 100000;top:60px; right: 10px;">
        <div id="errorToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" style="color: #842029; border-color: #f5c2c7; background: #f8d7da; ">
            <div class="toast-body text-dark d-flex justify-content-between align-items-center">
                <p class="m-0 text-toast"><i class="bi bi-exclamation-octagon me-1"></i> Thất bại</p>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        var csrfToken = "{{ csrf_token() }}";
</script>
    <!--script-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/framework/jquery.unobtrusive-ajax.min.js"></script>
    <script src="/assets/framework/jquery.validate.min.js"></script>
    <script src="/assets/client/js/BaseClient.js"></script>
    <script src="/assets/client/js/Cart/addCart.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script src="/assets/client/js/LoginAndRegister.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/framework/ng-file-upload-shim.min.js"></script>
    <script src="/assets/framework/ng-file-upload.min.js"></script>
    <script>
        var ClientApp = angular.module("ClientApp", ['ngFileUpload', 'angularUtils.directives.dirPagination']);
    </script>
    <script>

        ClientApp.controller("searchProController", searchProController);

        function searchProController($scope, $http) {
            $scope.searchText = ""
            $scope.emptyProduct = true;
            $scope.getData = function () {

                /** Lấy danh sách loại sản phẩm*/
                $http.get("/admin/product/getSearchDataClient", {
                    params: { searchText: $scope.searchText }
                }).then(function (res) {
                    if (res.data.check) {
                        $scope.productResult = JSON.parse(res.data.result)
                    }
                    else {
                        $scope.productResult = []
                    }

                    if ($scope.productResult.length == 0) {
                        $scope.emptyProduct = true
                    } else {
                        $scope.emptyProduct = false
                    }
                })
            }
        }
    </script>

    @yield('scripts')
</body>
</html>