app.controller('filterModalUserCtrl', ['$scope', 'API', 'bsModal', 'toast', 'pg', function ($scope, API, bsModal, toast, pg) {

    $scope.pg = pg;
    $scope.f = pg.filterForm;

    API.get('userGroup/loadAll').then(function (groups) {
        $scope.groups = groups;
    });


    $scope.submit = function () {
        bsModal.hide();
    };

    $scope.clear = function () {
        let f = pg.filterForm;
        f.start_date = null;
        f.start_date = null;
        f.end_date = null;
        f.gender = null;
        f.search = null;
        f.start_age = null;
        f.end_age = null;
        f.education = null;
        f.company = null;
        f.marital_status = null;
        $scope.filterForm.$setDirty();
    };
}]);