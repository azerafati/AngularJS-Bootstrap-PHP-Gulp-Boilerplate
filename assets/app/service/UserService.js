app.factory('UserService', ['API', '$rootScope', 'toast', '$q', 'CartService', function (API, $rootScope, toast, $q, CartService) {


    var currentUser;
    var currentUserReqPromise;
    var setUser = function (user) {
        currentUser = user;
        switch (user.gender) {
            case "MALE":
                currentUser.pre = "آقای ";
                break;
            case "FEMALE":
                currentUser.pre = "خانم ";
                break;
            default:
                currentUser.pre = "";
                break;
        }

        currentUser.profileImage = profileImage(currentUser);
        $rootScope.$broadcast('login', currentUser);
    };
    var profileImage = function (user) {
        if (!user || user.is_guest || !user.id || !user.rnd_img) return false;
        return '/res/img/user/' + user.id + '/' + user.rnd_img + '.jpg';
    };


    return {
        getUser: function (fromDB) {
            return $q(function (resolve, reject) {
                if (currentUser && !fromDB) {
                    resolve(currentUser);
                } else {
                    if (!currentUserReqPromise) {
                        currentUserReqPromise = API.get('user/getMe').then(function (user) {
                            setUser(user);
                            resolve(currentUser);
                            currentUserReqPromise = undefined;
                        });
                    }
                    return currentUserReqPromise;

                }
            });
        }
        , isSignedIn: function () {
            return currentUser && !currentUser.is_guest;
        }, userlogin: function (user) {
            var req = API.post('user/login', {mobile: app.toEnglishDigits(user.mobile), password: user.password});
            req.then(function (data) {
                setUser(data);
                CartService.getCart(true);
            });
            return req;
        },
        profileImage: profileImage,
        setUser: setUser
    }


}]);
