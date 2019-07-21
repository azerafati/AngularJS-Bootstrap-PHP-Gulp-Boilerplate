app.controller('userAppointmentList', ['$scope', 'API', 'bsModal', '$routeParams', 'UserService', function ($scope, API, bsModal, $routeParams, UserService) {

    $scope.user_id = $routeParams.id;

    $scope.loaded = false;

    function load() {
        API.get('appointment/page', {u: $scope.user_id}).then(function (res) {
            $scope.appointments = res.content;
            $scope.loaded = true;
        });
    }

    load();
    $scope.statuses = {
        1: {title: "در انتظار تایید مشاور", color: "#ff981e"},
        2: {title: "تایید شده", color: "#325fbc"},
        3: {title: "یادآوری شده", color: "#00cc35"},
        4: {title: "انجام شده", color: "#858585"},
        5: {title: "کنسل", color: "#ff2c1b"},
    };


    $scope.summary = function (appointment) {
        bsModal.show({
            controller: 'appointmentSummaryCtrl',
            templateUrl: '/assets/admin/app/appointment/appointmentSummary.html',
            locals: {appointment: appointment}
        }).then(function (result) {
                load();
            }
        )
    };

    $scope.existLPR = function (appointment) {

        return appointment && (appointment.photography_cases || appointment.laboratory_cases || appointment.radiology_cases);
    };

}]);