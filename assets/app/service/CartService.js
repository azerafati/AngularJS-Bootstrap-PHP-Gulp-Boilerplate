app.factory('CartService', ['API', '$rootScope', 'toast', '$q', function (API, $rootScope, toast, $q) {

    var cart = {};
    var getCartFromServer = function () {
       return API.get('order/cart').then(function (cart) {
            setCart(cart);
            return cart;
        });
    };
    var setPostPlan = function (post_plan_id) {
        return API.post('order/setPostPlan', {id: post_plan_id}).then(function (res) {
            getCartFromServer();
        });
    };
    var setCart = function (data) {
        cart = data;
       /* cart.orderItems.forEach(function (item) {
            setUnit(item);
        });*/
        $rootScope.$broadcast('cart');
    };

    ///stauses
    var statuses = [];
    return {
        getCart: function (fromServer) {
            var q = $q.defer();
            if (cart.id && !fromServer) {
                q.resolve(cart);
            } else {
                getCartFromServer().then(function (cart) {
                    q.resolve(cart);
                });
            }
            return q.promise;
        },addToCart: function (product) {
            product.loading = true;
            return API.post('order/addToCart', {rid: product.rndurl}).then(function (cart) {
                product.in_cart = true;
                /*product.item = cart.orderItems.find(function (x) {
                    return x.product.id == product.id
                });
                product.item.unit = product.item.unit_list[0];
                product.unit_amount = 1;*/
                setCart(cart);

            }).finally(function () {
                product.loading = false;
            });
        }, removeFromOrder: function (order, item) {
            item.in_cart = false;
            return API.post('order/removeItem', {id: item.id})
                .then(function (res) {
                    //setCart(data);
                    angular.merge(order, res);
                    order.orderItems = res.orderItems;
                    order.orderItems.forEach(function (item) {
                        setUnit(item);
                    });
                    if (order.is_open)
                        toast.error(
                            item.product.name + ' از سبد خرید حذف شد'
                        );
                });
        },
        editItem: function (order, item, property, val) {
            return API.post('order/editItem', {
                id: item.id,
                val: val || item[property],
                property: property
            }).then(function (res) {
                angular.merge(order, res);
                order.orderItems = res.orderItems;
                order.orderItems.forEach(function (item) {
                    setUnit(item);
                });
                return order;
            });
        },
        setPostPlan: setPostPlan,
        getStatus: function () {
            var q = $q.defer();
            if (statuses.length) {
                q.resolve(statuses);
            } else {
                API.get('order/status').then(function (st) {
                    statuses = st;
                    q.resolve(statuses);
                });
            }
            return q.promise;
        }
    }

}]);
