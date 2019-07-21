app.controller('userEduChartCtrl', ['$scope', 'API', '$timeout', '$q', function ($scope, API, $timeout, $q) {

    var chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    var randomScalingFactor = function () {
        return Math.round(Math.random() * 100);
    };

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    chartColors.red,
                    chartColors.yellow,
                    chartColors.green,
                    chartColors.purple,
                    chartColors.grey,
                ],
                label: 'Dataset 1'
            }],
            labels: [
                'دیپلم',
                'لیسانس',
                'فوق لیسانس',
                'دکتری',
                'نا مشخص',

            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: false,
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            /*circumference: Math.PI,
            rotation : -Math.PI*/
        }
    };


    var ctx = document.getElementById('user_edu_chart').getContext('2d');
    window.myDoughnut = new Chart(ctx, config);
    $scope.loaded = true;
    $scope.loading = false;

    //            window.myLine.update();

    Chart.defaults.global.defaultFontFamily = 'Roboto, Shabnam, Helvetica, sans-serif';

}
]);