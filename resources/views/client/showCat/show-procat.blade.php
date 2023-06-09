@extends('client.shared.layout_client');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/subIndex.css">
<link href="/assets/client/css/show-category.css" rel="stylesheet" />
@endsection
@section('scripts')
<script type="text/javascript" src="/assets/client/js/subIndex.js"></script>
<script src="/assets/client/js/show-category.js"></script>
<script>
    ClientApp.controller("ShowProCatController", ShowProCatController)
    function ShowProCatController($scope, $http) {
        $scope.totalCount = 0;
        $scope.pageSize = 8;
        $scope.pageNumber = 1;
        $scope.MinPrice = -1
        $scope.MaxPrice = -1
        $scope.ColorId = 0
        let ProCatId = $("main").attr("data-id")
        $scope.ListProduct = []

        $scope.getData = function () {
            $http.get("/client/getProCatData", {
                params: { ProCatId: ProCatId, colorId: $scope.ColorId, minPrice: $scope.MinPrice, maxPrice: $scope.MaxPrice, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
            }).then(function (res) {
                $scope.ListProduct = $scope.ListProduct.concat(res.data.Data)
                $scope.totalCount = res.data.TotalCount
            }, function (error) {
                alert("failed")
            })
        }
        $scope.getData()

        $scope.defaultAll = function () {
            $(".fillter-default").trigger("click")
            $(".fillter-close").trigger("click")
            $scope.MinPrice = -1
            $scope.MaxPrice = -1
            $scope.ColorId = 0
            $scope.ListProduct = []
            $scope.pageNumber = 1;
            $scope.getData()
        }

        $scope.ChangeColor = function (idColor) {
            $scope.ColorId = idColor
        }

        $scope.ChangePrice = function (min, max) {
            $scope.MinPrice = min
            $scope.MaxPrice = max
        }

        $scope.watchExtra = function () {
            $scope.pageNumber = $scope.pageNumber + 1
            $scope.getData()
        }

        $scope.ApplyFilter = function () {
            $(".fillter-close").trigger("click")
            $scope.ListProduct = []
            $scope.pageNumber = 1;

            $scope.getData()
        }


        $scope.addActive = function (e) {
            let parent = $(e.target).parents(".product-size-wrap")
            let listItem = $(parent).find(".product-size")
            $(listItem).removeClass("active")
            $(e.target).addClass("active")
        }
    }
</script>
@endsection
@section('content')
<main data-id="{{ $procat->ProCatId }}">
    <!--sub menu-->
    <div class="sub-menu position-relative">
        <div class="container-main">
            <ul class="d-flex flex-wrap  p-0 position-relative" style="margin: 0 -20px;z-index:15;">

                @include('client.shared.submenu', ['Categories' => $Categories])
            </ul>
        </div>
    </div>
    <div class="container-main">
        <ul class="breadcrumb mt-2 mb-2">
            <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Trang chủ</a></li>
            @if ($procat->Category->type == "Nữ")
                <li class="breadcrumb-item"><a href="{{ route('client.women') }}">{{ $procat->Category->type }}</a></li>
            @elseif ($procat->Category->type == "Nam")
                <li class="breadcrumb-item"><a href="{{ route('client.man') }}">{{ $procat->Category->type }}</a></li>
            @elseif ($procat->Category->type == "Bé trai")
                <li class="breadcrumb-item"><a href="{{ route('client.baby_boy') }}">{{ $procat->Category->type }}</a></li>
            @elseif ($procat->Category->type == "Bé gái")
                <li class="breadcrumb-item"><a href="{{ route('client.baby_girl') }}">{{ $procat->Category->type }}</a></li>
            @endif
            <li class="breadcrumb-item"><a href="{{ route('client.showCat',$procat->Category->CatID) }}">{{ $procat->Category->Name }}</a></li>
            <li class="breadcrumb-item active">{{ $procat->Name }}</li>
        </ul>
        <div class="row">
            <div class="col-md-2 col-md-block col-none category-left">
                
                @include('client.shared.submenu', ['Categories' => $Categories,'proCatId',$proCatId])
            </div>
            <div class="col-md-10 col-12" ng-controller="ShowProCatController">
                <div class="category-right  position-relative">
                    <div class="text-end mb-3">
                        <div class="fillter-btn px-3 position-relative" style="cursor:pointer;background: #f6f6f6; line-height:40px ; font-weight: 500;z-index:10;">
                            Bộ lọc
                            <img src="/assets/client/img/Filter.svg" alt="">
                        </div>
                        <div class="fillter-close px-3  position-relative" style="background-color: #f6f6f6; line-height:40px;color:#da291c;cursor: pointer;z-index:10;">
                            <span>Đóng</span>
                        </div>
                    </div>
                    <div class="row gx-3 gy-5 position-relative">
                        <!--begin fillter-content-->
                        <div class="fillter-content position-absolute top-0 start-0 end-0 px-1 " style="z-index: 12;">
                            <div class="fillter-content__inner bg-white shadow pt-5">
                                <div class="row">
                                    <div class="col-6  border-end">
                                        <div>
                                            <div class="d-flex justify-content-between mb-4" style="padding: 0 40px">
                                                <span style="font-weight: 600;">Khoảng giá</span>
                                                <span class="default-price fillter-default" ng-click="ChangePrice(null,null)">Mặc định</span>
                                            </div>
                                            <div style="padding:0 40px;">
                                                <div class="block-price  d-flex align-items-center mb-2" ng-click="ChangePrice(0,200000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;">0 ₫ - 200.000 ₫</span>
                                                </div>
                                                <div class="block-price d-flex align-items-center mb-2" ng-click="ChangePrice(201000,400000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;">200.000 ₫ - 400.000 ₫</span>
                                                </div>
                                                <div class="block-price d-flex align-items-center mb-2" ng-click="ChangePrice(401000,600000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;">400.000 ₫ - 600.000 ₫</span>
                                                </div>
                                                <div class="block-price d-flex align-items-center mb-2" ng-click="ChangePrice(601000,800000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;">600.000 ₫ - 800.000 ₫</span>
                                                </div>
                                                <div class="block-price d-flex align-items-center mb-2" ng-click="ChangePrice(801000,1000000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;">800.000 ₫ - 1000.000 ₫</span>
                                                </div>
                                                <div class="block-price d-flex align-items-center mb-2" ng-click="ChangePrice(1001000,1600000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;">1000.000 ₫ - 1600.000 ₫</span>
                                                </div>
                                                <div class="block-price d-flex align-items-center mb-2" ng-click="ChangePrice(1601000,10000000)">
                                                    <input style="width: 18px;height: 18px;margin-right: 10px;" type="radio" name="a" id="">
                                                    <span style="pointer-events: none;"> > 1600.000 ₫</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 border-end">
                                        <div class="d-flex justify-content-between mb-4" style="padding: 0 40px">
                                            <span style="font-weight: 600;">Màu sắc</span>
                                            <span class="default-color fillter-default" ng-click="ChangeColor(null)">Mặc định</span>
                                        </div>
                                        <div style="padding:0 40px; display: flex;flex-wrap: wrap;">
                                            @foreach ($listColor as $item)
                                                <a class="fillter-color" ng-click="ChangeColor('{{ $item->ProColorID }}')" style="background-image: url('/storage/uploads/ProductColor/{{ $item->ImageColor }}');"></a>

                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                                <div class="p-4 border-top text-end">
                                    <a class="delete-all me-3" ng-click="defaultAll()">Về mặc định</a>
                                    <a class="apply" ng-click="ApplyFilter()">Áp dụng</a>
                                </div>
                            </div>
                        </div>
                        <!--end fillter-content-->
                        <div class=" text-center" ng-if="ListProduct.length==0">
                            <h2 class="">
                                Không tìm thấy sản phẩm!
                            </h2> 
                        </div>
                        <div class="col-xl-3 col-md-4 col-6" ng-repeat="item in ListProduct" ng-if="ListProduct.length>0">
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
                <div class="d-flex mt-3 justify-content-center">
                    <button class="btn btn-dark text-white " ng-if="totalCount > ListProduct.length" ng-click="watchExtra()">Xem thêm</button>
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
            <img src="/assets/client/img/logo.svg" alt="" />
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
                <a class="header-link" href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
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
            <a class="header-link" href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.outlet') }}">OUTLET</a>
        </li>
    </ul>
@endsection