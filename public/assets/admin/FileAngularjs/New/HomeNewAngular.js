var PostApp = angular.module("PostApp", ['angularUtils.directives.dirPagination']);

PostApp.controller("PostController", function ($scope, $http) {

    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = "5"

    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách category*/
        $http.get("/admin/post/getPageData", {
            params: { searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
        }).then(function (res) {
            $scope.PostList = res.data.Data
            $scope.totalCount = res.data.TotalCount
        }, function (error) {
            alert("failed")
        })
    }

    $scope.getPage(1)

    /**Xóa danh mục*/
    $scope.Delete = function (n) {
        if (confirm(`Bạn có chắc chắn muốn xóa bài viết ${n.Title}`)) {
            $http.get("/admin/post/destroy/"+n.PostId).then(function (res) {
                if (res.data.check) {
                    var c = $scope.PostList.indexOf(n);
                    $scope.PostList.splice(c, 1);
                    $("#successToast .text-toast").text(res.data.message)
                    $("#successToast").toast("show") //hiển thị thông báo thành công
                }
                else {
                    $("#errorToast .text-toast").text(res.data.message)
                    $("#errorToast").toast("show")
                }
            })
        }
    }

    /** Change status*/
    $scope.ChangeStatusPost = function (newId) {
        $http({
            method: "Post",
            url: "/Admin/Post/ChangeStatus",
            dataType: 'Json',
            data: { id: newId }
        }).then(function (res) {
            if (res.data) {
                $("#successToast .text-toast").text("Đã lưu thay đổi")
                $("#successToast").toast("show") //hiển thị thông báo thành công
            }
            else {
                $("#errorToast .text-toast").text("Không thể lưu thay đổi")
                $("#errorToast").toast("show")
            }
        })
    }

});