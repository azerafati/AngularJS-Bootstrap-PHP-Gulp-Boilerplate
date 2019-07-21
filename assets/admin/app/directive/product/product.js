app.directive('product', ['$timeout',function ($timeout) {
    return {
        restrict: "E",
        scope: {
            p: '=ngModel',
        },
        templateUrl: '/assets/app/directive/product/product.html',
        link: function link(scope, element, attrs, controller, transcludeFn) {
            $timeout(function () {
                element.find('.product-pic a:not(.show)').each(function (i, elm) {
                    $('<img/>').load(function () {
                        $(this).remove();
                        $(elm).css('background-image', 'url(' + $(elm).data('src') + ')').addClass('show');
                    }).attr('src', $(elm).data('src'));

                });
            },1);
        }
    }
}]);