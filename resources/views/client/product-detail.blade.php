@extends('client.shared.layout_client');
@section('styles')
<link href="/assets/client/css/product-detail.css" rel="stylesheet" />
<link href="/assets/client/css/resposiveDetail.css" rel="stylesheet" />
<style>
    .wrapSizeOfColor {
        display: none;
    }

        .wrapSizeOfColor.active {
            display: block
        }

    /*feedback */
    .review-title {
        padding: 34px 0 34px 64px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        border-bottom: 1px solid #d9d9d9;
    }

    .quantity-review {
        font-size: 24px;
        margin-right: 90px;
        font-weight: 700;
    }

    .quantity-star {
        display: flex;
        align-items: center;
    }

        .quantity-star span {
            font-size: 24px;
            font-weight: 700;
        }

        .quantity-star i {
            color: #2F5ACF;
            font-size: 20px;
        }

    .review-fillter {
        padding: 24px 0 24px 70px;
        border-bottom: 1px solid #d9d9d9;
        display: flex;
        justify-content: flex-start;
    }

        .review-fillter select {
            border: none;
            font-weight: 700;
        }

        .review-fillter > div {
            width: 150px;
        }

    .feedback-content {
        padding: 0 65px;
    }

    .feedback-item {
        padding: 20px 0;
        border-bottom: 1px solid #d9d9d9;
        display: flex;
    }

    .feedback-item__rating {
        padding-left: 6px;
        width: 155px;
        display: flex;
        align-items: flex-start;
    }

        .feedback-item__rating i {
            color: #2F5ACF;
            font-size: 13px;
            margin-right: 5px;
        }

    i.disabled {
        color: #d9d9d8;
    }

    .feedback-item__body {
        flex: 1;
    }

    .feedback-userName {
        display: block;
        font-size: 13px;
        line-height: 15px
    }

    .feedback-product-type {
        font-size: 11px;
        color: rgba(0,0,0,.4);
    }

    .feedback-of-custom {
        margin: 10px 0 10px;
        height: 60px;
        line-height: 20px;
        font-size: 14px;
        display: -webkit-box;
        padding: 0 30px 0 0;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .feedback-time {
        color: rgba(0,0,0,.4);
    }

    .feedback-page {
        padding: 25px 0 15px;
        text-align: center;
    }

        .feedback-page span {
            font-size: 15px;
            position: relative;
            bottom: 0.5px;
        }

    .btn-page-left,
    .btn-page-right {
        padding: 0 5px;
        cursor: pointer;
        transition: all 0.1s;
    }

        .btn-page-left:hover,
        .btn-page-right:hover {
            color: #2F5ACF;
        }
</style>
@endsection
@section('scripts')
<script src="/assets/framework/dirPagination.js"></script>
<script src="/assets/client/js/product-detail.js"></script>
<script>
    ClientApp.controller("FeedbackController", FeedbackController)

    function FeedbackController($scope, $http) {
        $scope.ProId = JSON.parse($("main").attr("data")).ProId
        $scope.star = "0"
        $scope.Image = "null"

        $http.get("/admin/feedback/getTotalReview/" + $scope.ProId).then(function (res) {
            if (res.data.check) {
                $scope.totalReview = res.data.totalReview
                $scope.ratingAverage = res.data.ratingAverage
            }
        })

        $scope.getData = function () {
            /** Lấy danh sách category*/
            $http.get("/admin/feedback/getByProduct", {
                params: { proId: $scope.ProId, star: $scope.star, Image: $scope.Image }
            }).then(function (res) {
                $scope.feedbacks = res.data
            }, function (error) {
                alert("failed")
            })
        }
        $scope.getData()
    }
</script>
@endsection
@section('content')
<main data='{"ProId":"{{ $product->ProId }}","ProName":"{{ $product->ProName }}","Price":"{{ $product->Price }}","DiscountPrice":"{{ $product->DiscountPrice }}","Percent":{{ $product->Percent }}}'>
    <div class="topbar text-center text-white">
        <div>Thêm vào giỏ  200.000 ₫ để  miễn phí vận chuyển</div>
        <div>ĐỔI HÀNG MIỄN PHÍ - Tại tất cả cửa hàng trong 30 ngày</div>
    </div>
    <section style="padding: 0 40px;" id="detail-section">
        <div class="container-main">

            <!--content-->
            <ul class="breadcrumb mt-5 mb-4">
                <li class="breadcrumb-item"><a href="/Home/HomePage">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="/ShowCat/ShowProCat/$product->ProductCat.ProCatId">{{ $product->ProductCat->Name }}</a></li>
                <li class="breadcrumb-item active">{{ $product->ProName }}</li>
            </ul>
            <div class="row">
                <div class="col-md-8">
                    <div class="detail-img-side d-flex">
                        <div class=" me-1 flex-grow-1 overflow-hidden">
                            <img class="main-img" src="/storage/uploads/Product/{{ $firstProImage->Image }}">
                        </div>
                        <div class="list-img pb-1">
                            @if ($firstProImage->Image != "")
                                <img class="list-img-item MainImage" src="/storage/uploads/Product/{{ $firstProImage->Image }}" alt="">
                            @endif
                            @if ($firstProImage->DetailImage1 != "")
                                <img class="list-img-item Detail1" src="/storage/uploads/Product/{{ $firstProImage->DetailImage1 }}" alt="">
                            @endif
                            @if ($firstProImage->DetailImage2 != "")
                                <img class="list-img-item Detail2" src="/storage/uploads/Product/{{ $firstProImage->DetailImage2 }}" alt="">
                            @endif
                            @if ($firstProImage->DetailImage3 != "")
                                <img class="list-img-item Detail3" src="/storage/uploads/Product/{{ $firstProImage->DetailImage3 }}" alt="">
                            @endif
                            @if ($firstProImage->DetailImage4 != "")
                                <img class="list-img-item Detail4" src="/storage/uploads/Product/{{ $firstProImage->DetailImage4 }}" alt="">
                            @endif
                            @if ($firstProImage->DetailImage5 != "")
                                <img class="list-img-item Detail5" src="/storage/uploads/Product/{{ $firstProImage->DetailImage5 }}" alt="">
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="padding-left: 60px;">
                    <h4>{{ $product->ProName }}</h4>
                    <div class="d-flex fs-5 align-items-center mt-3">
                        @if ($product->DiscountPrice != 0 && $product->DiscountPrice != null)
                            <div class="detail-current-price me-3 price">{{ $product->DiscountPrice }}</div>
                            <div class="detail-old-price text text-decoration-line-through price" style="font-size:18px;color:#fdaa63">{{ $product->Price }}</div>
                        @else
                            <div class="detail-current-price me-3 price">{{ $product->Price }}</div>
                        @endif
                    </div>
                    <p>Đã bán: {{ $saled }}</p>
                    <hr style="height: 1px;background-color:#adaaaa;margin: 30px 0;">
                    <div class="detail-list-color">
                        <p>Màu sắc: <span class="color-chose">{{ $firstProImage->ProductColor->NameColor }}</span></p>
                        <div class="d-flex">
                            @foreach ($product->ProductImages as $index => $item)
                            @if ($index ==0)
                            <div class="product-color detail-color active" onclick="changeImageDetail(event, {{ $item->ProColorID }})" data-srcColor="/storage/uploads/ProductColor/{{ $item->ProductColor->ImageColor }}" data-nameColor="{{ $item->ProductColor->NameColor }}" data-idColor="{{ $item->ProColorID }}" data-Images='{"MainImage":"/storage/uploads/Product/{{ $item->Image }}","Detail1":"/storage/uploads/Product/{{ $item->DetailImage1 }}","Detail2":"/storage/uploads/Product/{{ $item->DetailImage2 }}","Detail3":"/storage/uploads/Product/{{ $item->DetailImage3 }}","Detail4":"/storage/uploads/Product/{{ $item->DetailImage4 }}","Detail5":"/storage/uploads/Product/{{ $item->DetailImage5 }}"}'>
                                <span data="" style="background-image: url('/storage/uploads/ProductColor/{{ $item->ProductColor->ImageColor }}');pointer-events:none;"></span>
                            </div>
                            @else
                            <div class="product-color detail-color" onclick="changeImageDetail(event, {{ $item->ProColorID }})" data-srcColor="/storage/uploads/ProductColor/{{ $item->ProductColor->ImageColor }}" data-nameColor="{{ $item->ProductColor->NameColor }}" data-idColor="{{ $item->ProColorID }}" data-Images='{"MainImage":"/storage/uploads/Product/{{ $item->Image }}","Detail1":"/storage/uploads/Product/{{ $item->DetailImage1 }}","Detail2":"/storage/uploads/Product/{{ $item->DetailImage2 }}","Detail3":"/storage/uploads/Product/{{ $item->DetailImage3 }}","Detail4":"/storage/uploads/Product/{{ $item->DetailImage4 }}","Detail5":"/storage/uploads/Product/{{ $item->DetailImage5 }}"}'>
                                <span data="" style="background-image: url('/storage/uploads/ProductColor/{{ $item->ProductColor->ImageColor }}');pointer-events:none;"></span>
                            </div>
                            @endif

                        @endforeach
                        </div>
                    </div>
                    <div class="detail-list-size">
                        <p>Kích cỡ: <span class="size-choose"></span></p>
                        <div class="list-size mt-2 wrapActiveToFirstChild">
                            @foreach ($product->ProductImages as $proImg)
                    <div class="wrapSizeOfColor wrapSizeOfColor-{{ $proImg->ProColorID }} addActiveItem">
                        @foreach ($product->ProductVariations as $item)
                            @if ($item->ProColorID == $proImg->ProColorID)
                                @if ($item->Quantity - $item->Ordered > 0)
                                    <div class="product-size" data-idSize="{{ $item->ProductSize->ProSizeID }}">{{ $item->ProductSize->NameSize }}</div>
                                @else
                                    <div class="product-size disabled-size" data-idSize="{{ $item->ProductSize->ProSizeID }}">{{ $item->ProductSize->NameSize }}</div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                    @endforeach
                        </div>
                    </div>
                    <hr style="height: 1px;background-color:#adaaaa;margin: 30px 0;">
                    <div>
                        <a href="" class="size-guide">Hướng dẫn chọn size</a>
                    </div>
                    <div class="mb-3">
                        <div style="font-size: 14px;" class="mt-3">
                            <img src="~/Assets/img/check.svg" alt="">
                            Miễn phí giao hàng Cho đơn hàng từ <b>200.000đ</b>
                        </div>
                        <div style="font-size: 14px;" class="mt-3">
                            <img src="~/Assets/img/check.svg" alt="">
                            Đổi trả miễn phí trong vòng <b>30 ngày</b> kể từ ngày mua
                        </div>
                    </div>
                    <div>
                        <button class="btn-addCart my-3" onclick="addCartFromDetail()">Thêm vào giỏ hàng</button>
                        <button class="btn-find-store">Tìm tại cửa hàng</button>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <div class="detail-like">
                            <img class="me-1" src="~/Assets/img/detail-heart.svg" alt="">
                            <span>Thêm vào yêu thích</span>
                        </div>
                        <div class="detail-share">
                            <img class="me-1" src="~/Assets/img/share.svg" alt="">
                            <span>Thêm vào yêu thích</span>
                        </div>
                    </div>
                    <hr style="height: 1px;background-color:#adaaaa;margin: 30px 0;">
                    <div id="accordion">

                        <div class="card card-detail">
                            <div class="card-header">
                                <a id="card1" class="btn collapsed-btn" data-bs-toggle="collapse" href="#collapseOne">
                                    Mô tả
                                </a>

                            </div>
                            <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                <div class="card-body">
                                    {{ $product->Description }}
                                </div>
                            </div>
                        </div>

                        <div class="card card-detail">
                            <div class="card-header">
                                <a id="card2" class="collapsed btn collapsed-btn" data-bs-toggle="collapse" href="#collapseTwo">
                                    Chất liệu

                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    {{ $product->Material }}
                                </div>
                            </div>
                        </div>

                        <div class="card card-detail">
                            <div class="card-header">
                                <a id="card3" class="collapsed btn collapsed-btn" data-bs-toggle="collapse" href="#collapseThree">
                                    Hướng dẫn sử dụng

                                </a>
                            </div>
                            <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    Giặt máy ở chế độ nhẹ, nhiệt độ thường.
                                    Không sử dụng hóa chất tẩy có chứa Clo.
                                    Phơi trong bóng mát.
                                    Sấy thùng, chế độ nhẹ nhàng.
                                    Là ở nhiệt độ trung bình 150 độ C.
                                    Giặt với sản phẩm cùng màu.
                                    Không là lên chi tiết trang trí.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="related-products">
        <div class="container-main">
            <h3>Có thể bạn sẽ thích</h3>
            <div class="product-related">
                @foreach ($RelatedProduct as $item)
                <div class="product" data='{"ProId":"{{ $item->ProId }}","ProName":"{{ $item->ProName }}","Price":"{{ $item->Price }}","DiscountPrice":"{{ $item->DiscountPrice }}","Percent":{{ $item->Percent }}}'>
                    <div class="wrapActiveToFirstChild">
                        @foreach ($item->ProductImages as $proImg)
                        <div data-id="{{ $proImg->ProColorID }}" class="wrap-image addActiveItem">
                            <div class="product-img">
                                <a href="{{route('client.product-detail',$item->ProId)}}">
                                    <img src="/storage/uploads/Product/{{ $proImg->Image }}" width="100%" alt="">
                                </a>
                                <div class="product-size-wrap">
                                    <div class="d-flex justify-content-center flex-wrap pt-3 wrapActiveToFirstChild">
                                        @foreach ($item->ProductVariations as $vairiation)
                                        @if ($vairiation->ProColorID == $proImg->ProColorID)
                                            @if (($vairiation->Quantity - $vairiation->Ordered) > 0)
                                            <div class="product-size addActiveItem" onclick="addActive(event)" data-idSize="{{ $vairiation->ProductSize->ProSizeID }}">{{ $vairiation->ProductSize->NameSize }}</div>
                                            @else
                                        <div class="product-size addActiveItem disabled-size" data-idSize="{{ $vairiation->ProductSize->ProSizeID }}">{{ $vairiation->ProductSize->NameSize }}</div>
                                        @endif
                                        @endif
                                        @endforeach
                                    </div>
                                    <a class="product-btn-addCart bg-dark text-white d-inline-block p-2" onclick="addCart(this)" style="font-weight:500;font-size: 12px;cursor:pointer">THÊM VÀO GIỎ HÀNG</a>
                                </div>
                                @if ($item->Percent != 0)
                                    <span class="price-percent text-white">-{{ $item->Percent }}%</span>
                                @endif
                            </div>
                            <div class="product-color-list d-flex pt-3 pb-2">
                                @foreach ($item->ProductImages as $color)
                                    @if ($color->ProColorID == $proImg->ProColorID)
                                    <div class="product-color active" onclick="changeProduct(event)" data-idColor="{{ $color->ProColorID }}">
                                        <span style="background-image: url('/storage/uploads/ProductColor/{{ $color->ProductColor->ImageColor }}')" data-src="/storage/uploads/ProductColor/{{ $color->ProductColor->ImageColor }}"></span>
                                    </div>
                                    @else
                                    <div class="product-color" onclick="changeProduct(event)" data-idColor="{{ $color->ProColorID }}">
                                        <span style="background-image: url('/storage/uploads/ProductColor/{{ $color->ProductColor->ImageColor }}');" data-src="/storage/uploads/ProductColor/{{ $color->ProductColor->ImageColor }}"></span>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('client.product-detail',$item->ProId) }}" class="product-name">
                        {{ $item->ProName }}
                    </a>
                    @if ($item->DiscountPrice != 0)
                    <div class="d-flex mt-1">
                        <div class="curent-price price me-3">{{ $item->DiscountPrice }}</div>
                        <div class="curent-old price" data="">{{ $item->Price }}</div>
                    </div>
                    @else
                    <div class="d-flex mt-1">
                        <div class="curent-price price me-3">{{ $item->Price }}</div>
                    </div>
                    @endif
                </div>
                @endforeach


            </div>
        </div>
    </section>
    <section class="feedback-section" ng-controller="FeedbackController">
        <div class="feedback">
            <div class="review-title">
                <p class="quantity-review">@{{totalReview}} Đánh giá</p>
                <div class="quantity-star">
                    <span>@{{ratingAverage}} / 5</span>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>
            <div class="review-fillter">
                <div class="review-fillter__rating">
                    <select name="" ng-model="star" ng-change="getData()">
                        <option value="0">Đánh giá</option>
                        <option value="1">1 sao</option>
                        <option value="2">2 sao</option>
                        <option value="3">3 sao</option>
                        <option value="4">4 sao</option>
                        <option value="5">5 sao</option>
                    </select>
                </div>
                <div class="review-filter__image">
                    <select name="" ng-model="Image" ng-change="getData()">
                        <option value="null">Ảnh</option>
                        <option value="true">Có ảnh</option>
                        <option value="false">Không ảnh</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 text-center" ng-if="feedbacks.length == 0">
                <h3>Chưa có phản hồi nào</h3>
            </div>
            <div class="feedback-content">
                <div class="row">
                    <div class="col-6 p-6" dir-paginate="f in feedbacks | itemsPerPage: 10">
                        <div class="feedback-item row">
                            <div class="d-flex flex-column col-2">
                                <div class="feedback-item__rating p-0 mb-2">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star @{{f.Stars < 2 ? 'disabled' : ''}}"></i>
                                    <i class="fa-solid fa-star @{{f.Stars < 3 ? 'disabled' : ''}}"></i>
                                    <i class="fa-solid fa-star @{{f.Stars < 4 ? 'disabled' : ''}}"></i>
                                    <i class="fa-solid fa-star @{{f.Stars < 5 ? 'disabled' : ''}}"></i>

                                </div>
                                <div class="p-2" ng-if="f.Image">
                                    <img src="/storage/uploads/Feedback/@{{ f.Image }}" style="width:100%; max-height: 100px; border-radius: 2px;" alt="">
                                </div>
                            </div>
                            <div class="feedback-item__body col-10">
                                <b class="feedback-userName">@{{f.Customer.Name}}</b>
                                <i class="feedback-product-type">@{{f.product_variation.product_color.NameColor}}/@{{f.product_variation.product_size.NameSize}}</i>
                                <p class="feedback-of-custom">@{{f.Content}}.</p>
                                <p class="feedback-time">@{{f.Datetime | date:"dd/MM/yyyy 'lúc' h:mma"}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3"><dir-pagination-controls></dir-pagination-controls></div>
            </div>
            
        </div>
    </section>
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
            <a class="header-link" href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.outlet') }}">OUTLET</a>
        </li>
    </ul>
@endsection