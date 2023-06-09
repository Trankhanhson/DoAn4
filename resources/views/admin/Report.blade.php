@extends('admin.layout')
@section('styles')
    <link href="/assets/admin/css/report.css" rel="stylesheet" />
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
            url: "/admin/getReportDay",
            method: "POST",
            data: { date: 0 }
        }).then(function (res) {
            $scope.statisticalDay = res.data
            $scope.DayResult = $scope.Day
        })

        $scope.getReportDay = function () {
            
            if ($scope.formDay.$valid) {
                let day = document.getElementById("Day").value
                $http({
                    url: "/admin/getReportDay",
                    method: "POST",
                    data: { date: day }
                }).then(function (res) {
                    $scope.statisticalDay = res.data
                    $scope.DayResult = $scope.Day
                })
            }
        }

        $scope.getReportMonth = function () {
            if ($scope.formMonth.$valid) {
                $http({
                    url: "/admin/getReportMonth",
                    method: "POST",
                    data: { month: $scope.Month.getMonth()+1,year:$scope.Year }
                }).then(function (res) {
                    $scope.listReportMonth = JSON.parse(res.data.resultList)
                    $scope.TotalRevenueMonth = res.data.TotalRevenueMonth
                    $scope.TotalProfitMonth = res.data.TotalProfitMonth
                    $scope.MonthResult = $scope.Month
                })
            }
        }

        $scope.getReportYear = function () {
            $http({
                url: "/admin/getReportYear",
                method: "POST",
                data: { year: $scope.Year }
            }).then(function (res) {
                $scope.listReportYear = JSON.parse(res.data.resultList)
                $scope.TotalRevenueYear = res.data.TotalRevenueYear
                $scope.TotalProfitYear = res.data.TotalProfitYear
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
                                <div class="row mt-4">
                                    <!-- Sales Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card sales-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Đơn hàng thành công</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-cart"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6> @{{statisticalDay.Total_Order}} </h6>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- End Sales Card -->
                                    <!-- Customers Card -->
                                    <div class="col-xxl-4 col-xl-12">
                                        <div class="card info-card customers-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Doanh thu</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>@{{statisticalDay.Revenue != null? statisticalDay.Revenue : 0 | number}}đ</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Customers Card -->
                                    <!-- Revenue Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card revenue-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Lợi nhuận</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>@{{statisticalDay.Profit != null? statisticalDay.Profit : 0 | number}}đ</h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Revenue Card -->
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
                                <div class="row mt-4">
                                    <!-- Customers Card -->
                                    <div class="col-lg-6 col-12">
                                        <div class="card info-card customers-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Doanh thu</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>@{{TotalRevenueMonth != null? TotalRevenueMonth : 0 | number}}đ</h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Customers Card -->
                                    <!-- Revenue Card -->
                                    <div class="col-lg-6 col-12">
                                        <div class="card info-card revenue-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Lợi nhuận</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>@{{TotalProfitMonth != null ? TotalProfitMonth : 0 | number}}đ</h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- End Revenue Card -->

                                </div>
                                <div class="detail-report mt-4" ng-if="listReportMonth.length > 0">
                                    <h4 class="card-title">Chi tiết từng ngày</h4>
                                    <table class="table table-hover table-bordered table-listProduct">
                                        <thead class="text-dark table-primary">
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Doanh thu</th>
                                                <th>Lợi nhuận</th>
                                                <th style="width: 20%">Số lượng sản phẩm</th>
                                                <th style="width: 20%">Đơn hàng thành công</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="d in listReportMonth">
                                                <td>@{{d.Date | date: 'dd'}}</td>
                                                <td class="col">
                                                    @{{d.Revenue | number}}đ
                                                </td>
                                                <td class="col">@{{d.Profit | number}}đ</td>
                                                <td>@{{d.Quantity}}</td>
                                                <td>@{{d.Total_Order}}</td>
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

                                <div class="row mt-4">
                                    <!-- Customers Card -->
                                    <div class="col-lg-6 col-12">
                                        <div class="card info-card customers-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Doanh thu</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>@{{TotalRevenueYear | number}}đ</h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Customers Card -->
                                    <!-- Revenue Card -->
                                    <div class="col-lg-6 col-12">
                                        <div class="card info-card revenue-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Lợi nhuận</h5>

                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>@{{TotalProfitYear | number}}đ</h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!-- End Revenue Card -->
                                </div>
                                <div class="detail-report mt-4" ng-if="listReportYear.length > 0">
                                    <h4 class="card-title">Chi tiết từng tháng</h4>
                                    <table class="table table-hover table-bordered table-listProduct">
                                        <thead class="text-dark table-primary">
                                            <tr>
                                                <th>Tháng</th>
                                                <th>Doanh thu</th>
                                                <th>Lợi nhuận</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="m in listReportYear">
                                                <td>@{{m.date}}</td>
                                                <td class="col">
                                                    @{{m.Revenue | number}}đ
                                                </td>
                                                <td class="col">@{{m.Profit | number}}đ</td>
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