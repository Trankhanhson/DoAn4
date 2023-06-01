@extends('admin.layout')
@section('styles')
    <link href="/assets/admin/css/report.css" rel="stylesheet" />
    <style>
        .table-order-items .order-product {
            display: -ms-flexbox;
            display: flex;
        }
        .table-order-items .order-product-photo {
    width: 40px;
    min-width: 40px;
    margin-right: 13px;
}
img {
    height: auto;
    width: 100%;
}
.table-order-items tbody tr td, .table-order-items tbody tr th {
    color: #333f48;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
    padding: 10px 0 13px 16px;
    vertical-align: middle;
    text-align: left;
    border-top: 1px solid #f6f6f6;
}
    </style>
@endsection
@section('scripts')
<script>
    var ReportApp = angular.module("ReportApp", [])
    ReportApp.controller("ReportController", function ($scope, $http) {
        const d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = d.getFullYear() + '/' + (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day;

        $scope.Day = new Date(output)
        $scope.Month = new Date(output)
        $scope.Year = d.getFullYear()

        $http({
            url: "/admin/reportProductDay",
            method: "POST",
            data: { date: 0 }
        }).then(function (res) {
            $scope.listResult = res.data
        })

        $scope.getReportDay = function () {
            
            if ($scope.formDay.$valid) {
                let day = document.getElementById("Day").value
                $http({
                    url: "/admin/reportProductDay",
                    method: "POST",
                    data: { date: day }
                }).then(function (res) {
                    $scope.listResult = res.data
                })
            }
        }

        $scope.getReportMonth = function () {
            if ($scope.formMonth.$valid) {
                $http({
                    url: "/admin/reportProductMonth",
                    method: "POST",
                    data: { month: $scope.Month.getMonth()+1,year:$scope.Year }
                }).then(function (res) {
                    $scope.listResult = JSON.parse(res.data.resultList)
                    $scope.MonthResult = $scope.Month
                })
            }
        }

        $scope.getReportYear = function () {
            $http({
                url: "/admin/reportProductYear",
                method: "POST",
                data: { year: $scope.Year }
            }).then(function (res) {
                $scope.listResult = JSON.parse(res.data.resultList)
                $scope.YearResult = $scope.Year
            })
        }
    })
</script>
@endsection
@section('content')
<main id="main" class="main" ng-app="ReportApp" ng-controller="ReportController">
    <h4 class="fw-bold">Báo cáo</h4>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation" ng-click="getReportDay()">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Theo ngày</button>
                            </li>
                            <li class="nav-item" role="presentation"  ng-click="getReportMonth()">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Theo tháng</button>
                            </li>
                            <li class="nav-item" role="presentation" ng-click="getReportYear()">
                                <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year" type="button" role="tab" aria-controls="year" aria-selected="false">Theo năm</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form name="formDay" novalidate>
                                    <div class="row">
                                        <div class="d-flex col-4">
                                            <label for="inputText" class="col-form-label" style="width:100px">Chọn Ngày</label>
                                            <div class="flex-grow-1 position-relative">
                                                <input type="date" id="Day" name="Day" ng-model="Day" class="form-control text-dark" required>
                                                <span ng-show="formDay.$submitted">
                                                    <span class="error" ng-show="formDay.Day.$error.required">Bạn chưa chọn ngày</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-primary" style="line-height:25px" ng-click="getReportDay()">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                                <h4 class="text-center mt-5 fw-bold">Báo cáo ngày @{{DayResult | date:'dd/MM/yyyy'}}</h4>
                                <div class="detail-report mt-4" >
                                    <table class="table table-hover table-bordered table-order-items table-listProduct">
                                        <thead class="text-dark table-primary">
                                            <tr>
                                                <th style="width: 35%">Sản phẩm</th>
                                                <th style="width: 20%">Số lượng</th>
                                                <th>Doanh thu</th>
                                                <th>Lợi nhuận</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="item in listResult">
                                                <td>
                                                    <div class="order-product">
                                                        <div class="order-product-photo">
                                                            <img src="/storage/uploads/Product/@{{item.product.product_images[0].Image}}" alt="">
                                                        </div>
                                                        <div class="order-product-details">
                                                            <div class="order-product-name">
                                                                @{{item.product.ProName}}
                                                            </div>
                                                            <div>Màu : @{{ item.product_color.NameColor }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>@{{item.Quantity}}</td>
                                                <td class="col">
                                                    @{{item.Revenue | number}}đ
                                                </td>
                                                <td class="col">@{{item.Profit | number}}đ</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <form name="formMonth" class="formMonth" novalidate>
                                    <div class="row">
                                        <div class="d-flex col-4">
                                            <label for="inputText" class="col-form-label" style="width:100px">Chọn tháng</label>
                                            <div class="flex-grow-1 position-relative">
                                                <input type="month" id="Month" name="Month" ng-model="Month" class="form-control text-dark" required>
                                                <span ng-show="formMonth.$submitted">
                                                    <span class="error" ng-show="formMonth.Month.$error.required">Bạn chưa chọn tháng</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-primary" style="line-height:25px" ng-click="getReportMonth()">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                                <h4 class="text-center mt-5 fw-bold">Báo cáo tháng @{{MonthResult | date:'MM/yyyy'}}</h4>

                                <div class="detail-report mt-4" >
                                    <table class="table table-hover table-bordered table-order-items table-listProduct">
                                        <thead class="text-dark table-primary">
                                            <tr>
                                                <th style="width: 35%">Sản phẩm</th>
                                                <th style="width: 20%">Số lượng</th>
                                                <th>Doanh thu</th>
                                                <th>Lợi nhuận</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="item in listResult">
                                                <td>
                                                    <div class="order-product">
                                                        <div class="order-product-photo">
                                                            <img src="/storage/uploads/Product/@{{item.product.product_images[0].Image}}" alt="">
                                                        </div>
                                                        <div class="order-product-details">
                                                            <div class="order-product-name">
                                                                @{{item.product.ProName}}
                                                            </div>
                                                            <div>Màu : @{{ item.product_color.NameColor }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>@{{item.Quantity}}</td>
                                                <td class="col">
                                                    @{{item.Revenue | number}}đ
                                                </td>
                                                <td class="col">@{{item.Profit | number}}đ</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="year-tab">
                                <form name="formYear" class="formYear" novalidate>
                                    <div class="row">
                                        <div class="d-flex col-4">
                                            <label for="inputText" class="col-form-label" style="width:100px">Chọn năm</label>
                                            <div class="flex-grow-1 position-relative">
                                                <input type="number" id="Year" name="Year" ng-model="Year" oninput="this.value = !!this.value && Math.abs(this.value) >= 2020 ? Math.abs(this.value) : 2020" class="form-control text-dark">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-primary" style="line-height:25px" ng-click="getReportYear()">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                                <h4 class="text-center mt-5 fw-bold">Báo cáo năm @{{YearResult}}</h4>
                                <div class="detail-report mt-4">
                                    <table class="table table-hover table-bordered table-order-items table-listProduct">
                                        <thead class="text-dark table-primary">
                                            <tr>
                                                <th style="width: 35%">Sản phẩm</th>
                                                <th style="width: 20%">Số lượng</th>
                                                <th>Doanh thu</th>
                                                <th>Lợi nhuận</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="item in listResult">
                                                <td>
                                                    <div class="order-product">
                                                        <div class="order-product-photo">
                                                            <img src="/storage/uploads/Product/@{{item.product.product_images[0].Image}}" alt="">
                                                        </div>
                                                        <div class="order-product-details">
                                                            <div class="order-product-name">
                                                                @{{item.product.ProName}}
                                                            </div>
                                                            <div>Màu : @{{ item.product_color.NameColor }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>@{{item.Quantity}}</td>
                                                <td class="col">
                                                    @{{item.Revenue | number}}đ
                                                </td>
                                                <td class="col">@{{item.Profit | number}}đ</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection