app.controller('productCtrl', ['$scope', 'API', '$timeout', 'ProductService', '$sce', '$routeParams', 'CartService', function ($scope, API, $timeout, ProductService, $sce, $routeParams, CartService) {
    $scope.product = ProductService.getCache($routeParams.rid);
    if ($scope.product) {
        $scope.loaded = true;
        if ($scope.product.info && !$scope.product.infoHtml) {
            $scope.product.infoHtml = $sce.trustAsHtml($scope.product.info);
        }
    }
    ProductService.loadProduct($routeParams.rid).then(function (product) {
        $scope.product = product;
        $scope.product.infoHtml = $sce.trustAsHtml($scope.product.info);
        $scope.loaded = true;

        $scope.cats = product.cats;
        $scope.page = product.page;
        $timeout(function () {
            app.carousel($('#prodSlider'));
        });
        $scope.$broadcast('comment',{product_id:product.rndurl});
    });

    $scope.addToCart = CartService.addToCart;

    $scope.getImgs = ProductService.getImages;

    $scope.copy = function (text) {

        var textArea = document.createElement("textarea");

        // Place in top-left corner of screen regardless of scroll position.
        textArea.style.position = 'fixed';
        textArea.style.top = 0;
        textArea.style.left = 0;

        textArea.value = text;

        document.body.appendChild(textArea);

        textArea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
        } catch (err) {
            console.log('unable to copy');
        }

        document.body.removeChild(textArea);
    };




}]);

