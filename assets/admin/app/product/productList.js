app.controller('productListCtrl', ['$scope', 'API', 'bsModal', 'CheckBoxService', 'CategoryService', 'toast', 'ProductService', function ($scope, API, bsModal, CheckBoxService, CategoryService, toast, ProductService) {

    $scope.products = [];
    for (var i = 0; i < 30; i++) {
        $scope.products.push({id:i+'tmp'});
    }

    $scope.pg = API.pager(function () {
        $scope.loaded = false;
        API.page('product').then(function (res) {
            res.content.forEach(function (product) {

                product.link = ProductService.getLink(product);
                product.img = ProductService.getImage(product);

            });
            $scope.products = res.content;
            $scope.pg.sync(res.page,$scope);
            $scope.loaded = true;
            $scope.chkService = new CheckBoxService($scope.products);
        });
    });

    $scope.pg.load();


    $scope.edit = function (product) {
        bsModal.show({
            controller: 'productModalCtrl',
            templateUrl: '/assets/admin/app/product/productModal.html',
            locals: {product: angular.copy(product)}
        }).then(function (result) {
                if (result > 0) $scope.pg.load();
            }
        )
    };


    $scope.selectCategories = function () {
        if ($scope.chkService.getSelectedItems().length) {
            CategoryService.selectCategories([]).then(function (cats) {
                bsModal.confirm("بله", "آیا از دسته های محصول انتخاب شده اطمینان دارید؟ ").then(function () {
                    API.post("product/edit", {ids: $scope.chkService.getSelectedItems(), val: cats, property: 'categories'}).then(function (res) {
                        toast.show('انجام شد!');
                        $scope.chkService.toggleAll();
                        $scope.pg.load();
                    })
                });
            });
        }
    };


}]);