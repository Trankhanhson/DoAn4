@extends('admin.layout')
@section('styles')
    
@endsection
@section('scripts')
    <script src="/assets/framework/dirPagination.js"></script>
    <script src="/assets/admin/FileAngularjs/FeedbackAngular.js"></script>
@endsection
@section('content')
<main id="main" class="main" ng-app="FeedbackApp" ng-controller="FeedbackController">
    <h4 class="fw-bold">Danh sách feedback</h4>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="text-end mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <input type="text" class="input-searchView me-3" ng-model="searchText" ng-change="getPage(1)" placeholder="Tìm kiếm theo tên sản phẩm" />
                                <select ng-model="pageSize" class="limitShow">
                                    <option ng-click="getPageSize('5')" value="5">5</option>
                                    <option ng-click="getPageSize('10')" value="10">10</option>
                                    <option ng-click="getPageSize('15')" value="15">15</option>
                                    <option ng-click="getPageSize('20')" value="20">20</option>
                                </select>

                                <select ng-model="StatusFeedback" ng-change="getPage(1)" class="limitShow ms-3" style="width:200px;max-width:200px">
                                    <option value="true">Đã duyệt</option>
                                    <option value="false">Chưa duyệt</option>
                                </select>
                            </div>

                        </div>
                        <table class="table table-hover table-bordered pt-4" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th class="oneLine">
                                        Tên sản phẩm
                                    </th>
                                    <th>
                                        Khách hàng
                                    </th>
                                    <th style="width:15%">
                                        Tùy chỉnh
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="category-wrap">
                                <tr dir-paginate="f in feedbacks | itemsPerPage: pageSize" total-items="totalCount">
                                    <td>
                                        @{{f.product_variation.product.ProName}}
                                    </td>
                                    <td>
                                        @{{f.customer.CusID}}-@{{f.customer.Name}}
                                    </td>
                                    <td>
                                        <button data-bs-toggle="modal" ng-if="f.Status == false" ng-click="showDetail($index,f.FeedbackId)" data-bs-target="#ConfirmReview" class="btn btn-sm mt-2 btn-primary">Duyệt đánh giá</button>
                                        <button ng-if="f.Status" ng-click="ChangeStatus(f.FeedbackId)" class="btn btn-sm mt-2 btn-primary">Bỏ duyệt</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination sortPagiBar">
                            <dir-pagination-controls max-size="maxSize"
                                                     boundary-links="true"
                                                     direction-links="true"
                                                     on-page-change="getPage(newPageNumber)"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade " id="ConfirmReview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-2 border-0">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 pb-5">
                    <h3 class="fw-bold">@{{Feedback.Stars}} sao</h3>
                    <div class="row">
                        <div class="col-2">
                            <img ng-if="Feedback.Image" src="/storage/uploads/Feedback/@{{ Feedback.Image }}" class="rounded-2" alt="Alternate Text" style="width: 100%" />
                            <img ng-if="Feedback.Image == false" src="~/Upload/no-img.png" alt="Alternate Text " class="rounded-2" style="width: 100%" />
                        </div>
                        <div class="col-10">
                            <div class="form-floating mb-3 h-100">
                                <textarea maxlength="300" class="form-control" ng-model="Feedback.Content" placeholder="Nhập bình" style="height: 100%;" disabled></textarea>
                                <label for="floatingTextarea">Bình luận</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button class="btn btn-primary w-50 mt-3 mx-auto" ng-if="Feedback.Status" ng-click="ChangeStatus(Feedback.FeedbackId)">Bỏ duyệt</button>
                        <button class="btn btn-primary w-50 mt-3 mx-auto" ng-if="Feedback.Status == false" ng-click="ChangeStatus(Feedback.FeedbackId)">Duyệt</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection