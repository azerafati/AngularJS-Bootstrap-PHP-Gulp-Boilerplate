app.controller('cartCtrl', ['$scope', 'API', 'CartService', 'bsModal', function ($scope, API, CartService, bsModal) {
    $scope.range = app.range;
    var getCart = function () {
        CartService.getCart().then(function (cart) {
            $scope.cart = cart;
            $scope.loaded = true;
        });
    };

    getCart();

    $scope.$on('cart', function () {
        CartService.getCart().then(function (cart) {
            $scope.cart = cart;
        });
    });

    $scope.update_qty = function (item) {
        CartService.editItem($scope.cart, item, 'qty').then(function (order) {
            $scope.cart = order;
        });

        /*item.loadingQty = true;
        API.post('order/setQty', {id: item.id, qty: item.qty || 1}).then(function (res) {
            item.loadingQty = false;
            getBasket();
        });*/
    };

    $scope.removeItem = function (item) {
        bsModal.confirm("حذف محصول", "آیا  می خواهید این محصول را حذف کنید؟").then(function () {
            /* API.post('order/removeItem', {id: item.id}).then(function (res) {
                 getBasket();
             });*/
            CartService.removeFromOrder($scope.cart, item);
        });
    };




    $scope.address = {};
    $scope.submitOrder = function () {
        if (!$scope.itemsForm.$valid) {
            az.alert("warning", "لطفا تمام موارد داخل فرم را ابتدا تکمیل نمایید و دوباره اقدام کنید");
            return;
        }

        $scope.submit = true;
        getAllAddresses();


    };

    $scope.updatePlan = function () {
        $scope.updatingPlan = true;
        CartService.setPostPlan($scope.cart.post_plan_id).then(function (res) {
            $scope.updatingPlan = false;
        });
    };

    $scope.submitWithoutPayment = function () {
        az.alert('ask', 'هر وقت خواستید می توانید هزینه  را از قسمت سفارش ها پرداخت کنید. اما توجه کنید که تا قبل از پرداخت سفارش شما پردازش نمی شود.<br/> می خواهید بدون پرداخت ثبت شود؟', 'مطئن هستید').yes = function () {
            $scope.paying = true;
            API.post('order/closeBasket', {'adrs': $scope.selectedAdrs}).then(function (res) {
                location = '/order';
            }, function () {
                az.alert("error", "متاسفانه پاسخی از بانک دریافت نشد. لطفا یک بار دیگر امتحان کنید", "خطا در اتصال")
                $scope.paying = false;
            });
        };
    };



    $scope.editAddress = function (address) {

        $scope.address = angular.copy(address);
        //$scope.submit = true;
        API.get('address/provinces').then(function (res) {
            $scope.provinces = res;
            if ($scope.address && $scope.address.province_id)
                $scope.loadCities();
        });

        $('#addressModal').modal('show');
    };
    $scope.saveAddress = function (address) {

        //$scope.submit = true;
        API.post('address/save', address).then(function () {
            $scope.address = {};
            getAllAddresses();
        });
    };
    $scope.removeAddress = function (address) {

        bsModal.confirm("حذف آدرس", "آیا می خواهید این آدرس را حذف کنید؟").then(function () {
            API.post('address/remove', {id: address.id}).then(function () {
                $scope.address = {};
                getAllAddresses();
            });
        });
    };

    $scope.loadCities = function () {
        $scope.loadingCities = true;
        API.get('address/cities', {

            id: $scope.address.province_id

        }).then(function (res) {
            $scope.cities = res;
            $scope.loadingCities = false;
        });
    };

    $scope.pay = function () {
        $scope.paying = true;

        if ($scope.cart.final_price < 30000) {

            bsModal.alert("به دلیل وجود محدودیت در ارسال، حداقل خرید از boilerplate سی هزار تومان می باشد. لطفا محصول دیگری هم به سبد خرید اضافه کنید. ", "مبلغ سفارش");

        } else {

            API.post('payment/payOrder', {'adrs': $scope.selectedAdrs}).then(function (res) {

                if (!res.paid) {
                    var form = $('<form></form>');

                    form.attr("method", "post");
                    form.attr("action", res.url);

                    $.each(res.post, function (key, value) {
                        var field = $('<input/>');

                        field.attr("type", "hidden");
                        field.attr("name", key);
                        field.attr("value", value);

                        form.append(field);
                    });

                    // The form needs to be a part of the document in
                    // order for us to be able to submit it.
                    $(document.body).append(form);
                    form.submit();

                } else {
                    bsModal.alert("مبلغ سفارش از اعتبار شما در boilerplate برداشت شد. boilerplate از خرید شما تشکر می&nbsp;کند", "ثبت شد").close = function () {
                        location.reload();
                    };
                }
            }, function () {
                bsModal.alert("متاسفانه پاسخی از بانک دریافت نشد. لطفا یک بار دیگر امتحان کنید", "خطا در اتصال");
                $scope.paying = false;
            });

        }

    };

    $scope.addInfo = function (item) {
        $scope.itemCusInfo = item.cus_info;
        $('#itemInfo').modal('show');

        $scope.saveInfo = function () {

            item.loadingInfo = true;

            API.post('order/updateItemInfo', {
                id: item.id,
                oid: $scope.cart.id,
                val: $scope.itemCusInfo
            }).then(function (res) {
                item.loadingInfo = false;
                item.cus_info = $scope.itemCusInfo;
            });
        };
    };
    $scope.agreement = true;

}]);

