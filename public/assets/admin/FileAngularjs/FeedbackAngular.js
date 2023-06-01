var FeedbackApp = angular.module("FeedbackApp", ['angularUtils.directives.dirPagination']);

FeedbackApp.controller("FeedbackController", FeedbackController);

function FeedbackController($scope, $http) {
    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = "5"
    $scope.StatusFeedback = "false"

    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách category*/
        $http.get("/admin/feedback/getPageData", {
            params: { StatusFeedback: $scope.StatusFeedback, searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
        }).then(function (res) {
            $scope.feedbacks = res.data.Data
            $scope.totalCount = res.data.TotalCount
        }, function (error) {
            alert("failed")
        })
    }

    $scope.getPage(1)

    let indexFeedback = 0
    $scope.showDetail = function (index, id) {
        indexFeedback = index
        $http.get("/admin/feedback/getById/" + id).then(function (res) {
            $scope.Feedback = res.data
        })
    }

    $scope.ChangeStatus = function (id) {
        if (confirm("Bạn có chắc chắn muốn đổi trạng thái bình luận này")) {
            $http.get("/admin/feedback/changeStatus/" + id).then(function (res) {
                    $scope.feedbacks.splice(indexFeedback, 1)
                    $("#successToast .text-toast").text("Cập nhật thành công")
                    $("#successToast").toast("show")
                    $("btn-close").trigger("click")
            })
        }
    }
}