app.factory('toast', ['$timeout', '$rootScope', function ($timeout, $rootScope) {

    var show = function (msg,alertType) {
        alertType = alertType || 'alert-dark';
        var tpl = '<div class="toast alert '+ alertType+' alert-dismissible fade" role="alert">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                         <span aria-hidden="true">&times;</span>\
                        </button>\
                   </div>';
        var toast = $(tpl).append(msg);
        $('body>.toast').alert('close');
        $('body').append(toast);
        setTimeout(function () {
            toast.addClass('show');
        }, 100);
        setTimeout(function () {
           toast.alert('close');
        }, 2000);
    }

    $rootScope.$on('$locationChangeStart', function () {
        //$('body>.toast').alert('close');
    });

    return {
        show: show,
        error: function (msg) {
            show(msg,'alert-danger')
        }
    }

}]);