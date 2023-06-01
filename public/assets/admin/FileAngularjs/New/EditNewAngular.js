var PostApp = angular.module("PostApp", []);

PostApp.controller("PostController", function ($scope, $http) {
    let content = $("#Content-wrap p").text()
    CKEDITOR.instances['Content'].setData(content);

    $scope.setFile = function(element) {
        $scope.$apply(function() {
            $scope.myFile = element.files[0];
        });
    };


    /** Sửa danh mục*/
    $scope.SaveEdit = function () {
        if ($scope.editForm.$valid) {
            $scope.Post.Content = CKEDITOR.instances['Content'].getData();
            //nếu upload file mới thì gán tên file mới vào proCat
            let editImage = false
            let formData = new FormData();
            if($scope.myFile!=undefined){
                formData.append('file', $scope.myFile);
                editImage = true
            }
            formData.append('UserID',$scope.Post.UserID)
            formData.append('Title',$scope.Post.Title)
            formData.append('Content',$scope.Post.Content)
            location.reload()
            $("#successToast .text-toast").text("Sửa bài viết thành công")
            $("#successToast").toast("show") //hiển thị thông báo thành công
            $http.post("/admin/post/update/"+$scope.Post.PostId,formData,{
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (res) {
                if (res.data.check === true) //nếu update thành công
                {
                    //upload ảnh khi update thành công
                    location.reload()
                    $("#successToast .text-toast").text("Sửa bài viết thành công")
                    $("#successToast").toast("show") //hiển thị thông báo thành công
                }
                else {
                    $("#errorToast .text-toast").text("Sửa thất bại")
                    $("#errorToast").toast("show") //hiển thị thông báo thành công
                }
                $(".btn-close").trigger('click') //đóng modal sửa
            })
        }
    }


});