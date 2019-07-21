app.controller('onlineUsersCtrl', ['$scope', 'API', function ($scope, API) {

    $scope.pg = API.pager(function () {
        $scope.loading = true;
        API.page('user', {psize: 7, sort: 3}).then(function (res) {
            $scope.users = res.content;
            $scope.users.forEach(function (user) {
                switch (user.marital_status) {
                    case "SINGLE":
                        user.marital_status_fa = "مجرد";
                        break;
                    case "MARRIED":
                        user.marital_status_fa = "متاهل";
                        break;
                    case "DIVORCED":
                        user.marital_status_fa = "مطلقه";
                        break;
                }
            });
            $scope.loaded = true;
            $scope.loading = false;
        });
    });
    $scope.pg.load();


}]);