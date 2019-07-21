app.factory('AuthService', ['UserService', '$rootScope', function (UserService, $rootScope) {
    var currentUser;
    UserService.getUser().then(function (u) {
        currentUser = u;
        return u;
    });
    $rootScope.$on('login', function (e, user) {
        currentUser = user;
    });

    return {
        hasPermission: function (permission) {
            if (!currentUser) return false;
            if (currentUser.user_group_id === 100) return true;
            return currentUser.permissions.indexOf(permission) > -1;
        }
    }
}]);