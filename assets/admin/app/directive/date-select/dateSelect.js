app.directive('dateSelect', [function () {
    return {
        restrict: "E",
        templateUrl: '/assets/admin/app/directive/date-select/dateSelect.html',
        scope: {
            model: "=ngModel",
            ngDisabled: "=ngDisabled",
            ngChange: "&ngChange",
            type: "@",
            placeholder: "@",
            step: "@",
            remove: "&",
            showRemove: "@remove",
        },
        link: function ($scope, element, attrs) {


            $scope.setDate = function (oDay, oMonth, oYear) {
                var date = moment('13' + oYear + '/' + oMonth + '/' + oDay, 'jYYYY/jMM/jDD');
                $scope.date = date;
                $scope.model = date.format('YYYY-MM-DD HH:mm:ss');
            };

            if ($scope.model) /*if we have a date let's set it*/ {
                var date = moment($scope.model);
                $scope.date = date;
                $scope.oDay = date.format('jDD');
                $scope.oMonth = date.format('jMM');
                $scope.oYear = date.format('jYY');

            }else {
                var date = moment();
                $scope.oDay = date.format('jDD');
                $scope.oMonth = date.format('jMM');
                $scope.oYear = date.format('jYY');
            }


        }

    };
}]);