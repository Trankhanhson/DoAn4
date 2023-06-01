var OrderApp = angular.module("OrderApp", ['angularUtils.directives.dirPagination']);

OrderApp.controller("OrderController", function ($scope, $http) {
    let statusId = $("main").attr("data-statusId")
    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = "5"

    $scope.getPage = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách đơn hàng*/
        $http.get("/admin/order/getPageData", {
            params: { statusId: statusId, searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize }
        }).then(function (res) {
            $scope.OrderList = res.data.Data
            $scope.totalCount = res.data.TotalCount
        }, function (error) {
            alert("failed")
        })
    }

    $scope.getPage(1)

    let indexChange = 0
    $scope.showDetail = function (index, id) {
        indexChange = index
        $http.get("/admin/order/getOrderById/" + id).then(function (res) {
            $scope.Order = res.data.order
            $scope.TotalOriginPrice = res.data.totalOriginPrice
        })
    }

    $scope.ChangeStatus = function (id) {
        if (confirm(`Bạn có muốn duyệt đơn hàng mã ${id}`)) {
            $http.get("/admin/order/changeStatus/"+id).then(function (res) {
                $scope.OrderList.splice(indexChange, 1)
                $(".modal-footer .close-modal").trigger("click")
                $("#successToast .text-toast").text(`Đơn hàng ${id} đã được chuyển sang trạng thái ${res.data}`)
                $("#successToast").toast("show")
                
            })
        }
    }

    $scope.cancel = function (index, o) {
        if (confirm(`Bạn có muốn hủy đơn hàng mã ${o.OrdID}`)) {
            $http.get("/admin/order/cancelOrder/"+o.OrdID).then(function (res) {
                if (res.data) {
                    $scope.OrderList.splice(index, 1)
                    $("#successToast .text-toast").text(`Đơn hàng ${o.OrdID} đã được hủy`)
                    $("#successToast").toast("show")
                }
                else {
                    $("#erorrToast .text-toast").text(`Không thể hủy đơn hàng ${o.OrdID}`)
                    $("#erorrToast").toast("show")
                }
            })
        }
    }

    $scope.Delete = function (index, o) {
        if (confirm(`Bạn có muốn xóa đơn hàng mã ${o.OrdID}`)) {
            $http.get("/admin/order/delete/"+o.OrdID).then(function (res) {
                if (res.data) {
                    $scope.OrderList.splice(index, 1)
                    $("#successToast .text-toast").text(`Đơn hàng ${o.OrdID} đã được xóa`)
                    $("#successToast").toast("show")
                }
                else {
                    $("#erorrToast .text-toast").text(`Không thể xóa đơn hàng ${o.OrdID}`)
                    $("#erorrToast").toast("show")
                }
            })
        }
    }

});