app.controller('menuCtrl', ['$scope', 'API', '$timeout', 'UserService', function ($scope, API, $timeout, UserService) {

    API.get('menu/load').then(function (res) {
        $scope.categories = res;
        $scope.load = true;
        $timeout(function () {
            $('.nav-dropdown-menu').click(function () {
                var clickedMenu = $(this).css({'pointer-events': 'none'});

                setTimeout(function () {
                    clickedMenu.css({'pointer-events': 'initial'});
                }, 1000);
            });

        }, 100);
    });

    $scope.curDate = new Date();
    UserService.getUser().then(function (user) {
        $scope.user = user;
    });
    $scope.$on('login', function (e, user) {
        $scope.user = user;
    });

}]);