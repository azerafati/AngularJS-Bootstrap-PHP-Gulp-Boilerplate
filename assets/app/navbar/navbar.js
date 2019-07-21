app.controller('navbarCtrl', ['$scope', '$timeout', 'UserService', 'AuthService', function ($scope, $timeout, UserService, AuthService) {

    $scope.curDate = new Date();
    UserService.getUser().then(function (user) {
        $scope.user = user;
        $scope.loaded = true;
    });
    $scope.$on('login', function (e, user) {
        $scope.user = user;
        $scope.loaded = true;
    });

    $scope.hasPermission = AuthService.hasPermission;

}]);