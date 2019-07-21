app.factory('CheckBoxService', ['$timeout', function ($timeout) {

    var CheckBoxService = function (totalItems) {
        this.selectedItems = [];
        this.totalItems = totalItems;
    };

    CheckBoxService.prototype.getSelectedItems = function () {
        return this.selectedItems;
    };

    var timer;
    CheckBoxService.prototype.toggle = function (id) {
        $timeout.cancel(timer);
        var chk = this;
        timer = $timeout(function () {

            var idx = chk.selectedItems.indexOf(id);
            if (idx > - 1) {
                chk.selectedItems.splice(idx, 1);
            }
            else {
                chk.selectedItems.push(id);
            }
        }, 50);
    };

    CheckBoxService.prototype.exists = function (id) {
        return this.selectedItems.indexOf(+id) > -1;
    };

    CheckBoxService.prototype.isIndeterminate = function () {
        return (this.selectedItems.length !== 0 &&
        this.selectedItems.length !== this.totalItems.length);
    };

    CheckBoxService.prototype.isChecked = function () {
        return this.selectedItems.length === this.totalItems.length;
    };

    var timerAll;
    CheckBoxService.prototype.toggleAll = function () {
        $timeout.cancel(timerAll);
        var chk = this;
        timerAll = $timeout(function () {

            if (chk.selectedItems.length) {
                chk.selectedItems = [];
            } else {
                chk.selectedItems = [];
                chk.totalItems.forEach(function (item) {
                    chk.selectedItems.push(item.id);
                });
            }
        }, 10);
    };

    return CheckBoxService;

}]);