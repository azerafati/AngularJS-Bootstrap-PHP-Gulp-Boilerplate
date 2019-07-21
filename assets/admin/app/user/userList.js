app.controller('userListCtrl', ['$scope', 'API', 'bsModal', 'CheckBoxService', 'toast', function ($scope, API, bsModal, CheckBoxService, toast) {

    $scope.users = [];
    for (var i = 0; i < 40; i++) {
        $scope.users.push({id:i+'tmp'});
    }
    $scope.pg = API.pager(function () {
        $scope.loading = true;
        API.page('user').then(function (res) {
            $scope.users = res.content;
            $scope.pg.sync(res.page, $scope);
            $scope.loaded = true;
            $scope.loading = false;
            $scope.chkService = new CheckBoxService($scope.users);
        });
    });
    $scope.pg.load();

    $scope.new = function () {
        bsModal.show({
            controller: 'userModalCtrl',
            templateUrl: '/assets/admin/app/user/userModal.html',
            locals: {user: {tel: ''}}
        }).then(function (result) {
                $scope.pg.load();
            }
        )
    };

    $scope.sendSMS = function () {
        if ($scope.chkService.getSelectedItems().length) {
            bsModal.show({
                controller: 'sendSmsModalCtrl',
                templateUrl: '/assets/admin/app/sms/sendSmsModal.html',
                locals: {users: $scope.chkService.getSelectedItems()}
            }).then(function (result) {
                $scope.pg.sort(1);
            });
        }
    };



}]);