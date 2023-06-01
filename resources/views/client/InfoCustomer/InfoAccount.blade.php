@extends('client.shared.layout_client');
@section('styles')
<link href="/assets/client/css/info-customer.css" rel="stylesheet" />
<link href="/assets/client/css/customner-account.css" rel="stylesheet" />
@endsection
@section('scripts')
<script src="/assets/client/js/UpdateInfoAccount.js"></script>
@endsection
@section('content')
<main>
    <div class="topbar text-center text-white">
        <div>Thêm vào giỏ 499.000 ₫ để miễn phí vận chuyển</div>
        <div>ĐỔI HÀNG MIỄN PHÍ - Tại tất cả cửa hàng trong 30 ngày</div>
    </div>
    <div class="site-main">
        <div class="account-container my-account">
            <div class="page-title-wrapper">
                Tài khoản
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
                                class=" active profile-usermenu-account"><a href="{{ route('client.infoCustomer') }}">Tài khoản</a></li>
                                <li active="Tài khoản"
                                class="  profile-usermenu-order"><a href="{{ route('client.orderHistory') }}">Đơn hàng của tôi</a></li>
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
                <div>
                    <div class="account-page-setting">
                        <div class="account-page-title">
                            <h1 class="title">Thông tin tài khoản</h1>
                        </div>
                        <form class="account-setting-form" data-idCustomer="{{ $customer->CusID}}">
                            <div class="form-group active">
                                <label>Họ tên</label>
                                <input type="text" value="{{ $customer->Name}}" name="name" id="name" class="form-control">
                                <label  class="error" for="name" style="display: none;"></label>
                            </div>
                            <div class="form-group active">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" id="phone" value="{{ $customer->Phone}}" class="form-control ">
                                <label id="phone-error" class="error" for="phone" style="display: none;"></label>
                            </div>
                            <div class="form-group active">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" id="address" value="{{ $customer->Address}}" class="form-control ">
                            </div>
                            <div class="actions">
                                <div class="btn" onclick="UpdateInfo()">
                                    Lưu
                                </div>
                                <!---->
                            </div>
                        </form>
                    </div>
                </div>
                <!---->
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