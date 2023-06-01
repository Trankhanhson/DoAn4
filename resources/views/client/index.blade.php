@extends('client.shared.layout_client');
@section('content')
<main>
    <div class="topbar text-center text-white">
        <div>Thêm vào giỏ  499.000 ₫ để  miễn phí vận chuyển</div>
        <div>
            ĐỔI HÀNG MIỄN PHÍ - Tại tất cả cửa hàng trong 30 ngày
        </div>
    </div>
    <div class="container-main">
        <!--Banner-->
        <section class="banner py-4">
            <img src="https://media.canifa.com/Simiconnector/banner_name_tablet1682329031.webp" width="100%" alt="">
        </section>

        <!--Endow-->
        <section class="endow pt-lg-5 pt-4 pb-4">
            <h2 class="section-heading">Ưu đãi riêng bạn</h2>
            <div class="row gx-3">
                <div class="col-md-6 col-sm-12 mt-3">
                    <a href="#" class="endow-link">
                        <img class="endow-img" src="https://media.canifa.com/Simiconnector/list_image_tablet1683768857.webp" alt="">
                    </a>
                </div>
                <div class="col-md-6 col-sm-12 mt-3">
                    <a href="#" class="endow-link">
                        <img class="endow-img" src="https://media.canifa.com/Simiconnector/list_image_tablet_second1684570784.webp" alt="">
                    </a>
                </div>
            </div>
        </section>

        {{-- <!--Good price-->
        <section class="pt-lg-5 pt-4 pb-4">
            <h2 class="section-heading">Sản phẩm giá tốt</h2>
            <a href="#" class="mt-lg-3 mt-2">
                <img src="/Assets/img/list_image_tablet1646719696.jpg" width="100%" alt="">
            </a>
        </section>

        <!--Product-show-->
        @foreach (var Section in Model)
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

            <!-- Tab panes -->
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

        <!--Contact-->
        <section class="pt-4 pb-4">
            <div class="row">
                <div class="col-12 col-lg-6 mt-4">
                    <div class="block-subscribe d-flex">
                        <p>Đăng ký nhận bản tin</p>
                        <div class="form-subscribe flex-grow-1 position-relative bg-white">
                            <input type="text" id="input-subscribe" class="w-100 h-100" placeholder="Nhập email của bạn...">
                            <button type="submit" class="btn-subscribe" title="Gửi"></button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-4">
                    <div class="block-social d-flex justify-content-center align-items-center">
                        <p>Kết nối ngay</p>
                        <a class="facebook-icon" href="https://www.facebook.com/canifa.fanpage/" target="_blank"></a>
                        <a class="instagram-icon" href="https://www.instagram.com/canifa.fashion/" target="_blank"></a>
                        <a class="youtube-icon" href="https://www.youtube.com/CANIFAOfficial" target="_blank"></a>
                    </div>
                </div>
            </div>
        </section>

        <!--news-->
        <section CLASS="pt-5 pb-4">
            <h2 class="section-heading mb-4">#canifalife</h2>
            <div class="row gx-3 gy-5">

                @foreach ($listPost as $item)
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="news-img" style="background-image: url('/storage/uploads/Post/{{ $item->Image }}');">
                        </div>
                        <a href="{{ route('client.detailPost',$item->PostId) }}" class="news-name">{{ $item->Title }}</a>

                        <p class="news-time">{{ date('d/m/Y',strtotime($item->PublicDate)) }}</span></p>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('client.posts') }}" class="rounded-0 btn btn-lg border-1 border bg-white text-dark fs-6 bo mx-auto d-block mt-5 py-2" style="width: 220px;">Xem thêm</a>
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
                <a class="header-link active" href="{{ route('client.index') }}">TRANG CHỦ</a>
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
            <a class="header-link active" href="{{ route('client.index') }}">TRANG CHỦ</a>
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