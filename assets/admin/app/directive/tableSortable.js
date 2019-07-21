app.directive('tableSortable', ['$compile', function ($compile) {
    return {
        restrict: "A",
        scope: {
            pg: '=tableSortable'
        },
        isolateScope:false,

        link: function (scope, element, attr) {

            element.find('th[th-sortable]').click(function (e) {
                e.stopPropagation();
                var sort_id = +$(this).attr('th-sortable');
                if (Math.abs(scope.pg.sort_id) == sort_id) {
                    sort_id = - scope.pg.sort_id;
                }
                scope.pg.sort(sort_id);
                scope.$apply();
            }).each(function (i, th) {
                $(th).append('<svg class="up" ><use xlink:href="#svg-caret-up"></use></svg>' +
                    '<svg class="down" ><use xlink:href="#svg-caret-down"></use></svg>');
            });


            scope.$watch('pg.sort_id', function () {
                if(scope.pg)
                element.find('th[th-sortable]').removeClass('up down').each(function (i, th) {
                    if (Math.abs(scope.pg.sort_id) == (+$(th).attr('th-sortable'))) {
                        $(th).addClass(scope.pg.sort_id < 0 ? 'up' : 'down');
                    }

                })
                // element.removeClass('up down');
                // if (Math.abs(scope.$parent.pg.sort_id) == attr.thSortable) { element.addClass(scope.$parent.pg.sort_id > 0 ? 'up' : 'down'); }
            });

        }
    };
}]);