app.directive('tdInput', ['$timeout', function ($timeout) {
    return {
        restrict: "A",
        template: '\
        <span class="remove-btn" ng-if="showRemove" ng-click="remove()">×</span>\
        <div class="form-group p-0 m-0" >\
                        <input type="{{type?type:\'text\'}}" step="{{step||1}}" ng-model="model" ng-model-options="{ debounce: 800 }" class="form-control input-sm" ng-change="updateModel(model)" ng-min="{{ngMin}}" ng-disabled="ngDisabled" placeholder="{{placeholder}}"/>\
                        </div>\
                    ',
        scope: {
            model: "=ngModel",
            ngDisabled: "=ngDisabled",
            ngChange: "&ngChange",
            type: "@",
            placeholder: "@",
            step: "@",
            remove: "&",
            showRemove: "@remove",
            ngMin: "@ngMin"
        },
        link: function (scope, element, attrs) {
            scope.updateModel = function (input) {
                scope.model = input;
                scope.$apply();
                scope.ngChange();
            }
        }

    };
}]);