app
    .run(['$rootScope', '$location', '$window',
        function ($rootScope, $location, $window) {

            $rootScope.$on('$routeChangeSuccess', function () {
                $window.gtag('config', 'UA-61578514-2', {'page_path': $location.path()});
            });

        }
    ]);


window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}

gtag('js', new Date());
gtag('config', 'UA-61578514-2');