/**
 * Created by alireza on 10/28/17.
 */
app.directive('searchToolbar',[function () {
    return {
        restrict:"E",
        template:'<form ng-submit="pg.filter();blur();">\n    <div class="input-group input-group-sm">\n        <div class="input-group-prepend">\n            <button class="btn btn-outline-dark" type="submit">\n                <svg class="icon">\n                    <use xlink:href="#svg-search"></use>\n                </svg>\n            </button>\n        </div>\n        <input type="text" class="form-control rtl" ng-model="pg.filterForm.search" ng-change="pg.filter()" placeholder="جستجو ..." ng-model-options="{ debounce: 600 }">\n    </div>\n</form>',
        link:function (scope,element) {
            scope.blur=function () {
                element.find('input').blur();
            }
        }
    }
}]);
