app.controller('orderModalCtrl', ['$scope', 'API', 'bsModal', 'order', 'ProductService', 'toast', 'PrintService', function ($scope, API, bsModal, order, ProductService, toast, PrintService) {

    $scope.order = order;
    bsModal.onHide(function () {
        
    });
    function loadOrder(user_id) {

        API.get('order/get', {id: order.id, user_id: user_id}).then(function (order) {
            setupOrder(order);
            $scope.loaded = true;
        });

    }

    if (order.id) {
        loadOrder();
    } else {
        $scope.loaded = true;
        if (order.user_id) {
            loadOrder(order.user_id);
        } else {
            setupOrder(order);
        }
    }

    function setupOrder(order) {
        $scope.order = order;
        $scope.order.order_items.forEach(function (item) {

            item.product.link = ProductService.getLink(item.product);
            item.product.img = ProductService.getImage(item.product);

        });
        var date = moment(order.created_at);

        $scope.oDay = date.format('jDD');//date.date();
        $scope.oMonth = date.format('jMM');
        $scope.oYear = date.format('jYY');

    }

    API.get('order/statusItem').then(function (res) {
        $scope.status = res;
    });

    $scope.setStatus = function (item, status) {
        item.status = status;
        $scope.editItem(item, 'status', status);
    };

    $scope.editItem = function (item, property, val) {
        $scope.loading = true;
        return API.post('order/editItem', {
            id: item.id,
            val: val || item[property],
            property: property
        }).then(function (order) {
            setupOrder(order);
        }).catch(function () {
            toast.error('خطا');
        }).finally(function () {
            $scope.loading = false;
        });
    };


    $scope.editOrder = function (property, val) {
        var order = $scope.order;
        $scope.loading = true;
        val = val === undefined ? order[property] : val;
        switch (property) {
            case 'discount':
                if (!(val === 0 || val > 0)) {
                    val = order.discount = 0;
                }
                break;
        }
        return API.post('order/edit', {
            id: order.id,
            val: val,
            property: property
        }).then(function (order) {
            setupOrder(order);
        }).catch(function (res) {
            switch (res) {
                default:
                    toast.error('خطایی در ذخیره سفارش رخ داد - اتصال اینترنت خود را چک کنید و دوباره تلاش کنید');
                    break;
            }
        }).finally(function () {
            $scope.loading = false;
        });
    };

    $scope.searchProduct = function (search) {
        API.page('product', {psize: 15, search: search}).then(function (res) {
            res.content.forEach(function (product) {

                product.img = ProductService.getImage(product);

            });
            $scope.products = res.content;
        });
    };
    $scope.searchUsers = function (search) {
        API.page('user', {psize: 10, search: search}).then(function (res) {
            $scope.users = res.content;
        });
    };

    $scope.setUser = function (user_id) {
        if ($scope.order.id) {
            $scope.editOrder('user_id', user_id)
        } else {
            loadOrder(user_id);
        }
    };

    $scope.searchAddress = function () {
        API.get('address/loadAll', {psize: 10, u: $scope.order.user_id}).then(function (res) {
            $scope.addresses = res;
        });
    };

    $scope.setAddress = function (address) {
        if ($scope.order.id) {
            $scope.editOrder('address', address.id)
        }
    };


    $scope.addItem = function () {
        $scope.loading = true;
        API.post('order/addItem', {order_id: $scope.order.id}).then(function (order) {

            setupOrder(order);

        }).catch(function (res) {
            switch (res) {
                default:
                    toast.error('خطایی رخ داد - اتصال اینترنت خود را چک کنید و دوباره تلاش کنید');
                    break;
            }
        }).finally(function () {
            $scope.loading = false;
        });
    };

    $scope.addProduct = function (product) {
        $scope.loading = true;
        API.post('order/addProduct', {id: product.id, order_id: $scope.order.id}).then(function (order) {

            setupOrder(order);

        }).catch(function (res) {
            switch (res) {
                default:
                    toast.error('خطایی رخ داد - اتصال اینترنت خود را چک کنید و دوباره تلاش کنید');
                    break;
            }
        }).finally(function () {
            $scope.loading = false;
        });
    };

    $scope.removeItem = function (item) {

        bsModal.confirm().then(function () {
            $scope.loading = true;
            API.post('order/removeItem', {id: item.id}).then(function (order) {

                setupOrder(order);

            }).catch(function (res) {
                switch (res) {
                    default:
                        toast.error('خطایی رخ داد - اتصال اینترنت خود را چک کنید و دوباره تلاش کنید');
                        break;
                }
            }).finally(function () {
                $scope.loading = false;
            });
        });
    };

    $scope.setOrderDate = function (oDay, oMonth, oYear) {
        var date = moment('13' + oYear + '/' + oMonth + '/' + oDay, 'jYYYY/jMM/jDD');
        $scope.editOrder('created_at', date.format('YYYY-MM-DD HH:mm:ss'));
    };

    $scope.print = function (printMode) {
        PrintService.print({
            templateUrl: "/assets/admin/app/order/orderPrint.html",
            controller: "orderPrintCtrl",
            printMode: printMode,
            locals: {order: $scope.order,showImages:printMode}
        });
    };

    $scope.printAddress = function (printMode) {
        var  o = $scope.order;
        PrintService.print({
            templateUrl: '/assets/admin/app/address/addressPrint.html',
            controller: 'addressPrintCtrl',
            locals: {
                address: {
                    detail: o.address_province + ' - ' + o.address_city + ' - ' + o.address_detail,
                    name: o.address_name,
                    number: o.address_number,
                    postalcode: o.address_postalcode,

                }
            }
        })
    }


}]);