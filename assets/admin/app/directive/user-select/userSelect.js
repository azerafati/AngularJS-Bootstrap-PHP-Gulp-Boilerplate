app.directive('userSelect', ['API', '$parse', 'bsModal', function (API, $parse, bsModal) {
    return {
        restrict: "E",
        require: 'ngModel',
        templateUrl: '/assets/admin/app/directive/user-select/userSelect.html',
        scope: {
            ngDisabled: "=ngDisabled",
            type: "@",
            placeholder: "@",
            step: "@",
            remove: "&",
            showRemove: "@remove",
            ngMin: "@ngMin",
            userObject: "=?user",
        },
        link: function ($scope, element, attrs, ctrl) {
            $scope.loading = true;
            var filterQuery = {psize: 15};
            var filter = $parse(attrs.filter)($scope);
            angular.extend(filterQuery, filter);


            var lastSearch = '';
            $scope.searchUsers = function (search) {
                if (lastSearch === search) return;
                lastSearch = search;
                $scope.loading = true;
                filterQuery.search = search;
                API.page('user', filterQuery).then(function (res) {
                    $scope.users = res.content;
                    $scope.loading = false;
                });
            };
            $scope.setUser = function (user) {
                //user.name = user.name || (user.fname + " " + user.lname);
                $scope.user = user;
                $scope.userObject = user;
                if (user && user.id) ctrl.$setViewValue(user.id);
                $scope.loading = false;
            };
            $scope.new = function () {
                bsModal.show({
                    controller: 'userModalCtrl',
                    templateUrl: '/assets/admin/app/user/userModal.html',
                    locals: {user: {}}
                }).then(function (result) {
                    if (result.id) {
                        $scope.setUser(result);
                    }
                })
            };

            ctrl.$render = function () {   //  Add $render
                if (ctrl.$viewValue) {
                    //if we have an id let's get it from server
                    if ($scope.userObject) {
                        $scope.user = $scope.userObject;
                    } else {
                        API.get('user/get', {id: ctrl.$viewValue}).then(function (u) {
                            $scope.setUser(u);
                        });
                    }
                } else {
                    $scope.setUser(undefined);
                }
            };

            if ($(element).hasClass('input-sm')) {
                $(element).find(".btn").addClass("btn-sm");
            }
        }

    };
}]);