app.factory('PrintService', ['$timeout', '$compile', '$rootScope', '$controller', '$templateRequest', '$q', function ($timeout, $compile, $rootScope, $controller, $templateRequest, $q) {

    var startPrint = function (params) {
        var q = $q.defer();

        //  If we have provided any inputs, pass them to the controller.
        $templateRequest(params.templateUrl, true).then(function (template) {
            var $scope = $rootScope.$new();
            var compiledPrint = $compile(template)($scope);
            var locals = {
                $scope: $scope,
                print: function () {
                    $timeout(function () {
                        window.print();
                        $timeout(function () {
                            q.resolve();
                            compiledPrint.remove();
                            $scope.$destroy();
                        }, 100);
                    }, 1);
                }
            };
            if (params.locals) angular.extend(locals, params.locals);
            $controller(params.controller, locals, false);
            $('body').append(compiledPrint);
        });

        return q.promise;
    }

    return {
        print: startPrint
    }

}]);