ClientApp.controller("orderHistoryController", orderHistoryController);

function orderHistoryController($scope, $http) {
    /** Lấy danh sách Order*/

    let CusId = $("main").attr("data-id")

    $scope.getOrder = function (statusId) {
        //add active
        $(".account-page-filter li").removeClass("active")
        $(`.filer-order-${statusId}`).addClass("active")

        $http.get("/client/infoaccount/getOrderByCusId", {
            params: { id: CusId, statusId: statusId }
        }).then(function (res) {
            $scope.OrderList = res.data.result
        }, function (error) {
            alert("failed")
        })
    }

    $scope.getOrder(0)

    $scope.showDetail = function (idOrder) {
        $scope.clickDetail = true
        $http.get("/admin/order/getOrderById/" + idOrder).then(function (res) {
            $scope.Order = res.data.order
            $scope.TotalOriginPrice = res.data.totalOriginPrice
        })
    }

    $scope.OrderBackClick = function () {
        $scope.clickDetail = false
    }

    $scope.CancelOrder = function (id) {
        if (confirm("Bạn có chắc chắn muốn hủy đơn hàng này")) {
            $http.get("/client/infoaccount/cancelOrder/" + id).then(function (res) {
                if (res.data) {
                    $(".order-status").text("Đã hủy")
                    $(".detail strong").text("Đã hủy")
                    $(".btn-cancelOrder").hide()
                }
                else {

                }
            })
        }

    }

    /*add Feedback*/
    //lưu file người dùng upload
    $scope.setFile = function(element) {
        $scope.$apply(function() {
            $scope.fileImage = element.files[0];
        });

        const reader = new FileReader()

        // Lấy thông tin tập tin được đăng tải
        const file = element.files
        // Đọc thông tin tập tin đã được đăng tải
        reader.readAsDataURL(file[0])
        // Lắng nghe quá trình đọc tập tin hoàn thành
        reader.addEventListener("load", (event) => {
            // Lấy chuỗi Binary thông tin hình ảnh
            const img = event.target.result;
            // Thực hiện hành động thêm chuỗi giá trị này vào thẻ IMG
            $(clickFile).find('.file-upload-image').attr('src', img);
            $(clickFile).find('.file-upload-content').show();
            $(clickFile).find('.image-upload-wrap').hide();
        })
    };

    $scope.removeImg = function () {
        $scope.fileImage = null
    }


    $scope.ChangeStar = function (number) {
        $scope.Feedback.Stars = number
    }

    $scope.AddF = function (variationId) {
        $(".rating-0").trigger("click")
        $scope.fileImage = null
        $scope.Feedback = { FeedbackId: null, ProVariationID: variationId, CusID: CusId, Content: "", Stars: 0, Image: false }
        $(".file-upload-image").attr("src", "")
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }

    $scope.AddFeedback = function () {

        if ($scope.Feedback.Stars == 0) {
            alertError("Nhấn vào hình sao để chọn số sao")
            return false
        }
        if ($scope.Feedback.Content == null || $scope.Feedback.Content.trim() == "") {
            alertError("Bạn chưa viết đánh giá")
            return false
        }
        var formData = new FormData();

        if($scope.fileImage!=undefined){
            formData.append('file', $scope.fileImage);  
        }
        formData.append('Stars',$scope.Feedback.Stars)
        formData.append('Content',$scope.Feedback.Content)
        formData.append('CusID',CusId)
        formData.append('ProVariationID',$scope.Feedback.ProVariationID)
        $(".btn-close").trigger("click")
        alertSuccess("Đánh giá thành công")
        $http.post('/admin/feedback/create',formData,{
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        }).then(function (res) {
            if (res.data.check) //tạo mới thành công
            {
                $(".btn-close").trigger("click")
                alertSuccess("Đánh giá thành công")
            }
            else {
                alertError("Đã có lỗi xảy ra")
            }
        })
    }

    /*Edit feedback*/
    $scope.EditF = function (feedbackId) {
        $scope.fileImage = null
        $http.get("/admin/feedback/getById/" + feedbackId).then(function (res) {
            $scope.Feedback = res.data

            //click to input of star
            let inputStar = $(`.rating-${$scope.Feedback.Stars}`)
            $(inputStar).trigger("click")

            if ($scope.Feedback.Image !=null && $scope.Feedback.Image != "") {
                $(".file-upload-image").attr("src", `/storage/uploads/Feedback/${$scope.Feedback.Image}`)
                $('.file-upload-content').show();
                $('.image-upload-wrap').hide();
            }

        })
    }

    $scope.EditFeedback = function () {
        if ($scope.Feedback.Stars == 0) {
            alertError("Nhấn vào hình sao để chọn số sao")
            return false
        }
        if ($scope.Feedback.Content == null || $scope.Feedback.Content.trim() == "") {
            alertError("Bạn chưa viết đánh giá")
            return false
        }

        var formData = new FormData();

        if($scope.fileImage!=undefined){
            formData.append('file', $scope.fileImage);  
        }
        formData.append('Stars',$scope.Feedback.Stars)
        formData.append('Content',$scope.Feedback.Content)
        $(".btn-close").trigger("click")
        alertSuccess("Sửa đánh giá thành công")
        $http.post('/admin/feedback/update/'+$scope.Feedback.FeedbackId,formData,{
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        }).then(function (res) {
            if (res.data) //tạo mới thành công
            {
                $(".btn-close").trigger("click")
                alertSuccess("Sửa đánh giá thành công")
            }
            else {
                alertError("Đã có lỗi xảy ra")
            }
        })
    }
}