app.controller('signupCtrl', ['$scope', 'API', '$timeout', 'UserService', '$location', 'bsModal', function ($scope, API, $timeout, UserService, $location, bsModal) {


    UserService.getUser().then(function () {
        if (UserService.isSignedIn()) {
            $location.path('/');
        }
    });

    $scope.newuser = {};

//Escape the special chars
    $scope.getPattern = function () {
        return $scope.newuser.pass &&
            $scope.newuser.pass.replace(/([.*+?^${}()|\[\]\/\\])/g, '\\$1');
    };

    $scope.signup = function () {
        // check to make sure the form is completely valid
        if ($scope.signupForm.$valid) {
            $scope.loading = true;
            API.post('signup', $scope.newuser).then(function (res) {
                location.reload();
            }, function (res) {
                var msg = 'لطفا یک بار دیگر تلاش کنید';
                switch (res.data) {
                    case 1:
                        msg = 'شماره موبایل وارد شده صحیح نیست';
                        break;
                    case 2:
                        msg = 'رمز عبوری که وارد کرده اید خیلی کوتاه است و یا صحیح نیست، لطفا دوباره تلاش کنید';
                        break;
                    case 3:
                        msg = 'این شماره قبلا در سیستم ثبت شده است لطفا از قسمت ورود استفاده کنید';
                        break;
                }

                bsModal.alert(msg, "خطا");

            }).finally(function () {
                $scope.loading = false;
            });
        }
    };


}]);



