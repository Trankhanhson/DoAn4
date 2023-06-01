@extends('client.shared.layout_cart');
@section('styles')
    <link rel="stylesheet" href="/assets/client/css/cart.css">
@endsection

@section('content')
<main class="border-top">
    <div class="d-flex justify-content-between align-items-center w-50 mx-auto my-5">
        <div class="process-item active flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center" style="width:24px;line-height:22px;font-size: 14px;">1</span>
            Giỏ hàng
        </div>
        <div class="flex-grow-1 border-top text-center"></div>
        <div class="process-item active flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center" style="width:24px;line-height:22px;font-size: 14px;">2</span>
            Đặt hàng
        </div>
        <div class="flex-grow-1 border-top text-center"></div>
        <div class="process-item flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center" style="width:24px;line-height:22px;font-size: 14px;background-color: #63b1bc;"><img class="my-auto" src="/assets/client/img/checkpay.svg" style="position: relative;top: -2px;" alt=""></span>
            Hoàn tất
        </div>
    </div>
    <h4 class="text-center">Thông tin đơn hàng của bạn</h4>
    <div style="width: 60%;" class="bg-white mx-auto mt-4 border rounded p-4 bill shadow">
        <div class="d-flex align-items-center justify-content-center py-3">
            <p>ĐƠN HÀNG #{{ $order->OrdID }}</p><span class="badge bg-success ms-2 me-5"> {{ $order->StatusOrder->Status }}</span> <p class="text-secondary">Ngày đặt {{ date('d/m/Y',strtotime($order->OrderDate)) }}</p>
        </div>
        <table class="mt-3 cart-list w-100 mb-5">
            <thead style="background-color: #333f48; color:white;">
                <tr>
                    <th class="col item">Sản phẩm</th>
                    <th class="col">Giá gốc</th>
                    <th class="col">Giá giảm</th>
                    <th class="col">Số lượng</th>
                    <th class="col">Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->OrderDetails as $item)
                <tr id="product-{{ $item->ProVariationID }}" class="border-bottom">
                    <td class="col">
                        <div class="d-flex">
                            <a href="#">
                                <img class="img-item" src="/storage/uploads/Product/{{ $item->ProductVariation->DisplayImage }}" alt="">
                            </a>
                            <div style="width:100%" class="flex-grow-1">
                                <a href="" class="item-name">{{ $item->ProductVariation->Product->ProName }}</a>
                                <div class="d-flex align-items-center">
                                    <span class="item-size">{{ $item->ProductVariation->ProductSize->NameSize }}</span>
                                    <span>&nbsp;/&nbsp;</span>
                                    <span class="item-color">{{ $item->ProductVariation->ProductColor->NameColor }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="col ">
                        <span>{{number_format($item->Price,0,',','.')}}đ</span>
                    </td>
                    <td class="col ">
                        @if ($item->DiscountPrice)
                            <span>{{number_format($item->DiscountPrice,0,',','.')}}đ</span>
                        @else
                            <span>{{number_format($item->Price,0,',','.')}}đ</span>
                        @endif
                    </td>
                    <td class="col">
                        {{ $item->Quantity }}
                    </td>
                    <td class="col">
                        @if ($item->DiscountPrice)
                            <span>{{number_format(($item->DiscountPrice * $item->Quantity),0,',','.')}}đ</span>
                        @else
                            <span>{{number_format(($item->Price * $item->Quantity),0,',','.')}}đ</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <div class="d-flex py-2 border-bottom">
                <p class="me-3" style="width:180px">Tổng giá trị sản phẩm</p> <span class="price">{{ $totalOriginPrice }}</span>
            </div>
            <div class="d-flex py-2 border-bottom ">
                <p class="me-3" style="width:180px">Tổng khuyến mại</p><span class="price">{{ $totalDiscount }}</span>
            </div>
            <div class="d-flex py-2 border-bottom ">
                <p class="me-3" style="width:180px">Phí giao hàng</p> <span>25.000đ</span>
            </div>
            <div class="d-flex  py-2 border-bottom">
                <p class="me-3 fs-5" style="width:180px">Tổng thanh toán </p> <span class="fs-5 price">{{ $order->MoneyTotal+25000 }}</span>
            </div>
        </div>
    </div>
</main>
@endsection