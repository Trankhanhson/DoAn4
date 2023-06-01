productApp.controller("ColorController", ColorController)
function ColorController( $scope, $http) {

    //Thêm value size hoặc màu khi nhấn
    $scope.addValue = function (e) {
        addValue(e) //hàm được viết ở file product.js
    }

    $http.get("/admin/productcolor/getAll").then(function (res) {
        $scope.ColorList = res.data.listColor
    }, function (error) {
        alert("Có lỗi khi lấy dữ liệu")
    })

    $scope.setFile = function(element) {
        $scope.$apply(function() {
            $scope.fileImage = element.files[0];
        });
    };

    //khi người dùng nhấn thêm
    $scope.Add = function () {
        $scope.proColor = null
    }

    $scope.errorImage = false
    //thêm màu
    $scope.SaveAdd = function () {
        if ($scope.createColorForm.$valid) {
            var formData = new FormData();
            if($scope.fileImage!=undefined){
                formData.append('file', $scope.fileImage);
            }
            formData.append('NameColor', $scope.proColor.NameColor);

            $http.post('/admin/productcolor/create',formData,{
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (res) {
                if (res.data.check) //tạo mới thành công
                {
                    var proColor = res.data.proColor
                    $scope.ColorList.push(proColor)

                    //nếu người dùng chỉ nhấn lưu
                    $(".btn-closeModel").trigger('click') //đóng modal

                    //hiển thị thông báo thành công
                    $("#successToast .text-toast").text("Thêm màu thành công")
                    $("#successToast").toast("show")
                }
                else {
                    $("#errorToast .text-toast").text("Thêm thất bại")
                    $("#errorToast").toast("show")
                }
            })
        }
    }

    /** Sửa màu*/
    let indexEdit = 1 //biến chứa vị trí phần tử vừa sửa để thay thế lên view
    $scope.Edit = function (pc, index, e) {
        e.stopPropagation()
        $scope.proColor = { ProColorID: pc.ProColorID, NameColor: pc.NameColor, ImageColor: pc.ImageColor }
        indexEdit = index
    }

    $scope.SaveEdit = function () {
        if ($scope.editColorForm.$valid) {
            //nếu upload file mới thì gán tên file mới vào proCat
            var formData = new FormData();
            if($scope.fileImage!=undefined){
                formData.append('file', $scope.fileImage);
            }
            formData.append('NameColor', $scope.proColor.NameColor);

            $http.post('/admin/productcolor/update/'+$scope.proColor.ProColorID,formData,{
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (res) {
                if (res.data) //nếu update thành công
                {
                    //Tìm phần tử vừa được sửa trong danh sách và thay thế
                    $scope.ColorList.splice(indexEdit, 1, $scope.proColor)

                    $("#successToast .text-toast").text("Sửa màu thành công")
                    $("#successToast").toast("show") //hiển thị thông báo thành công
                }
                else {
                    $("#errorToast .text-toast").text("Sửa thất bại")
                    $("#errorToast").toast("show") //hiển thị thông báo thành công
                }
                $(".btn-closeModel").trigger('click') //đóng modal
            })
        }

    }

    /**Xóa màu*/
    $scope.Delete = function (proColor) {
        if (confirm(`Bạn có chắc chắn muốn xóa màu ${proColor.NameColor}`)) {
            $http.get("/admin/productcolor/destroy/"+proColor.ProColorID).then(function (res) {
                if (res.data.check) {
                    var c = $scope.ColorList.indexOf(proColor);
                    $scope.ColorList.splice(c, 1);
                    $("#successToast .text-toast").text("Đã xóa màu thành công")
                    $("#successToast").toast("show") //hiển thị thông báo thành công
                }
                else {
                    $("#errorToast .text-toast").text("Màu này đang được dùng ở sản phẩm")
                    $("#errorToast").toast("show")
                }
                $(".btn-closeModel").trigger('click') //đóng modal
            })
        }
    }
}