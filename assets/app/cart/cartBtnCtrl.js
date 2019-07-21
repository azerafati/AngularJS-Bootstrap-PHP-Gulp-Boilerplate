app.controller('cartBtnCtrl', ['$scope', 'API','CartService',function($scope, API,CartService) {

    CartService.getCart().then(function (cart) {
        $scope.cart = cart;
    });

    $scope.$on('cart', function() {
        CartService.getCart().then(function (cart) {
            $scope.cart = cart;
        });

    });

}]);

