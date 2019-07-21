/**
 * Created by alireza on 10/28/17.
 */
app.directive('chkAll', [function () {
    return {
        restrict: "E",
        transclude: true,
        scope: {
            chkService: '=chkService',
            name: '@name',
        },
        //language=HTML
        template: '<div class="btn-group btn-group-sm" role="group">\n    <div class="btn-group btn-group-sm" role="group">\n        <button class="btn btn-light dropdown-toggle rtl" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n            <span class="custom-control-description fade" ng-class="{show:chkService.getSelectedItems().length}">{{chkService.getSelectedItems().length}} {{name}}</span>\n        </button>\n        <div class="dropdown-menu" ng-show="chkService.getSelectedItems().length">\n            <ng-transclude></ng-transclude>\n        </div>\n    </div>\n    <button type="button" class=" btn btn-sm btn-light chk-all" ng-click="chkService.toggleAll()">\n        <svg>\n            <use xlink:href="#svg-checkbox_empty" ng-href="#{{chkService.isChecked()?\'svg-checkbox_checked\':\'svg-checkbox_empty\'}}" ></use>\n        </svg>\n    </button>\n</div>             ',
        // link:function (scope) {
        //     scope.chkService = scope.$parent.chkService;
        //
        // }
    }
}]);
