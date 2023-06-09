@extends('client.shared.layout_client');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/outlet.css">
    
@endsection
@section('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    $(".tab-price__link").click((e)=>{
        $(".tab-price__link").removeClass("active")
        $(e.target).addClass("active")
    })
</script>
<script src="/assets/client/js/OutletAngularjs.js"></script>
@endsection
@section('content')
<main ng-controller="OutletController">

    <div class="container-main">
        <!--Banner-->
        <section class="banner mt-4 pb-5">
            <img src="https://media.canifa.com/Simiconnector/banner_name_tablet1648794896.png" width="100%" alt="">
        </section>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-5 tab-outlet">
            <li class="nav-item" ng-click="changeObject('All')">
                <a class="nav-link active" data-bs-toggle="tab">TẤT CẢ</a>
            </li>
            <li class="nav-item" ng-click="changeObject('Nam')">
                <a class="nav-link" data-bs-toggle="tab">NAM</a>
            </li>
            <li class="nav-item" ng-click="changeObject('Nữ')">
                <a class="nav-link" data-bs-toggle="tab">NỮ</a>
            </li>
            <li class="nav-item" ng-click="changeObject('Bé trai')">
                <a class="nav-link" data-bs-toggle="tab">BÉ TRAI</a>
            </li>
            <li class="nav-item" ng-click="changeObject('Bé gái')">
                <a class="nav-link" data-bs-toggle="tab">BÉ GÁI</a>
            </li>
        </ul>

        <ul class="w-75 d-flex mx-auto mt-4 mb-5" style="background-color: #f6f6f6;">
            <li class="flex-grow-1 text-center" ng-click="changeMoney(99000,149000)"><a class="tab-price__link active">99k - 149k</a></li>
            <li class="flex-grow-1 text-center" ng-click="changeMoney(150000,199000)"><a class="tab-price__link">150k - 199k</a></li>
            <li class="flex-grow-1 text-center" ng-click="changeMoney(200000,249000)"><a class="tab-price__link">200k - 249k</a></li>
            <li class="flex-grow-1 text-center" ng-click="changeMoney(250000,10000000)"><a class="tab-price__link">Từ 250k</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="all">
                <div class="row gx-3 gy-5">
                    <div class="col-xl-3 col-md-4 col-6" ng-repeat="item in listOutlet">
                        <div class="product" data='{"ProId":"@{{item.ProId}}","ProName":"@{{item.ProName}}","Price":"@{{item.Price}}","DiscountPrice":"@{{item.DiscountPrice}}","Percent":@{{item.Percent}} }'>
                            <div>

                                <div ng-repeat="proImg in item.product_images" data-id="@{{proImg.ProColorID}}" class="wrap-image @{{$index == 0 ? 'active': ''}}">
                                    <div class="product-img">
                                        <a href="/client/product-detail/@{{item.ProId}}">
                                            <img src="/storage/uploads/Product/@{{proImg.Image}}" width="100%" alt="">
                                        </a>
                                        <div class="product-size-wrap">
                                            <div class="d-flex justify-content-center flex-wrap pt-3">
                                                <div ng-repeat="variation in item.product_variations">
                                                    <div ng-if="variation.product_color.ProColorID == proImg.ProColorID">
                                                        <div ng-if="(variation.Quantity - variation.Ordered) > 0" class="product-size" ng-click="addActive($event)" data-idSize="@{{variation.product_size.ProSizeID}}">@{{variation.product_size.NameSize}}</div>
                                                        <div ng-if="(variation.Quantity - variation.Ordered) <= 0" class="product-size disabled-size" data-idSize="@{{variation.product_size.ProSizeID}}">@{{variation.product_size.NameSize}}</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <a class="product-btn-addCart bg-dark text-white d-inline-block p-2" onclick="addCart(this)" style="font-weight:500;font-size: 12px;cursor:pointer">THÊM VÀO GIỎ HÀNG</a>
                                        </div>
                                        <span ng-if="item.Percent != 0" class="price-percent text-white">-@{{item.Percent}}%</span>
                                    </div>
                                    <div class="product-color-list d-flex pt-3 pb-2">
                                        <div ng-repeat="color in item.product_images" class="product-color @{{color.ProColorID == proImg.ProColorID ? 'active' : ''}}" onclick="changeProduct(event)" data-idColor="@{{color.ProColorID}}">
                                            <span style=" background-image: url('/storage/uploads/ProductColor/@{{color.product_color.ImageColor}}')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="/client/product-detail/@{{item.ProId}}" class="product-name">
                                @{{item.ProName}}
                            </a>
                            <div class="d-flex mt-1" ng-if="item.DiscountPrice != 0">
                                <div class="curent-price me-3">@{{item.DiscountPrice | number}}đ</div>
                                <div class="curent-old" data="">@{{item.Price | number}}đ</div>
                            </div>
                            <div class="d-flex mt-1" ng-if="item.DiscountPrice == 0">
                                <div class="curent-price me-3">@{{item.Price | number}}đ</div>
                            </div>
                        </div>
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
                <a class="header-link" href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
            </li>
            <li class="header-item">
                <a class="header-link " href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
            </li>
            <li class="header-item">
                <a class="header-link active" href="{{ route('client.outlet') }}">OUTLET</a>
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
            <a class="header-link " href="{{ route('client.index') }}">TRANG CHỦ</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.man') }}">NAM</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.women') }}">NỮ</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
        </li>
        <li class="header-item">
            <a class="header-link active" href="{{ route('client.outlet') }}">OUTLET</a>
        </li>
    </ul>
@endsection