var PostApp = angular.module("PostApp", []);

PostApp.controller("PostController", function ($scope, $http) {

    $scope.setFile = function(element) {
        $scope.$apply(function() {
            $scope.myFile = element.files[0];
        });
    };

    //khi người dung nhấn lưu thêm mới danh mục
    $scope.SaveAdd = function (closeOrPost) {
        $scope.Post.Content = CKEDITOR.instances['Content'].getData();
        if ($scope.createForm.$valid) {
            let formData = new FormData();
            if($scope.myFile!=undefined){
                formData.append('file', $scope.myFile);
            }
            formData.append('UserID',$scope.Post.UserID)
            formData.append('Title',$scope.Post.Title)
            formData.append('Content',$scope.Post.Content)
            //hiển thị thông báo thành công
            $("#successToast .text-toast").text("Thêm bài viết thành công")
            $("#successToast").toast("show")
            location.href = "/admin/post"
            $http.post("/admin/post/create",formData,{
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (res) {
                if (res.data.check) //tạo mới thành công
                {
                    //hiển thị thông báo thành công
                    $("#successToast .text-toast").text("Thêm bài viết thành công")
                    $("#successToast").toast("show")
                    location.href = "/admin/post"
                }
                else {
                    $("#errorToast .text-toast").text("Thêm thất bại")
                    $("#errorToast").toast("show")
                }
            })
        }

    }

});