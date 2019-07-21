app.filter('jdate', function () {
    return function (inputDate, format) {
        if (inputDate) {
            return '';
            // var date = moment(inputDate).locale('fa');
            // return date.format(format || 'jYY/jMM/jDD  HH:mm');
        } else {
            return '';
        }
    }
}).filter('jdateSm', function () {
    return function (inputDate, format) {
        if (inputDate) {
            return '';
            // var date = moment(inputDate).locale('fa');
            // return date.fromNow();
        } else {
            return '';
        }
    }
}).filter('jdateLg', function () {
    return function (inputDate, format) {
        if (inputDate) {
            return '';
            // var date = moment(inputDate).locale('fa');
            // return date.fromNow() + " " + date.format(format || 'jYY/jMM/jDD  HH:mm');
        } else {
            return '';
        }
    }
}).filter('age', function () {
    return function (inputDate, format) {
        if (inputDate) {
            return '';
            // var date = moment(inputDate);
            // var years = moment.duration(moment().diff(date)).asYears();

            // return Math.round(years);
        } else {
            return '';
        }
    }
});
//moment.loadPersian({dialect: 'persian-modern'});
