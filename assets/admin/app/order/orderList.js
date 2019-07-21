app.controller('orderListCtrl', ['$scope', 'API', 'bsModal', 'CheckBoxService', 'toast', function ($scope, API, bsModal, CheckBoxService, toast) {

    $scope.orders = [];
    var psize = 30;
    if ($scope.$parent.user_id) {
        psize = 10;
        $scope.user_id = $scope.$parent.user_id;
    }
    $scope.pg = API.pager(function () {
        $scope.loaded = false;
        API.page('order', {psize: psize, u: $scope.user_id}).then(function (res) {

            $scope.orders = res.content;
            $scope.pg.sync(res.page, $scope);
            $scope.loaded = true;
            $scope.chkService = new CheckBoxService($scope.orders);
        });
    });
    $scope.pg.load();
    API.get('order/status').then(function (res) {
        $scope.status = res;
    });


    $scope.edit = function (order) {
        bsModal.show({
            controller: 'orderModalCtrl',
            templateUrl: '/assets/admin/app/order/orderModal.html',
            locals: {order: angular.copy(order)}
        }).then(function (result) {
                $scope.pg.load();
            }
        )
    };


    $scope.deleteOrders = function () {
        if ($scope.chkService.getSelectedItems().length) {
            bsModal.confirm("حذف", "آیا از حذف سفارش های انتخاب شده اطمینان دارید؟ این عمل غیر قابل برگشت است.").then(function (res) {
                API.post("order/delete", {ids: $scope.chkService.getSelectedItems()}).then(function (res) {
                    //after deleting products
                    toast.show('سفارش های انتخاب شده حذف شدند.');
                    $scope.chkService.toggleAll();
                    $scope.pg.load();
                })
            });
        }
    };


    $scope.setStatus = function (order, status) {
        order.loading = true;
        API.post('order/edit', {
            ids: [order.id],
            val: status,
            property: 'status'
        }).then(function (res) {
            order.loading = false;
            $scope.pg.load();
        }).catch(function (res) {
            order.loading = false;
            switch (res) {
                default:
                    toast.error('خطایی در ذخیره سفارش رخ داد - اتصال اینترنت خود را چک کنید و دوباره تلاش کنید');
                    break;
            }
        })
    };


    $scope.newOrder = function () {
        $scope.edit({'created_at': new Date().toLocaleDateString(), 'order_items': [], 'user_id': $scope.user_id});
    }


}]);