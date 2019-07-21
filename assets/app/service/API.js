app.factory('API', ['$http', '$location', function ($http, $location) {
    var apiLink = '/api/';

    var sendRequest = function (method, apiUrl, params) {

        return $http[method](apiUrl, params);

    };


    return {
        get: function (controllerMethod, params) {
            if (params)
                Object.keys(params).forEach(function (key) {
                    params[key] = app.toEnglishDigits(params[key]);
                });
            return sendRequest('get', apiLink + controllerMethod, {params: params}).then(function (res) {
                return res.data;
            });
        },
        post: function (controllerMethod, params) {
            if (params)
                Object.keys(params).forEach(function (key) {
                    params[key] = app.toEnglishDigits(params[key]);
                });
            return sendRequest('post', apiLink + controllerMethod, params).then(function (res) {
                return res.data;
            });
        },
        page: function (controller, params) {
            return this.get(controller + '/page', angular.extend({}, $location.search(), params)).then(function (data) {
                return {content: data.content, page: data.page};
            });
        }
    }

}]);