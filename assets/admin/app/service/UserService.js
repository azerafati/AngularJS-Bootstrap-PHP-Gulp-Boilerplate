app.factory('UserService', ['API', '$rootScope', 'toast', '$q', function (API, $rootScope, toast, $q) {

    var currentUser;
    var setUser = function (user) {
        currentUser = user;
        currentUser.profileImage = profileImage();
        $rootScope.$broadcast('login', currentUser);
    };
    var profileImage = function () {
        if (!currentUser || currentUser.is_guest || !currentUser.id || !currentUser.rnd_img) return false;
        return '/res/img/user/' + currentUser.id + '/' + currentUser.rnd_img + '.jpg';
    };
    return {
        getUser: function (fromDB) {
            return new Promise(function (resolve, reject) {
                if (currentUser && !fromDB) {
                    resolve(currentUser);
                } else {
                    API.get('user/getMe').then(function (user) {
                        setUser(user);
                        resolve(currentUser);
                    });
                }
            });
        },
        profileImage: function (user) {
            if (!user || user.is_guest || !user.id || !user.rnd_img) return false;
            return '/res/img/user/' + user.id + '/' + user.rnd_img + '.jpg';
        },
        setUser: setUser
    }


}]);
