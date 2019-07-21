app.controller('dashboardTotalsCtrl', ['$scope', 'API', function ($scope, API) {

    API.get('accounting/totals').then(function (res) {
        $scope.totals = res;
        $scope.loaded = true;
    });


}]);