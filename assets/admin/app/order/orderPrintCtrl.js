app.controller('orderPrintCtrl', ['$scope', 'API', 'order', 'ProductService', 'print', 'showImages', function ($scope, API, order, ProductService, print, showImages) {

    $scope.order = order;
    $scope.curDate = new Date();
    $scope.showImages = showImages;
    setTimeout(function () {
        print();
    }, 200);

}]);