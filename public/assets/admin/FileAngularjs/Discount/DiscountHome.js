var discountApp = angular.module("discountApp", ['angularUtils.directives.dirPagination']);

discountApp.controller("discountController", function ($scope, $http) {
    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = '5'

    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách loại sản phẩm*/
        $http.get("/admin/discount/getPageData", {
            params: { searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
        }).then(function (res) {
            $scope.discountList = res.data.Data
            $scope.totalCount = res.data.TotalCount
        })
    }
    $scope.getPage(1)

    $scope.showDetail = function (id) {
        $http.get("/admin/discount/getById/" + id).then(function (res) {
            debugger
            $scope.Discount = res.data

            for (let i = 0; i < $scope.Discount.DiscountDetails.length; i++) {
                $scope.Discount.DiscountDetails[i].TypeAmount = $scope.Discount.DiscountDetails[i].TypeAmount == "0" ? "đ" : "%"
            }
        })
    }

    $scope.Delete = function (index, item) {
        if (confirm(`Bạn có muốn hủy chương trình ${item.Name}`)) {
            $http.get("/admin/discount/destroy/" + item.DiscountProductId).then(function (res) {
                if (res.data) {
                    $scope.discountList.splice(index, 1)
                    $("#successToast .text-toast").text(`Chương trình ${item.Name} đã được hủy`)
                    $("#successToast").toast("show")
                }
                else {
                    $("#erorrToast .text-toast").text(`Không thể hủy `)
                    $("#erorrToast").toast("show")
                }
            })
        }
    }
})