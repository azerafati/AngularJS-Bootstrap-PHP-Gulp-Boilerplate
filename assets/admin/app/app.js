var app = angular.module('app-admin', [
    'ngRoute'
]).config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {

    $routeProvider
        .when('/dashboard', {templateUrl: '/assets/admin/app/dashboard/dashboard.html', controller: 'dashboardCtrl'})
        .when('/products', {
            templateUrl: '/assets/admin/app/product/productList.html',
            controller: 'productListCtrl',
            reloadOnSearch: false
        })
        .when('/address', {
            templateUrl: '/assets/admin/app/address/address.html',
            controller: 'addressCtrl',
            reloadOnSearch: false
        }).when('/address/:id', {
        templateUrl: '/assets/admin/app/address/address.html',
        controller: 'addressCtrl'
    })
        .when('/users', {
            templateUrl: '/assets/admin/app/user/userList.html',
            controller: 'userListCtrl',
            reloadOnSearch: false
        })
        .when('/user/:id', {
            templateUrl: '/assets/admin/app/user/userPage.html',
            controller: 'userPageCtrl'
        })
        .when('/orders', {
            templateUrl: '/assets/admin/app/order/orderList.html',
            reloadOnSearch: false
        })
        .when('/payments', {
            templateUrl: '/assets/admin/app/payment/paymentList.html',
            reloadOnSearch: false
        })
        .when('/articles', {
            templateUrl: '/assets/admin/app/article/articleList.html',
            reloadOnSearch: false
        })
        .when('/logs', {
            templateUrl: '/assets/admin/app/log/logList.html',
            reloadOnSearch: false
        })
        .when('/sms', {
            templateUrl: '/assets/admin/app/sms/smsList.html',
            controller: 'smsListCtrl',
            reloadOnSearch: false
        })
        .when('/p:rid/:url*', {
            templateUrl: '/assets/app/product/product.html',
            controller: 'productCtrl',
            resolve: {
                product: ['ProductService', '$route', function (ProductService, $route) {
                    return ProductService.loadProduct($route.current.params.rid);
                }]
            }
        })
        .when('/c:cid/:url*', {
            templateUrl: '/assets/app/comment/category.html',
            controller: 'categoryCtrl',
            resolve: {
                category: ['API', '$route', function (API, $route) {
                    return API.get('category/get', {id: $route.current.params.cid});
                }]
            }

        })
        .when('/search/:search*', {
            templateUrl: '/assets/app/comment/category.html',
            controller: 'searchPageCtrl',

        })

        .when('/login', {
            templateUrl: '/assets/app/login/login.html',
            controller: 'loginCtrl',
        })
        .when('/signup', {
            templateUrl: '/assets/app/article/article.html',
            controller: 'articleCtrl',
            resolve: {
                article: ['API', '$route', function (API, $route) {
                    //return API.get('page/get',{id:$route.current.params.id});
                    return {id: $route.current.params.id}
                }]
            }
        })
        .when('/درباره-ما', {
            templateUrl: '/assets/app/article/article.html',
            controller: 'articleCtrl',
            resolve: {
                article: function () {
                    return {id: 'yiw'};
                }
            }

        }).when('/تماس-با-ما', {
        templateUrl: '/assets/app/article/article.html',
        controller: 'articleCtrl',
        resolve: {
            article: function () {
                return {id: 'lxb'};
            }
        }

    }).when('/سوالات-متداول', {
        templateUrl: '/assets/app/article/article.html',
        controller: 'articleCtrl',
        resolve: {
            article: function () {
                return {id: 'mey'};
            }
        }

    }).otherwise({templateUrl: '/assets/admin/app/error-pages/not-found.html'});


    $locationProvider.html5Mode({enabled: true, requireBase: false});


}]).run(['$rootScope', '$location', '$routeParams', function ($rootScope, $location, $routeParams) {

    $rootScope.$on('$locationChangeSuccess', function () {
        $rootScope.path = $location.path();
    });
}]).config(['$qProvider', '$compileProvider', function ($qProvider, $compileProvider) {
    $qProvider.errorOnUnhandledRejections(true);
    $compileProvider.debugInfoEnabled(true);
    $compileProvider.commentDirectivesEnabled(false);
    $compileProvider.cssClassDirectivesEnabled(false);
}]);
