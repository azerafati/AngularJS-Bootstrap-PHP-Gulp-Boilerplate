app.controller('logListCtrl', ['$scope', 'API', 'bsModal', 'CheckBoxService', 'CategoryService', 'toast', function ($scope, API, bsModal, CheckBoxService, CategoryService, toast) {

    $scope.logs = [];

    $scope.pg = API.pager(function () {
        $scope.loaded = false;
        API.page('log').then(function (res) {
            $scope.logs = res.content;
            $scope.pg.sync(res.page, $scope);
            $scope.loaded = true;
            $scope.chkService = new CheckBoxService($scope.logs);
        });
    });

    $scope.pg.load();


    $scope.show = function (log) {
        bsModal.show({
            controller: 'logModalCtrl',
            templateUrl: '/assets/admin/app/log/logModal.html',
            locals: {log: angular.copy(log)}
        }).then(function (result) {
                $scope.pg.load();
            }
        )
    };


    $scope.remove = function () {
        if ($scope.chkService.getSelectedItems().length) {
            CategoryService.selectCategories([]).then(function (cats) {
                bsModal.confirm("بله", "آیا از دسته های محصول انتخاب شده اطمینان دارید؟ ").then(function () {
                    API.post("log/remove", {
                        ids: $scope.chkService.getSelectedItems(),
                        val: cats,
                        property: 'categories'
                    }).then(function (res) {
                        toast.show('انجام شد!');
                        $scope.chkService.toggleAll();
                        $scope.pg.load();
                    })
                });
            });
        }
    };

    $scope.getLevel = function (level) {
        switch (+ level) {
            case 1:
                return {color: 'blue', title: 'خطایابی'};
                break;
            case 2:
                return {color: 'green', title: 'اطلاعات'};
                break;
            case 3:
                return {color: 'darkkhaki', title: 'اخطار'};
                break;
            case 4:
                return {color: 'orange', title: 'خطا'};
                break;
            case 5:
                return {color: 'red', title: 'مشکل جدی'};
                break;
        }
    };

}]);