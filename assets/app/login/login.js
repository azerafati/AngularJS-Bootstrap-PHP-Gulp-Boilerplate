app.controller('loginCtrl', ['$scope', 'API', '$timeout', 'UserService', '$location', function ($scope, API, $timeout, UserService, $location) {


    UserService.getUser().then(function () {
        if (UserService.isSignedIn()) {
            $location.path('/').replace();
        }
    });


    $scope.submit = function (e) {
        // check to make sure the form is completely valid
        e.preventDefault();
        e.stopPropagation();
        if ($scope.loginForm.$valid) {
            $scope.loading = true;
            /*            API.post('user/login', $scope.user).then(function (res) {
                            location.reload();
                        }, function (res) {
                            switch (res.data) {
                                case 1:
                                    az.alert("error", " شماره وارد شده اشتباه است. لطفا یک بار دیگر تلاش کنید ", "خطا  ");
                                    break;
                                case 3:
                                    az.alert("error", "رمز عبور وارد شده اشتباه است. لطفا یک بار دیگر تلاش کنید و یا اگر فراموش کرده اید، از گزینه فراموش کردن رمز استفاده کنید", "خطا");
                                    break;
                            }
                            $scope.loading = false;
                        })*/
            UserService.userlogin($scope.user).then(function (res) {
                if ($location.search().r) {
                    window.location.replace($location.search().r)
                } else {
                    $location.path('/').replace();
                }
            }).catch(function (res) {
                switch (res.data.err) {
                    case 'WRONG_PASSWORD':
                        $scope.wrong_password = true;
                        $scope.loginForm.password.$invalid = true;
                        break;
                    case '1WRONG_PASSWORD':
                        toast.error('این شماره قبلا در سیستم ثبت شده لطفا از صفحه ورود استفاده کنید');
                        break;
                    default:
                        window.location.reload();
                        break;
                }
            }).finally(function () {
                $scope.loading = false;
            });


        }
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
                        msg = 'شما قبلا ثبت نام کرده اید لطفا از قسمت ورود استفاده کنید';
                        break;
                }

                az.alert("error", msg, "خطا");
                $scope.loading = false;
            });
        }
    };


    $scope.forgot = function () {
        // check to make sure the form is completely valid
        if ($scope.forgotForm.$valid) {
            $scope.loading = true;
            API.post('forgot', {tel: $scope.user.tel}).then(function (res) {
                $scope.loading = false;
                $('<a href="#changepass" data-toggle="tab">').tab('show');
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
                        msg = 'شما قبلا ثبت نام کرده اید لطفا از قسمت ورود استفاده کنید';
                        break;
                }
                az.alert("error", msg, "خطا");
                $scope.loading = false;
            });
        }
    };


    $scope.changepass = function () {
        // check to make sure the form is completely valid
        if ($scope.changepassForm.$valid) {
            $scope.loading = true;
            API.post('change-pass', {tel: $scope.user.tel, pass: $scope.pass1, pin: $scope.pin}).then(function (res) {
                location.reload();
            }, function (res) {
                var msg = 'لطفا یک بار دیگر تلاش کنید';
                switch (res.data) {
                    case 1:
                        msg = 'کد وارد شده صحیح نیست';
                        break;
                    case 2:
                        msg = 'رمز عبوری که وارد کرده اید خیلی کوتاه است و یا صحیح نیست، لطفا دوباره تلاش کنید';
                        break;
                }
                az.alert("error", msg, "خطا");
                $scope.loading = false;
            });
        }
    };


    $scope.turnofftab = function () {
        $('.nav-tabs li.active').removeClass('active');
    }


    $timeout(function () {


        $('input[name="u"]').keydown(function () {
            $('input[name="p"]').val('');
        });

        $('form[name="loginForm"] input:first').trigger("focus");


    }, 1);


}]);



