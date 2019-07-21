app.controller('listCtrl', ['$scope', 'API', '$timeout', 'ProductService', 'CartService', function ($scope, API, $timeout, ProductService, CartService) {

    ProductService.loadProducts({
        sort: 2, psize: 24
    }).then(function (res) {
        $scope.products = res.content;
        $scope.productsLoad = true;
    });


    $scope.addToCart = CartService.addToCart;

}]);

