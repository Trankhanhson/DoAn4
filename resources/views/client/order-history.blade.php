@extends('client.shared.layout_client');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/order-history.css">
@endsection
@section('scripts')
    
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
                Đơn hàng của tôi
            </div>
            <div class="account-sidebar">
                <div class="profile">
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">Trần khánh sơn</div> <button class="btn btn-email"><span
                                class="count"></span></button>
                    </div>
                    <div class="profile-cpoint">
                        <div class="profile-cpoint-item">
                            <div class="title">C-point</div>
                            <div class="value" style="color: rgb(218, 41, 28);">30</div>
                        </div>
                        <div class="profile-cpoint-line"></div>
                        <div class="profile-cpoint-item">
                            <div class="title">Điểm KHTT</div>
                            <div class="value" style="color: rgb(99, 177, 188);">0</div>
                        </div>
                        <div class="profile-cpoint-line"></div>
                        <div class="profile-cpoint-item">
                            <div class="title">Hạng thẻ</div>
                            <div class="label" style="background: rgb(116, 170, 80);">Green</div>
                        </div>
                    </div>
                    <div class="profile-usermenu">
                        <ul>
                            <li active="Tài khoản"
                                class=" active profile-usermenu-order"><a href="#">Đơn hàng của tôi</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-sale"><a href="#">Khuyến mại</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-cpoint"><a href="#">C-points</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-address"><a href="#">Sổ địa chỉ</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-khtt"><a href="#">Thẻ KHTT</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-wishlist"><a href="#">Yêu thích</a></li>
                            <li active="Tài khoản"
                                class=" profile-usermenu-account"><a href="#">Tài khoản</a></li>
                            <li active="Tài khoản"
                                class="profile-usermenu-logout"><a href="#">Đăng xuất</a></li>
                        </ul>
                    </div>
                    <div class="profile-support"><b>Bạn cần hỗ trợ?</b>
                        <p>Vui lòng gọi <a href="#">1800 6061</a> (miễn phí cước gọi)</p>
                    </div>
                </div>
            </div>
            <div class="account-column-main">
                <div>
                    <div>
                        <div class="account-page-title">
                            <h1 class="title">Đơn hàng của tôi</h1>
                        </div>
                        <div class="account-page-filter">
                            <ul>
                                <li class="active"><a href="#">Tất cả đơn hàng</a></li>
                            </ul>
                        </div>
                        <div class="order-list">
                            <table class="table-order-items">
                                <thead>
                                    <tr>
                                        <th class="col id">Đơn hàng</th>
                                        <th class="col date">Ngày mua</th>
                                        <th class="col qty">Số lượng</th>
                                        <th class="col total">Tổng tiền</th>
                                        <th class="col status">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col id"><a href="#">CNF1000041606</a></td>
                                        <td class="col date">14:58 26/10/2022</td>
                                        <td class="col qty">3</td>
                                        <td class="col total">811.200 ₫</td>
                                        <td class="col status">Đang chờ xét</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="toolbar order-products-toolbar">
                            <div class="pages">
                                <ul class="items pages-items">
                                    <li class="item pages-item-previous"><a title="Previous" class="action previous"><span
                                                class="label">Page</span></a></li>
                                    <li class="item current"><strong class="page"><span class="label">You're currently reading
                                                page</span> <span>1</span></strong></li>
                                    <li class="item pages-item-next" style="cursor:pointer"><a title="Next"
                                            class="action next"><span class="label">Page</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection