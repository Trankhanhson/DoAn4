
ClientApp.controller("OutletController", OutletController);

function OutletController($scope, $http) {
    $scope.Object = 'All'
    $scope.MinMoney = 99000
    $scope.MaxMoney = 149000

    $scope.getData = function () {
        /** Lấy danh sách category*/
        $http.get("/client/outlet/FilterOutlet", {
            params: { o: $scope.Object, minMoney: $scope.MinMoney, maxMoney: $scope.MaxMoney }
        }).then(function (res) {
            $scope.listOutlet = res.data
        }, function (error) {
            alert("failed")
        })
    }

    $scope.getData()

    $scope.changeObject = function (o) {
        $scope.Object = o
        $scope.getData()
    }

    $scope.changeMoney = function (minMoney, maxMoney) {
        $scope.MinMoney = minMoney
        $scope.MaxMoney = maxMoney
        $scope.getData()
    }

    $scope.addActive = function (e) {
        let parent = $(e.target).parents(".product-size-wrap")
        let listItem = $(parent).find(".product-size")
        $(listItem).removeClass("active")
        $(e.target).addClass("active")
    }
}