var importBillApp = angular.module("importBillApp", ['angularUtils.directives.dirPagination'])
importBillApp.controller("importBillController", importBillController)

function importBillController($scope, $http) {

    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = '5'

    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách loại sản phẩm*/
        $http.get("/admin/importbill/getPageData",
            { params: { searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize } }).then(function (res) {
                $scope.ImportBills = res.data.Data
                $scope.totalCount = res.data.TotalCount
            }, function (error) {
                alert("failed")
            })
    }

    $scope.getPage()

    $scope.showDetail = function (im) {
        $http.get("/admin/importbill/getById/" + im.ImpId).then(function (res) {
            $scope.ImportBill = res.data
            console.log(res.data)
        })
    }

    $scope.cancel = function (index, im) {
        if (confirm(`Bạn có muốn hủy đơn hàng mã ${im.ImpId}`)) {
            $http({
                method: "GET",
                url: "/Admin/ImportBill/CancelBill/" + im.ImpId,
                dataType: 'Json'
            }).then(function (res) {
                if (res.data) {
                    $scope.ImportBills.splice(index, 1)
                    $("#successToast .text-toast").text(`Hóa đơn nhập ${im.ImpId} đã được hủy`)
                    $("#successToast").toast("show")
                }
                else {
                    $("#erorrToast .text-toast").text(`Không thể hủy hóa đơn nhập ${im.ImpId}`)
                    $("#erorrToast").toast("show")
                }
            })
        }
    }

}