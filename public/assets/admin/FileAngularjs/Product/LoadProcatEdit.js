

productApp.controller("ProductController", ProductController)
function ProductController($scope, $http) {
    $scope.TopMenu = function (Oject) {
        $http.get("/admin/category/getByType/" + Oject).then(function (res) {
            $scope.listCategoryByType = res.data
            $scope.CategoryID = JSON.stringify($scope.listCategoryByType[0].CatID)
            $scope.listProCatByCat = $scope.listCategoryByType[0].ProductCats
            $scope.ProCaId = JSON.stringify($scope.listProCatByCat[0].ProCatId)
        }, function (error) {
            alert("Lỗi khi tải dữ liệu")
        })
    }
    let proCatId = $(".main").attr("data-idProCat")
    $http.get("/admin/productcat/getById/" + proCatId).then(function (res) {
        let Procat = res.data
        $scope.Oject = Procat.category.type
        $http.get("/admin/category/getByType/" + $scope.Oject).then(function (res) {
            $scope.listCategoryByType = res.data
            $scope.CategoryID = JSON.stringify(Procat.category.CatID)
            for (let i = 0; i < $scope.listCategoryByType.length; i++) {
                if ($scope.listCategoryByType[i].CatID === Procat.category.CatID) {
                    $scope.listProCatByCat = $scope.listCategoryByType[i].product_cats
                    $scope.ProCaId = JSON.stringify(Procat.ProCatId)
                    break
                }
            }
            
        }, function (error) {
            alert("Lỗi khi tải dữ liệu")
        })
    })



    $scope.renderProcat = function () {
        //vì đặt ở value nên giá trị truyền vào là chuỗi
        //lấy danh sách procat của cat vừa chọn
        for (let i = 0; i < $scope.listCategoryByType.length; i++) {
            if ($scope.listCategoryByType[i].CatID == $scope.CategoryID) {
                $scope.listProCatByCat = $scope.listCategoryByType[i].product_cats
                $scope.ProCaId = JSON.stringify($scope.listProCatByCat[0].ProCatId)
                break
            }
        }

    }

}
