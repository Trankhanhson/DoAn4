@extends('client.shared.layout_cart');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/cart.css">
<link href="/assets/client/css/Payment.css" rel="stylesheet" />
@endsection
@section('scripts')

    <script src="/assets/client/js/Cart/UpdateCart.js"></script>
@endsection
@section('content')
<main class="border-top">
    <div class="d-flex justify-content-between align-items-center w-50 mx-auto my-5">
        <div class="process-item active flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center" style="width:24px;line-height:22px;font-size: 14px;">1</span>
            Giỏ hàng
        </div>
        <div class="flex-grow-1 border-top text-center"></div>
        <div class="process-item flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center" style="width:24px;line-height:22px;font-size: 14px;">2</span>
            Đặt hàng
        </div>
        <div class="flex-grow-1 border-top text-center"></div>
        <div class="process-item flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center" style="width:24px;line-height:22px;font-size: 14px;">3</span>
            Hoàn tất
        </div>
    </div>
    <div class="cart-content pt-5">
        <div class="row g-1 align-items-stretch">
            <div class="col-lg-8 col-12" style="background-color:#f9f9f9">
                <div class="cart-content__left">
                    <div class="fw-bold" style="font-size: 25px;">(<span style="font-size: 25px;" class="quantity-product"></span>) sản phẩm</div>
                    <table class="mt-3 cart-list w-100 table-cart">
                        <thead style="background-color: #333f48; color:white;">
                            <tr>
                                <th class="col item">Sản phẩm</th>
                                <th class="col">Giá tiền</th>
                                <th class="col qty">Số lượng</th>
                                <th class="col subtotal">Tổng tiền</th>
                                <th class="col action"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="cart-content__right h-100">
                    <h4>Đơn hàng</h4>
                    <div class="d-flex justify-content-between mt-4 mb-2" style="color:#77757f;">
                        <span>Giá gốc</span>
                        <span class="original-price"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="color:#77757f;">
                        <span>Giảm giá</span>
                        <span class="discount-total" style="color: rgb(218, 41, 28);"></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mb-5">
                        <span>Tổng tiền thanh toán</span>
                        <span class="total-price" data=""></span>
                    </div>
                    <a href="{{ route('client.paymentPage') }}" class="btn-order text-center" style="color:white;">ĐẶT HÀNG</a>
                    <p class="my-4" style="font-size: 13px; color:#77757f">Áp dụng mã giảm giá, C-point tại bước tiếp theo</p>
                    <hr class="border">
                    <div>
                        <p class="mt-4 mb-3" style="font-size: 13px; color:#77757f">Chúng tôi chấp nhận thanh toán:</p>
                        <img src="https://canifa.com/assets/images/payment-note.svg" alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

@endsection