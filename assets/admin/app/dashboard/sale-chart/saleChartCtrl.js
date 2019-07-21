app.controller('saleChartCtrl', ['$scope', 'API', '$timeout', '$q', function ($scope, API, $timeout, $q) {

    var chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
    $scope.chartTypes = [{id: 'day', label: 'روز'}, {id: 'month', label: 'ماه'}, {id: 'year', label: 'سال'}];
    $scope.chartType = 'day';

    $scope.loadChartData = function () {
        $scope.loadingChart = true;
        $scope.stats = [];
        $scope.statsLabels = null;

        $http.get('api/dashboard/getStats?q=order&t=' + $scope.chartType
        ).then(function (res) {
            $scope.curOrders = res.data[res.data.length - 1];
            $scope.stats[0] = res.data;
            initChart();

        });

        $http.get('api/dashboard/getStats?q=payment&t=' + $scope.chartType
        ).then(function (res) {
            $scope.curPayments = res.data[res.data.length - 1];
            $scope.stats[1] = res.data;
            initChart();
        });

        $http.get('api/dashboard/getStats?q=purchase&t=' + $scope.chartType
        ).then(function (res) {
            $scope.curPurchases = res.data[res.data.length - 1];
            $scope.stats[2] = res.data;
            initChart();
        });

    };

    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var chartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'سفارش',
            backgroundColor: chartColors.red,
            borderColor: chartColors.red,
            data: [],
            fill: false,
        }, {
            label: 'پرداخت نقدی',
            fill: false,
            backgroundColor: chartColors.blue,
            borderColor: chartColors.blue,
            data: [],
        }, {
            label: 'خرید سفال',
            fill: false,
            backgroundColor: chartColors.yellow,
            borderColor: chartColors.yellow,
            data: [],
        }, {
            label: 'خرید سفال',
            fill: false,
            backgroundColor: chartColors.yellow,
            borderColor: chartColors.yellow,
            data: [],
        }]
    };

    var config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,

            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function (tooltipItems, data) {
                        return data.datasets[tooltipItems.datasetIndex].label + '= ' + tooltipItems.yLabel.toLocaleString();
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'روز'
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function (value, index, values) {
                            return value.toLocaleString();
                        }
                    }
                }]
            }
        }
    };
    var ctx, chart;
    $timeout(function () {
        ctx = document.getElementById('sale_chart').getContext('2d');
        chart = new Chart(ctx, config);
        $scope.initChart();
    }, 0);

    $scope.initChart = function () {
        $scope.loading = true;
        API.get('dashboard/getStats', {q: 'label', t: $scope.chartType}).then(function (res) {
            var labels = [];
            res.forEach(function (dateLabel) {
                var date = moment(dateLabel);
                switch ($scope.chartType) {
                    case 'day':
                        labels.push(date.format('jM-jDD'));
                        break;
                    case 'month':
                        labels.push(date.format('jYY-jMMMM'));
                        break;
                    case 'year':
                        labels.push(date.format('jYY'));
                        break;
                }
            });
            chartData.labels = labels;
            chart.update();
            $scope.curDate = labels[labels.length - 1];
            $scope.loaded = true;
        });

        var promiseOrder = API.get('dashboard/getStats?q=order&t=' + $scope.chartType
        ).then(function (res) {
            chartData.datasets[0].data = res;
            chart.update();
            $scope.loaded = true;
        });

        var promisePayment = API.get('dashboard/getStats?q=payment&t=' + $scope.chartType
        ).then(function (res) {
            chartData.datasets[1].data = res;
            chart.update();
            $scope.loaded = true;
        });

        var promisePurchase = API.get('dashboard/getStats?q=purchase&t=' + $scope.chartType
        ).then(function (res) {
            chartData.datasets[2].data = res;
            chart.update();
            $scope.loaded = true;
        });

        var promisePurchase = API.get('dashboard/getStats?q=purchase&t=' + $scope.chartType
        ).then(function (res) {
            chartData.datasets[3].data = res;
            chart.update();
            $scope.loaded = true;
        });

        $q.all([promiseOrder, promisePayment, promisePurchase]).then(function () {
            $scope.loading = false;
        });

    };


    //            window.myLine.update();

    Chart.defaults.global.defaultFontFamily = 'Roboto, Shabnam, Helvetica, sans-serif';

}
]);