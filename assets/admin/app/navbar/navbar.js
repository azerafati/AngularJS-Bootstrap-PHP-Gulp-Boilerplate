app.controller('navbarCtrl', ['$scope', '$timeout', 'UserService', function ($scope, $timeout, UserService) {



    $scope.curDate = new Date();
    UserService.getUser().then(function (user) {
        $scope.user = user;
    });
    $scope.$on('login', function (e, user) {
        $scope.user = user;
    });



}]);