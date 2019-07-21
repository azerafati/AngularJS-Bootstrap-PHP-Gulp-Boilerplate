app.controller('newNumbersModalCtrl', ['$scope', 'API', 'bsModal', 'UserService', 'toast', function ($scope, API, bsModal, UserService, toast) {


    $scope.relations = {};
    $scope.user = {};

    $scope.save = function (user) {

        //user.tel = app.toEnglishDigits(user.tel.replace(/ /g, '').replace('+98', '0').trim());
        $scope.user.relation = '';
        var rels = [];
        for (var key in $scope.relations) {
            if ($scope.relations[key]) rels.push(key);
        }
        $scope.user.relation = rels.join();
        $scope.loading = true;
        API.post('user/saveNumbers',
            $scope.user
        ).then(function (res) {
            toast.show('شماره ها با موفقیت ثبت شدند!');
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

    $scope.user.numbers = [];
    var re = new RegExp("^09[0-9]{9}$");
    $scope.checkNumbers = function () {
        $scope.user.numbers = [];
        var reSplit = /[,\s]/g;
        if ($scope.numbersStr)
            var numbers = $scope.numbersStr.split(reSplit);

        numbers.forEach(function (num, index) {
            if(/^9[0-9]{9}$/.test(num)){
                num ="0"+num;
            }

            if (re.test(num)) {
                $scope.user.numbers.push(num);
            } else {
                num = app.toEnglishDigits(num.replace(/ /g, '').replace('+98', '0').trim());
                if (re.test(num)) {
                    $scope.user.numbers.push(num);
                }
            }
            $scope.user.numbers;
        });

    };

}]);