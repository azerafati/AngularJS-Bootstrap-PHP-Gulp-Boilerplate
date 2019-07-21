app.controller('userPageCtrl', ['$scope', 'API', 'bsModal', '$routeParams', 'UserService', function ($scope, API, bsModal, $routeParams, UserService) {

    $scope.user_id = $routeParams.id;

    function getUser() {
        API.get('user/get', {id: $scope.user_id}).then(function (user) {
            $scope.user = user;
            $scope.loaded = true;
            $scope.user.profileImage = UserService.profileImage(user);

        });
    }

    getUser();

    $scope.edit = function () {
        bsModal.show({
            controller: 'userModalCtrl',
            templateUrl: '/assets/admin/app/user/userModal.html',
            locals: {user: angular.copy($scope.user)}
        }).then(function (result) {
                getUser();
            }
        )
    };


    $scope.editUser = function (property, val) {
        $scope.loading = true;
        return API.post('user/edit', {
            id: $scope.user.id,
            val: val || $scope.user[property],
            property: property
        }).then(function () {
            getUser();
        }).catch(function () {
            toast.error('خطا');
        }).finally(function () {
            $scope.loading = false;
        });
    };


    $scope.changePassword = function () {
        bsModal.show({
            controller: 'userPassModalCtrl',
            templateUrl: '/assets/admin/app/user/userPassModal.html',
            locals: {user: $scope.user}
        });
    };


}]);