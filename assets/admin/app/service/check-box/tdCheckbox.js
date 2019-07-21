app.directive('tdCheckbox', [function () {
    return {
        restrict: "A",
        scope: {
            chkService: '=tdCheckbox',
            id: '@id',
            index: '@index',
        },
        replace: true,
        template: '<td class="" ng-click="chkService.toggle(+id)"> <svg><use xlink:href="#svg-checkbox_empty" ng-href="#{{chkService.exists(+id)?\'svg-checkbox_checked\':\'svg-checkbox_empty\'}}" ></use></svg> - {{+index + 1}}</td> ',
    }
}]);