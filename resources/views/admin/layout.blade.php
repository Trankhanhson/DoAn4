<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>CANIFA</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="/assets/admin/img/logo.svg" rel="icon" />

    <!--fontawesome-->
    <link href="/assets/fonts/fonts/fontawesome-free-6.0.0-web/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="/assets/admin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="/assets/admin/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="/assets/admin/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="/assets/admin/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="/assets/admin/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <!-- Template Main CSS File -->
    <link href="/assets/admin/css/style.css" rel="stylesheet" />
    <!--custom-made-->
    <link href="/assets/admin/css/baseAdmin.css" rel="stylesheet" />
    @yield('styles')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <i class="fa-solid fa-gear me-2" style="font-size:30px;"></i>
                <span class="d-none d-lg-block">CANIFA</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                @guest
                <li class="nav-item dropdown pe-3">
                    <a href="{{ route('login') }}" class="nav-link nav-profile d-flex align-items-center pe-0">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-md-block ps-2">Đăng nhập</span>
                    </a><!-- End Profile Iamge Icon -->

                </li>
                @else
                    <li class="nav-item dropdown pe-3">
                        <a href="#" class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                            {{-- <span class="d-none d-md-block dropdown-toggle ps-2">@{ var user = Session["USER_SESSION"] as Project_3.common.UserLogin;} @user.Name</span> --}}
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>{{ auth()->User()->name }}</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="users-profile.html">
                                    <i class="bi bi-person"></i>
                                    <span>Profile của tôi</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Đăng xuất</span>
                                </a>
                            </li>

                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                @endguest <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->
    <!-- ======= Sidebar ======= -->
    @include('admin._SideBar')
    <!-- End Sidebar-->
    @yield('content')
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
    <a href="#"
       class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!--jquery file-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--ajax file -->
    <script src="/assets/framework/jquery.unobtrusive-ajax.min.js"></script>
    <!-- Vendor JS Files -->
    <script src="/assets/admin/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/admin/vendor/chart.js/chart.min.js"></script>
    <script src="/assets/admin/vendor/echarts/echarts.min.js"></script>
    <script src="/assets/admin/vendor/quill/quill.min.js"></script>
    <script src="/assets/admin/vendor/tinymce/tinymce.min.js"></script>
    <script src="/assets/admin/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/assets/admin/js/main.js"></script>

    <!--Convert price-->
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

        $(".price").each((index, value) => {
            
            let textPrice = $(value).text();
            if (textPrice.length != 0) {
                let tg = convertPrice(textPrice)
                $(value).text(tg)
            }
        })
    </script>
    <!--angular file-->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script>
        var csrfToken = "{{ csrf_token() }}";
      </script>
    @yield('scripts')
</body>
</html>
