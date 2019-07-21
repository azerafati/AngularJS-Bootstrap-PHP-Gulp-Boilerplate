const app = angular.module('app', ['ngRoute']).config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
    $routeProvider.when('/', {
        templateUrl: '/assets/app/home/home.html',
        controller: 'homeCtrl'
    }).when('/سبد-خرید', {
        templateUrl: '/assets/app/cart/cart.html',
        controller: 'cartCtrl'
    }).when('/لیست', {
        templateUrl: '/assets/app/list/list.html',
        controller: 'listCtrl'
    }).when('/login', {
        templateUrl: '/assets/app/login/login.html',
        controller: 'loginCtrl'
    }).otherwise({
        templateUrl: '/assets/app/error-pages/not-found.html'
    });
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
}]).config(['$qProvider', '$compileProvider', function ($qProvider, $compileProvider) {
    $qProvider.errorOnUnhandledRejections(true);
    $compileProvider.debugInfoEnabled(true);
    $compileProvider.commentDirectivesEnabled(false);
    $compileProvider.cssClassDirectivesEnabled(false);
}]).run(['$rootScope', '$location', function ($rootScope, $location) {
    $rootScope.location = $location;
}]);
