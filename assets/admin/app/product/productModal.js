app.controller('productModalCtrl', ['$scope', 'API', 'bsModal', 'product', 'ProductService', 'CategoryService', '$http', function ($scope, API, bsModal, product, ProductService, CategoryService, $http) {

    $scope.product = product;

    if (product.id) {
        ProductService.loadProduct(product.id).then(function (product) {
            $scope.product = product;
            $scope.loaded = true;
        });
    } else {
        $scope.product.is_wholesale = false;
        $scope.product.production_status = 'IN_PRODUCTION';
    }


    $scope.selectCategory = function () {
        CategoryService.selectCategories($scope.product.categories).then(function (cats) {
            $scope.product.categories = cats;
            $scope.product_form.$setDirty();
        });
    };

    $scope.save = function (product) {
        $scope.loading = true;
        product.purchase_price = app.toEnglishDigits(product.purchase_price);
        product.price = app.toEnglishDigits(product.price);
        product.old_price = app.toEnglishDigits(product.old_price);
        product.wholesale_price = app.toEnglishDigits(product.wholesale_price);
        product.stock = app.toEnglishDigits(product.stock);
        product.weight = app.toEnglishDigits(product.weight);

        API.post('product/save',
            product
        ).then(function (res) {
            var images = $('#imgFiles')[0].files;
            if (images.length) {
                var fd = new FormData();
                var $i = 0;
                angular.forEach($('#imgFiles')[0].files, function (file) {
                    fd.append($i, file);
                    $i++;
                });
                fd.append('id', res.id);
                fd.append('watermark', product.watermark);
                //product.files = ;
                $http.post('api/product/saveImg',
                    fd
                    , {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    }).then(function (res) {
                    $('#imgFiles')[0].value = '';
                    bsModal.hide(1);
                });
            } else {

                $('#imgFiles')[0].value = '';
                bsModal.hide(1);
            }

        });
    }

}]);