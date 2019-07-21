app.controller('userPassModalCtrl', ['$scope', 'API', 'bsModal', 'user', 'ProductService', 'toast', function ($scope, API, bsModal, user, ProductService, toast) {

    $scope.user = user;
    $scope.save = function (user) {

        $scope.loading = true;
        API.post('user/chgPass',
            {id: user.id, pass: $scope.password}
        ).then(function (res) {
            toast.show('رمز جدید با موفقیت ثبت شد.');
            bsModal.hide();
        }).catch(function (reason) {
            toast.error('خطایی رخ داد لطفا چک کنید همه موارد درست وارد شده باشد.');
        }).finally(function () {
            $scope.loading = false;
        });
    }


}]);