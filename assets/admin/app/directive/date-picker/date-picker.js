app.directive('datePicker', ['$timeout', function ($timeout) {
    return {
        restrict: "E",
        require: 'ngModel',
        template: '<div class="input-group mb-3 ltr">\n    <input type="text" class="form-control" placeholder="">\n    <div class="input-group-append">\n        <input data-id="date" hidden class="d-none"/>\n        <button class="btn btn-outline-secondary" type="button">\n            <svg class="icon">\n                <use xlink:href="#svg-calendar_ico"></use>\n            </svg>\n        </button>\n    </div>\n' +
            '</div>',
        scope: {
            disableBeforeDate: "=",
            disableAfterDate: "=",
            format: "@",
            timePicker: "=",
        },
        link: function link($scope, element, attrs, controller, transcludeFn) {


            var date = controller.$viewValue ? new Date(controller.$viewValue) : null;
            var options = {
                selectedDate: date,
                targetTextSelector: element.find('.form-control'),
                targetDateSelector: element.find('[data-id="date"]'),
                dateFormat: 'yyyy-MM-dd HH:mm:ss',
                textFormat: $scope.format || 'yyyy/MM/dd HH:mm',
                enableTimePicker: $scope.timePicker === undefined ? true : $scope.timePicker,
                yearOffset: 40,
                //disableBeforeDate: $scope.disableBeforeDate ? new Date($scope.disableBeforeDate) : undefined,
                //disableAfterDate: $scope.disableAfterDate ? new Date($scope.disableAfterDate) : undefined
            };

            element.find("button").popover('dispose').azPersianDateTimePicker(options);
            controller.$render = function () {
                if (controller.$viewValue && moment(controller.$viewValue).isValid()) {
                    element.find("button").azPersianDateTimePicker('setDate', new Date(controller.$viewValue));
                } else if (controller.$viewValue == null) {
                    element.find("button").azPersianDateTimePicker('clearDate');
                }
            };


            $scope.$watch('disableAfterDate', function () {
                if ($scope.disableAfterDate)
                    element.find("button").azPersianDateTimePicker('setOption', 'disableAfterDate', new Date($scope.disableAfterDate));
            });

            $scope.$watch('disableBeforeDate', function () {
                if ($scope.disableBeforeDate)
                    element.find("button").azPersianDateTimePicker('setOption', 'disableBeforeDate', new Date($scope.disableBeforeDate));
            });

            element.find('[data-id="date"]').change(function () {
                controller.$setViewValue($(this).val() || null);
            });


        }
    }
}]);