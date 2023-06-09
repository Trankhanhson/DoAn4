@extends('client.shared.layout_cart');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/cart.css">
<link href="/assets/client/css/Payment.css" rel="stylesheet" />
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script src="/assets/client/js/Cart/UpdateCart.js"></script>
<script src="/assets/client/js/Cart/Payment.js"></script>
@endsection
@section('content')
<main class="border-top">
    <div class="d-flex justify-content-between align-items-center w-50 mx-auto my-5">
        <div class="process-item flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center"
                  style="width:24px;line-height:22px;font-size: 14px;background-color: #63b1bc;">
                <img class="my-auto"
                     src="/assets/client/img/checkpay.svg" style="position: relative;top: -2px;" alt="">
            </span>
            Giỏ hàng
        </div>
        <div class="flex-grow-1 border-top text-center"></div>
        <div class="process-item active flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center"
                  style="width:24px;line-height:22px;font-size: 14px;">2</span>
            Đặt hàng
        </div>
        <div class="flex-grow-1 border-top text-center"></div>
        <div class="process-item flex-grow-1 text-center">
            <span class="rounded-circle border me-2 d-inline-block text-center"
                  style="width:24px;line-height:22px;font-size: 14px;">3</span>
            Hoàn tất
        </div>
    </div>
    <div class="cart-content pt-3">
        <div class="row g-1 align-items-stretch">
            <div class="col-lg-8 col-12 h-100">
                <div class="cart-content__left">
                    <div class="info-client pb-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Thông tin giao hàng</h4>
                            <a class="text-black fw-bold text-decoration-underline fs-6" href="{{ route('client.cart') }}">
                                <img src="/assets/client/img/back.svg" alt=""><span>Quay lại giỏ hàng</span>
                            </a>
                        </div>
                        @if ($Customer)
                        <form action="" class="form-Payment account-setting-form mt-4" style="max-width:550px" data-cusid="{{ $Customer->CusID }}">
                            <div class="form-group active mb-0">
                                <label>Họ tên</label>
                                <input type="text" value="{{ $Customer->Name }}" name="name" id="name" class="form-control">
                                <label class="error" for="name" style="display: none;"></label>
                            </div>
                            <div class="form-group active mt-4 mb-0">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" id="phone" value="{{ $Customer->Phone }}" class="form-control ">
                                <label id="phone-error" class="error" for="phone" style="display: none;"></label>
                            </div>
                            <select class="form-select form-select-sm mt-4 mb-0" id="city" name="city" aria-label="form-select-sm">
                                <option value="" selected>Tỉnh / Thành phố</option>
                            </select>
                            <select class="form-select form-select-sm mt-4 mb-0" id="district" name="district" aria-label="form-select-sm">
                                <option value="" selected>Quận / Huyện</option>
                            </select>
                            <select class="form-select form-select-sm mt-4 mb-0" id="ward" name="ward" aria-label="form-select-sm">
                                <option value="" selected>Phường / Xã</option>
                            </select>
                            <div class="form-group active mt-4 mb-0">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" id="address" value="{{ $Customer->Address }}" class="form-control ">
                            </div>
                            <div class="form-group active mt-4 mb-0">
                                <label>Ghi chú</label>
                                <input type="text" name="note" id="note" class="form-control">
                            </div>
                        </form>
                        @else
                        <form action="" class="form-Payment account-setting-form mt-4" style="max-width:550px" data-cusid="0">
                            <div class="form-group active mb-0">
                                <label>Họ tên</label>
                                <input type="text" value="" name="name" id="name" class="form-control">
                                <label class="error" for="name" style="display: none;"></label>
                            </div>
                            <div class="form-group active mt-4 mb-0">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" id="phone" value="" class="form-control ">
                                <label id="phone-error" class="error" for="phone" style="display: none;"></label>
                            </div>
                            <select class="form-select form-select-sm mt-4 mb-0" id="city" name="city" aria-label="form-select-sm">
                                <option value="" selected>Tỉnh / Thành phố</option>
                            </select>
                            <select class="form-select form-select-sm mt-4 mb-0" id="district" name="district" aria-label="form-select-sm">
                                <option value="" selected>Quận / Huyện</option>
                            </select>
                            <select class="form-select form-select-sm mt-4 mb-0" id="ward" name="ward" aria-label="form-select-sm">
                                <option value="" selected>Phường / Xã</option>
                            </select>
                            <div class="form-group active mt-4 mb-0">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" id="address" value="" class="form-control ">
                            </div>
                            <div class="form-group active mt-4 mb-0">
                                <label>Ghi chú</label>
                                <input type="text" name="note" id="note" class="form-control">
                            </div>
                        </form>
                        @endif
                    </div>
                    <div class="py-3 ">
                        <h4 class="mt-4 mb-3">Phương thức thanh toán</h4>
                        <div class="mb-3 d-flex justify-content-between align-items-center border payment-method active"
                             style="padding: 12px 16px;cursor: pointer;">
                            <div class="d-flex align-items-center" style="pointer-events: none;">
                                <input type="radio" value="COD" name="PaymentMethod" class="radioPay">
                                <p style="font-size:16px;margin-left: 15px;">Thanh toán khi nhận hàng (COD)</p>
                            </div>
                            <img src="/assets/client/img/cod.svg" alt="">
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center border payment-method"
                             style="padding: 12px 16px;cursor: pointer;">
                            <div class="d-flex align-items-center" style="pointer-events: none;">
                                <input type="radio" value="VNPAY" name="PaymentMethod" class="radioPay">
                                <p style="font-size:16px;margin-left: 15px;">Thanh toán bằng VNPAY</p>
                            </div>
                            <img src="/assets/client/img/vnpay.svg" alt="">
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center border payment-method"
                             style="padding: 12px 16px;cursor: pointer;">
                            <div class="d-flex align-items-center" style="pointer-events: none;">
                                <input type="radio" value="ShopeePay" name="PaymentMethod" class="radioPay">
                                <p style="font-size:16px;margin-left: 15px;">Thanh toán bằng ShopeePay</p>
                            </div>
                            <img src="/assets/client/img/shopeepay.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="cart-content__right">
                    <h4>Đơn hàng</h4>
                    <div class="d-flex justify-content-between mt-4 mb-2" style="color:#77757f;">
                        <span>Giá gốc</span>
                        <span class="original-price"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="color:#77757f;">
                        <span>Giảm giá</span>
                        <span class="discount-total" data="" style="color: rgb(218, 41, 28);"></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold pb-5 border-bottom">
                        <span>Tổng tiền thanh toán</span>
                        <span class="total-price"></span>
                    </div>
                    {{-- <div class="checkout-step checkout-coupon">
                        <div data-v-e422017c="" class="discount-block">
                            <div data-v-e422017c="" class="coupon-public">
                                <div data-v-e422017c="" class="coupons">
                                    @foreach (var item in ViewBag.Vouchers)
                                    {
                                        <div data-v-e422017c="" class="coupon" onclick="getVoucher(this,@item.VoucherId, '@item.Name', @item.MiximumMoney, @item.Amount, '@item.TypeAmount')">
                                            <div data-v-e422017c="" class="coupon-left"></div> <div data-v-e422017c="" class="coupon-right">
                                                <div data-v-e422017c="" class="coupon-title">
                                                    @item.Name
                                                    <span data-v-e422017c="" class="coupon-count"><i data-v-e422017c="">(Còn @(item.MaxUses - item.UsedCurrent))</i></span>
                                                </div> <div data-v-e422017c="" class="coupon-description"><span>@item.Description</span></div>
                                            </div>
                                        </div>
                                    }
                                </div>
                            </div>
                        </div> --}}
                        <div class="checkout-step-content" style="padding-bottom: 25px;">
                            <div class="checkout-coupon-form">
                                <input type="hidden" class="voucherId" />
                                <input type="text" name="promoCode" data-IdVoucher="" placeholder="Chọn voucher phía trên" disabled class="form-control voucher-title">
                                <button class="btn-add-coupon btn-add p-0">Mã giảm giá</button>
                            </div>
                            <div class="voucher-error text-danger mt-3">

                            </div>
                        </div>
                    </div>
                    <button onclick="confirmPhone()"  class="btn-order">THANH TOÁN</button>
                </div>
            </div>

        </div>
    </div>
</main>
<div class="modal fade block-login" id="ConfirmOrder" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div data-v-07844138="" class="block-content p-3">
                <h4>Xác thực mua hàng</h4>
                <div class="note">
                    Mã OTP vừa được gửi đến số điện thoại
                    <span class="toPhone text-dark"></span>
                    <div class="my-4 text-center">
                        <input id="partitioned" class="border border-secondary p-2" placeholder="Nhập mã OTP" type="text" maxlength="6" />
                    </div>
                </div>
                <div class="otp-time">
                    <span>
                        Thời gian hiệu lực
                        <span class="time" id="timer">03 : 00</span>
                    </span>
                </div>
                <div class="actions">
                    <button class="btn btn-confirm text-white mb-2" onclick="codeverity()">Xác thực</button>
                    <div class="d-none" id="Confirm"></div>
                </div>
                <div class="actions-secondary" onclick="Resend()"><a>Gửi lại Mã</a></div>
            </div>
        </div>
    </div>
</div>
<div id="recaptcha-container"></div>
@endsection