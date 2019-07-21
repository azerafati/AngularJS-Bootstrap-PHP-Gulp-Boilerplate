app.controller('userModalCtrl', ['$scope', 'API', 'bsModal', 'user', 'UserService', 'toast', function ($scope, API, bsModal, user, UserService, toast) {

    $scope.user = user;

    if (user.id)
        API.get('user/get', {id: user.id}).then(function (user) {
            $scope.user = user;
            $scope.loaded = true;
            $scope.user.profileImage = UserService.profileImage(user);
        });
    $scope.save = function (user) {
        user.tel = app.toEnglishDigits(user.tel.replace(/ /g, '').replace('+98', '0').trim());
        $scope.loading = true;
        API.post('user/save',
            user
        ).then(function (res) {
            bsModal.hide();

        }).catch(function (reason) {
            toast.error('خطایی رخ داد لطفا چک کنید همه موارد درست وارد شده باشد.');
        }).finally(function () {
            $scope.loading = false;
        });
    };
    API.get('userGroup/loadAll').then(function (groups) {
        $scope.groups = groups;
    });


    $scope.user.profileImage = UserService.profileImage(user);

    $scope.editImg = function () {
        bsModal.show({
            templateUrl: '/assets/admin/app/user/img-modal/user-img.html',
            controller: 'userImageCtrl',
            locals: {img: $scope.user.profileImage, canvas: $scope.user.img}
        }).then(function (canvas) {
            if (canvas) {
                $scope.userEditForm.$setDirty();
                $scope.user.img = canvas;
            } else {
                if (img.removed) {
                    $scope.user.img = null;
                }
            }
        });
    };


}]);