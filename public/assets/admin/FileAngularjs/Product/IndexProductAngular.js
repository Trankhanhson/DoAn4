var ProductApp = angular.module("ProductApp", ['angularUtils.directives.dirPagination'])
ProductApp.controller("ProductController", ProductController)

function ProductController($scope, $http) {

    $scope.maxSize = 5;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = '5'
    $scope.minimumQuantity = "0";
    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách loại sản phẩm*/
        $http.get("/admin/product/getPageData",
            { params: {getMinimum: $scope.minimumQuantity, searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize } }).then(function (res) {
                $scope.products = res.data.Data
                $scope.totalCount = res.data.TotalCount
            }, function (error) {
                alert("failed")
            })
    }

    $scope.getPage(1)

    $scope.showVariation = function (proId) {
        $(`.row-variation-${proId}`).toggle()
        $(`.row-product-${proId}`).toggleClass("active")
    }

    $scope.ChangeStatus = function (event, id) {
        event.stopPropagation()
        if (confirm("Bạn có chắc chắn muốn đổi trạng thái")) {
            $http.get("/admin/product/changeStatus/" + id).then(function (res) {
                    $("#successToast .text-toast").text("Đã cập nhật trạng thái thành công")
                    $("#successToast").toast("show")
            })

        }
    }
    $scope.deleteProduct = function (id) {
        if (confirm("Bạn có chắc chắn muốn xóa")) {
            $http.get("/admin/product/destroy/"+id).then(function (res) {
                if (res.data) {
                    $("#successToast .text-toast").text("Đã xóa thành công")
                    $("#successToast").toast("show") //hiển thị thông báo thành công
                    //remove khỏi view
                    $(`.row-product-${id}`).remove()
                    $(`.row-variation-${id}`).remove()
                }
                else {
                    $("#errorToast .text-toast").text("Sản phẩm này đang được dùng ở nơi khác")
                    $("#errorToast").toast("show")
                }
            })
        }
    }
}