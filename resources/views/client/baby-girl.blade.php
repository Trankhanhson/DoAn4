@extends('client.shared.layout_client');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/subIndex.css">
@endsection
@section('scripts')
    <script  src="/assets/client/js/subIndex.js"></script>
@endsection
@section('content')
<main>
    <!--sub menu-->
    <div class="sub-menu position-relative">
        <div class="container-main">
            <ul class="d-flex flex-wrap  p-0" style="margin: 0 -20px;">
                @include('client.shared.submenu', ['Categories' => $Categories])
            </ul>
        </div>

    </div>

    <div class="container-main">
        <ul class="breadcrumb my-3">
            <li class="breadcrumb-item"><a href="./index.html">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Bé gái</a></li>
        </ul>
        <!--Banner-->
        <section class="banner pb-4">
            <img src="https://media.canifa.com/Simiconnector/banner_name_tablet1683129407.webp" width="100%" alt="">
        </section>


        <!--category-->
        <section class="pt-lg-5 pt-4 pb-5 border-bottom border-1" style="height: fit-content;">
            <h2 class="section-heading mb-4">Danh mục sản phẩm</h2>
            <div class="category-slider">
                @foreach ($ProductCats as $item)
                    <div class="text-center category-item">
                        <a href="{{ route('client.showProCat',$item->ProCatId) }}">
                            <img width="256px" height="256px" class="rounded-circle" src="/storage/uploads/ProductCat/{{ $item->Image }}" alt="">
                        </a>
                        <a href="#" class="mt-3" style="color: var(--primary-text-color);">{{ $item->Name }}</a>
                    </div>
                @endforeach

            </div>
        </section>

        {{-- @foreach (var Section in Model)
        {
            <section class="pt-lg-5 pt-4 pb-4">
                <h2 class="section-heading">@Section.Title</h2>
                <div class="row gx-3 mt-3">
                    <div class="col-lg-3 d-lg-block d-none pe-xl-4 pe-lg-2 pe-0 product-banner-slider">
                        @if (Section.Image1.Value)
                        {
                            <a href="@Section.Link1">
                                <img src="~/Upload/Section/@(Section.SectionId)/1.jpg" alt="">
                            </a>

                        }
                        @if (Section.Image2.Value)
                        {
                            <a href="@Section.Link2">
                                <img src="~/Upload/Section/@(Section.SectionId)/2.jpg" alt="">
                            </a>

                        }
                        @if (Section.Image3.Value)
                        {
                            <a href="@Section.Link3">
                                <img src="~/Upload/Section/@(Section.SectionId)/3.jpg" alt="">
                            </a>
                        }

                    </div>
                    <div class="col-lg-9 col-12">
                        <div class="product-slider">
                            @foreach (var item in Section.ProductSections)
                            {
                                <div class="product" data='{"ProId":"@item.Product.ProId","ProName":"@item.Product.ProName","Price":"@item.Product.Price","DiscountPrice":"@item.Product.DiscountPrice","Percent":@item.Product.Percent}'>
                                    <div class="wrapActiveToFirstChild">
                                        @foreach (var proImg in item.Product.ProductImages)
                                        {
                                            <div data-id="@proImg.ProColorID" class="wrap-image addActiveItem">
                                                <div class="product-img">
                                                    <a href="/Home/Detail/@item.Product.ProId">
                                                        <img src="/Upload/Product/@item.Product.ProId/@proImg.Image" width="100%" alt="">
                                                    </a>
                                                    <div class="product-size-wrap">
                                                        <div class="d-flex justify-content-center flex-wrap pt-3 wrapActiveToFirstChild">
                                                            @foreach (var vairiation in item.Product.ProductVariations)
                                                            {
                                                                if (vairiation.ProColorID == proImg.ProColorID)
                                                                {
                                                                    if ((vairiation.Quantity - vairiation.Ordered) > 0)
                                                                    {
                                                                        <div class="product-size addActiveItem" onclick="addActive(event)" data-idSize="@vairiation.ProductSize.ProSizeID">@vairiation.ProductSize.NameSize</div>

                                                                    }
                                                                    else
                                                                    {
                                                                        <div class="product-size disabled-size" data-idSize="@vairiation.ProductSize.ProSizeID">@vairiation.ProductSize.NameSize</div>
                                                                    }
                                                                }
                                                            }
                                                        </div>
                                                        <a class="product-btn-addCart bg-dark text-white d-inline-block p-2" onclick="addCart(this)" style="font-weight:500;font-size: 12px;cursor:pointer">THÊM VÀO GIỎ HÀNG</a>
                                                    </div>
                                                    @if (item.Product.Percent != 0 && item.Product.Percent != null)
                                                    {
                                                        <span class="price-percent text-white">-@item.Product.Percent%</span>
                                                    }
                                                </div>
                                                <div class="product-color-list d-flex pt-3 pb-2">
                                                    @foreach (var color in item.Product.ProductImages)
                                                    {
                                                        if (color.ProColorID == proImg.ProColorID)
                                                        {
                                                            <div class="product-color active" onclick="changeProduct(event)" data-idColor="@color.ProColorID">
                                                                <span style="background-image: url('/Upload/ColorImage/@color.ProductColor.ProColorID/@color.ProductColor.ImageColor')" data-src="/Upload/ColorImage/@color.ProductColor.ProColorID/@color.ProductColor.ImageColor"></span>
                                                            </div>
                                                        }
                                                        else
                                                        {
                                                            <div class="product-color" onclick="changeProduct(event)" data-idColor="@color.ProColorID">
                                                                <span style="background-image: url('/Upload/ColorImage/@color.ProductColor.ProColorID/@color.ProductColor.ImageColor');" data-src="/Upload/ColorImage/@color.ProductColor.ProColorID/@color.ProductColor.ImageColor"></span>
                                                            </div>
                                                        }
                                                    }
                                                </div>
                                            </div>
                                        }
                                    </div>
                                    <a href="/Home/Detail/@item.Product.ProId" class="product-name">
                                        @item.Product.ProName
                                    </a>
                                    @if (item.Product.DiscountPrice != 0 && item.Product.DiscountPrice != null)
                                    {
                                        <div class="d-flex mt-1">
                                            <div class="curent-price price me-3">@item.Product.DiscountPrice</div>
                                            <div class="curent-old price" data="">@item.Product.Price</div>
                                        </div>
                                    }
                                    else
                                    {
                                        <div class="d-flex mt-1">
                                            <div class="curent-price price me-3">@item.Product.Price</div>

                                        </div>
                                    }
                                    @if (item.Product.Liked == false || item.Product.Liked == null)
                                    {
                                        <div class="product-like" onclick="LikeProduct(this,@item.Product.ProId)">
                                            <span>Yêu thích</span>
                                            <img class="product-like-img1" src="/Assets/img/heart-icon.svg" alt="">
                                            <i class="product-like-img2 fa-solid fa-heart"></i>
                                        </div>
                                    }
                                    else
                                    {
                                        <div class="product-like active" onclick="LikeProduct(this,@item.Product.ProId)">
                                            <span>Yêu thích</span>
                                            <img class="product-like-img1" src="/Assets/img/heart-icon.svg" alt="">
                                            <i class="product-like-img2 fa-solid fa-heart"></i>
                                        </div>
                                    }
                                </div>
                            }

                        </div>
                    </div>
                </div>

            </section>
        } --}}

        <!--new product-->
        <!--new product-->
        <section class="pt-5 pb-5">
            <!-- Nav pills -->
            <ul class="nav nav-pills ">
                <h2 class="section-heading pe-4">ĐỀ XUẤT CHO BẠN</h2>
                <li class="nav-item">
                    <a class="nav-link product-new__link active" data-bs-toggle="pill" href="#bestSale">BÁN CHẠY NHẤT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link product-new__link" data-bs-toggle="pill" href="#newProduct">SẢN PHẨM MỚI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link product-new__link" data-bs-toggle="pill" href="#DiscountProduct">SẢN PHẨM KHUYẾN MẠI</a>
                </li>
            </ul>

            <div class="tab-content mt-5">
                <div class="tab-pane active" id="bestSale">
                    <div class="row gx-3 gy-5">
                        @foreach ($listBestSale as $item)
                        <div class="col-xl-3 col-md-4 col-6">
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
                                                    <div class="product-size disabled-size" data-idSize="{{ $vairiation->ProductSize->ProSizeID }}">{{ $vairiation->ProductSize->NameSize }}</div>
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
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="newProduct">
                    <div class="row gx-3 gy-5">
                        @foreach ($listNewProduct as $item)
                        <div class="col-xl-3 col-md-4 col-6">
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
                                                    <div class="product-size disabled-size" data-idSize="{{ $vairiation->ProductSize->ProSizeID }}">{{ $vairiation->ProductSize->NameSize }}</div>
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
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="DiscountProduct">
                    <div class="row gx-3 gy-5">
                        @foreach ($listDiscount as $item)
                        <div class="col-xl-3 col-md-4 col-6">
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
                                                    <div class="product-size disabled-size" data-idSize="{{ $vairiation->ProductSize->ProSizeID }}">{{ $vairiation->ProductSize->NameSize }}</div>
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
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </section>
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
                <a class="header-link active" href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
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
            <a class="header-link active" href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.outlet') }}">OUTLET</a>
        </li>
    </ul>
@endsection