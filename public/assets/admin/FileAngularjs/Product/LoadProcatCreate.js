

productApp.controller("ProductController", ProductController)
function ProductController($scope, $http) {
    $scope.Oject = "Nam"
    $scope.TopMenu = function (Oject) {
        $http.get("/admin/category/getByType/" + Oject).then(function (res) {
            $scope.listCategoryByType = res.data
            $scope.CategoryByType = JSON.stringify($scope.listCategoryByType[0])
            $scope.listProCatByCat = $scope.listCategoryByType[0].product_cats
        }, function (error) {
            alert("Lỗi khi tải dữ liệu")
        })
    }

    $scope.renderProcat = function () {
        //vì đặt ở value nên giá trị truyền vào là chuỗi
        //lấy danh sách procat của cat vừa chọn
        $scope.listProCatByCat = JSON.parse($scope.CategoryByType).product_cats
    }

    $scope.TopMenu("Nam")
}
