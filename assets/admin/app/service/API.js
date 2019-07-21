app.factory('API', ['$http', '$location', 'PaginationService', function ($http, $location, PaginationService) {
    var apiLink = '/admin/api/';

    var sendRequest = function (method,apiUrl,params) {

        return $http[method](apiUrl,params);

    };




    return {
        get: function (controllerMethod, params) {
            if (params)
                Object.keys(params).forEach(function (key) {
                    params[key] = app.toEnglishDigits(params[key]);
                });
            return sendRequest('get',apiLink + controllerMethod, {params: params}).then(function (res) {
                return res.data;
            });
        },
        post: function (controllerMethod, params) {
            if (params)
                Object.keys(params).forEach(function (key) {
                    params[key] = app.toEnglishDigits(params[key]);
                });
            return sendRequest('post',apiLink + controllerMethod, params).then(function (res) {
                return res.data;
            });
        },
        page: function (controller, params, useLocation) {
            useLocation = typeof useLocation === 'undefined' ? true : useLocation;
            return this.get(controller + '/page', useLocation ? angular.extend({}, $location.search(), params) : params).then(function (data) {
                return {content: data.content, page: new PaginationService(data.page)};
            });
        },
        pager: function (getList, useLocation) {
            useLocation = typeof useLocation == 'undefined' ? true : useLocation;
            var pg = new PaginationService({number: 1, size: 1, total: 1}, useLocation);
            pg.setPager(getList);
            return pg;
        }
    }

}]);