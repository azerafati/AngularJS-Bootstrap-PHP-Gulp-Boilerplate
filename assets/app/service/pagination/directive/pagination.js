app.directive('pagination', ['$compile', function ($compile) {
    return {
        restrict: "E",
        templateUrl: '/assets/admin/app/service/pagination/directive/pagination.html',

        link: function (scope, element, attr) {
            //{number: 1, size: 30, total: 269}
            scope.$on('page', function (e,page) {
                scope.page = page;
                scope.pages = Math.ceil(page.total / page.size);
                scope.gotToPage = function (number) {
                    page.goToPage(number);
                }
            });
        }
    };
}]);