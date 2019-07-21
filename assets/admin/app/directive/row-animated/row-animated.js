app.directive('rowAnimated', ['$timeout', function ($timeout) {
    return {
        restrict: "A",
        link: function link(scope, element, attrs, controller, transcludeFn) {
            $timeout(function () {
                var speed = 2000;
                var elements = $(element).children();
                elements.each(function () {
                    var elementOffset = $(this).offset();
                    var offset = elementOffset.left * 0.8 + elementOffset.top;
                    var delay = parseFloat(offset / speed).toFixed(2);
                    $(this)
                        .css("animation-delay", delay + 's')
                });
            });
        }
    }
}]);