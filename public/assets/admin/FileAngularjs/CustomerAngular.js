var CustomerApp = angular.module("CustomerApp", ['angularUtils.directives.dirPagination']);

CustomerApp.controller("CustomerController", CustomerController);

function CustomerController($scope, $http) {
    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = "5"


    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách category*/
        $http.get("/admin/getPageData", {
            params: { searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
        }).then(function (res) {
            $scope.customers = res.data.Data
            $scope.totalCount = res.data.TotalCount
        }, function (error) {
            alert("failed")
        })
    }

    $scope.getPage(1)

    /** Change status*/
    $scope.ChangeStatus = function (idCus) {
        if (confirm("Bạn có muốn thay đổi trạng thái của khách hàng này")) {
            $http({
                method: "get",
                url: "/admin/changeStatus/"+idCus,
            }).then(function (res) {
                    $("#successToast .text-toast").text("Đã lưu thay đổi")
                    $("#successToast").toast("show") //hiển thị thông báo thành công
            })
        }

    }

    
}