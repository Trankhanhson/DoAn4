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

<body>
    <!--Header-->
    <header class="container-main" style="padding:0 80px">
        <div class="header-menu flex-grow-1 d-flex align-items-center h-100">
            <a class="header-brand me-auto me-xl-0 ms-xl-0 ms-sm-5" href="{{ route('client.index') }}">
                <img src="/assets/client/img/logo.svg" alt="" />
            </a>
            <div class="payBill" style="font-size:15px;font-weight:700;margin-left:20px">THANH TOÁN ĐƠN HÀNG</div>
        </div>
        <div>
            <a class="continueShoping" style="font-size:15px;font-weight:700;text-decoration:underline; color:#000;" href="{{ route('client.index') }}">TIẾP TỤC MUA SẮM</a>
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



    <!--toast when like-->
    <div class="toast toast-like position-fixed rounded-0" style="top:30px; right:20px;z-index: 101;" data-bs-animation="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header py-3 border-none">
            <img src="/assets/client/img/cart-like.svg" alt="">
            <p class="px-3 fw-normal" style="font-size: 17px;">Sản phẩm đã được thêm vào danh sách yêu thích!</p>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <!--alert-->
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
    <script>
        var csrfToken = "{{ csrf_token() }}";
</script>
    <!--script-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/framework/jquery.unobtrusive-ajax.min.js"></script>
    <script src="/assets/framework/jquery.validate.min.js"></script>
    <script src="/assets/client/js/BaseClient.js"></script>
    @yield('scripts')
</body>
</html>