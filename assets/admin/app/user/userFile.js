app.controller('userFileCtrl', ['$scope', 'API', 'bsModal', '$timeout', 'UserService', function ($scope, API, bsModal, $timeout, UserService) {


    $scope.activePane = 'visits';
    $timeout(function () {
        $('#user-file a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // newly activated tab
            $scope.activePane = e.target.getAttribute('data-target').replace('#', '');
            $scope.$apply();
        })
    });

    /*UserService.getUser().then(function (user) {
        //
    });*/

}]);