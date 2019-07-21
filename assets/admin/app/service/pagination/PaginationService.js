app.factory('PaginationService', ['$location', function ($location) {

    function getParams(pg) {
        pg.filterForm.sort = pg.sort_id;
        pg.filterForm.p = pg.number > 1 ? pg.number : null;
        var search = pg.filterForm.search;
        return angular.merge({},pg.filterForm,{search:(search && search.length) ? app.toEnglishDigits(search) : null});
    }

    var PaginationService = function (currentPage, useLocation) {
        this.useLocation = useLocation ? true : false;
        this.number = currentPage.number;
        this.size = currentPage.size;
        this.total = currentPage.total;
        if (this.useLocation) {
            this.sort_id = + $location.search().sort || null;
            this.filterForm = $location.search();
        } else {
            this.sort_id = null;
            this.filterForm = {};
        }
        this.load;
    };

    PaginationService.prototype.goToPage = function (page) {
        this.number = page;
        var pageNumber = this.number > 1 ? this.number : null;
        if (this.useLocation) {
            $location.search('p', pageNumber);
        }
        this.load(getParams(this));
    };


    PaginationService.prototype.sort = function (sort) {
        this.sort_id = sort;
        this.number = 1;
        if (this.useLocation) {
            $location.search('sort', sort).search('p', null).replace();
        }
        this.load(getParams(this));
    };


    PaginationService.prototype.filter = function () {
        this.number = 1;
        if (this.useLocation) {
            $location.search(getParams(this)).replace();
        }
        this.load(getParams(this));
    };

    PaginationService.prototype.setPager = function (getList) {
        this.load = getList;
    };

    PaginationService.prototype.sync = function (currentPage,scope) {
        this.number = currentPage.number;
        this.size = currentPage.size;
        this.total = currentPage.total;
        if(scope){
            scope.$broadcast('page',this);
        }
    };

    return PaginationService;

}]);