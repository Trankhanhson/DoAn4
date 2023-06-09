<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Admin</title>

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/Assets/Admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Assets/Admin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/Assets/Admin/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/Assets/Admin/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/Assets/Admin/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/Assets/Admin/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/Assets/Admin/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/Assets/Admin/css/style.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Đăng nhập tài khoản của bạn</h5>
                                </div>

                                <form  method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="col-12 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                            
                                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class = "form-control" />
                                            <div class="invalid-feedback">Nhập tên tài khoản</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="password" class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" id="password" required autocomplete="current-password" class = "form-control form-control-user"/>
                                        <div class="invalid-feedback">Nhập mật khẩu</div>
                                    </div>

                                    <div>
                                        <input type="checkbox" name="remember" id="remember">
                                        <label for="remember">Remember me</label>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

<script src="/Assets/Admin/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/Assets/Admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/Assets/Admin/vendor/chart.js/chart.min.js"></script>
<script src="/Assets/Admin/vendor/echarts/echarts.min.js"></script>
<script src="/Assets/Admin/vendor/quill/quill.min.js"></script>
<script src="/Assets/Admin/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/Assets/Admin/vendor/tinymce/tinymce.min.js"></script>
<script src="/Assets/Admin/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/Assets/Admin/js/main.js"></script>

</body>

</html>