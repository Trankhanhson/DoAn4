@extends('client.shared.layout_client');
@section('styles')
<link rel="stylesheet" href="/assets/client/css/news-home.css">
@endsection
@section('scripts')
<script type="text/javascript" src="/assets/client/js/news-home.js"></script>
<script>
    ClientApp.controller("NewController", function ($http, $scope) {
        $scope.maxSize = 3;
        $scope.totalCount = 0;
        $scope.searchText = ""
        $scope.pageSize = "1"
        $scope.NewList = []
        $scope.pageNumber = 1

        $scope.getPage = function() {
            /** Lấy danh sách category*/
            $http.get("/client/post/getPageData", {
                params: { searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
            }).then(function (res) {

                $scope.NewList = $scope.NewList.concat(res.data.Data)
                $scope.totalCount = res.data.TotalCount
            }, function (error) {
                alert("failed")
            })
        }

        $scope.getPage(1)
        $scope.watchExtra = function () {
            $scope.pageNumber = $scope.pageNumber + 1
            $scope.getPage()
        }
    })
</script>
@endsection
@section('content')
<main ng-controller="NewController">

    <section style="margin-top: 60px;">
        <div class="container-main">
            <div class="container-main">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 CLASS="fw-bold">Bài viết mới nhất</h3>
                </div>
                <div class="list-news">
                    @foreach ($recentPosts as $item)
                        <a href="{{ route('client.detailPost',$item->PostId) }}" class="news-item">
                            <div class="news-img" style="background-image: url('/storage/uploads/Post/{{ $item->Image }}');">
                            </div>
                            <p class="news-name text-dark">{{$item->Title}}</p>
                            <p class="news-time">{{ date('d/m/Y',strtotime($item->PublicDate)) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
    </section>

    <section style="margin-top: 60px;">
        <div class="container-main">
            <div class="container-main">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 CLASS="fw-bold">Tất cả bài viết</h3>
                </div>
                <div class="row gy-5">
                    <a href="/client/detailPost/@{{n.PostId}}" class="news-item col-4" ng-repeat="n in NewList">
                        <div class="news-img" style="background-image: url('/storage/uploads/Post/@{{ n.Image }}');">
                        </div>
                        <p class="news-name text-dark">@{{n.Title}}</p>
                        <p class="news-time">@{{n.PublicDate | date: "dd/MM/yyyy"}}</p>
                    </a>
                </div>
                <div class="d-flex mt-3 justify-content-center">
                    <button class="btn btn-dark text-white " ng-if="totalCount > NewList.length" ng-click="watchExtra()">Xem thêm</button>
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
                <a class="header-link " href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
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
            <a class="header-link " href="{{ route('client.baby_girl') }}">BÉ GÁI</a>
        </li>
        <li class="header-item">
            <a class="header-link " href="{{ route('client.baby_boy') }}">BÉ TRAI</a>
        </li>
        <li class="header-item">
            <a class="header-link" href="{{ route('client.outlet') }}">OUTLET</a>
        </li>
    </ul>
@endsection