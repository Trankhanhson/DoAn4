var proCatApp = angular.module("ProCatApp", ['angularUtils.directives.dirPagination']);

proCatApp.controller("ProCatController", function ($scope, $http) {
    $scope.maxSize = 3;
    $scope.totalCount = 0;
    $scope.searchText = ""
    $scope.pageSize = "5"

    $scope.GetPageProCat = function (newPage) {
        $scope.pageNumber = newPage
        /** Lấy danh sách loại sản phẩm*/
        $http.get("/admin/productcat/getPageData",
            { params: { searchText: $scope.searchText, pageNumber: $scope.pageNumber, pageSize: $scope.pageSize } }).then(function (res) {
                $scope.ProCatList = res.data.Data
                $scope.totalCount = res.data.TotalCount
                $scope.firstCatId = res.data.firstCatId
            }, function (error) {
                alert("failed")
            })
    }

    $scope.GetPageProCat(1)


    $scope.setFile = function(element) {
        $scope.$apply(function() {
            $scope.myFile = element.files[0];
        });
    };

    //khi người dùng nhấn thêm
    $scope.Add = function () {
        $scope.proCat = null
        $scope.proCat = { CatID: JSON.stringify($scope.firstCatId) }
    }
    //khi người dung nhấn lưu thêm mới loại sản phẩm
    $scope.SaveAdd = function (closeOrNew) {
        if ($scope.createForm.$valid) {
            var formData = new FormData();
            if($scope.myFile!=undefined){
                formData.append('file', $scope.myFile);
            }
            formData.append('Name', $scope.proCat.Name);
            formData.append('CatID', $scope.proCat.CatID);

            $http.post('/admin/productcat/create',formData,{
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (res) {
                if (res.data.check) //tạo mới thành công
                {
                    var productCat = res.data.pc
                    $scope.ProCatList.unshift(productCat) //hiển thị thêm đối tượng vừa thêm
                    //upload ảnh khi thêm đối tượng thành công
                    $scope.errorImage = false

                    //hiển thị thông báo thành công
                    $("#successToast .text-toast").text("Thêm loại sản phẩm thành công")
                    $("#successToast").toast("show")
                }
                else {
                    $("#errorToast .text-toast").text("Thêm thất bại")
                    $("#errorToast").toast("show")
                }
            })
        }
    }

    /** Sửa danh mục*/
    let indexEdit = 1 //biến chứa vị trí phần tử vừa sửa để thay thế lên view
    $scope.Edit = function (proCat, index) {
        $scope.proCat = { ProCatId: proCat.ProCatId, Name: proCat.Name, CatID: JSON.stringify(proCat.CatID), Active: proCat.Active}
        indexEdit = index
    }

    $scope.SaveEdit = function () {
        if ($scope.editForm.$valid) {
            var formData = new FormData();
            if($scope.myFile!=undefined){
                formData.append('file', $scope.myFile);
            }
            formData.append('proCat', JSON.stringify($scope.proCat));
            $http.post('/admin/productcat/update/'+$scope.proCat.ProCatId,formData,{
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (res) {
                if (res.data.check) //nếu update thành công
                {
                    //Tìm phần tử vừa được sửa trong danh sách và thay thế 
                    var newProCat = res.data.procat
                    $scope.ProCatList.splice(indexEdit, 1, newProCat)

                    $("#successToast .text-toast").text("Sửa loại sản phẩm thành công")
                    $("#successToast").toast("show") //hiển thị thông báo thành công
                }
                else {
                    $("#errorToast .text-toast").text("Sửa thất bại")
                    $("#errorToast").toast("show") //hiển thị thông báo thành công
                }
            })
        }

    }

    /**Xóa danh mục*/
    $scope.Delete = function (proCat) {
        if (confirm(`Bạn có chắc chắn muốn loại sản phẩm ${proCat.Name}`)) {
            $http.get('/admin/productcat/destroy/'+proCat.ProCatId).then(function (res) {
                if (res.data.check) {
                    var c = $scope.ProCatList.indexOf(proCat);
                    $scope.ProCatList.splice(c, 1);
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
    $scope.ChangeStatusProCat = function (proCatId) {
        $http('/admin/productcat/changeStatus/'+proCatId).then(function (res) {
                $("#successToast .text-toast").text("Đã lưu thay đổi")
                $("#successToast").toast("show") //hiển thị thông báo thành công
        })
    }
});