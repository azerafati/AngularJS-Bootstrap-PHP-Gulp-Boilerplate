app.factory('CategoryService', ['bsModal', function (bsModal) {
    return {
        selectCategories: function (checkedCats) {
            return bsModal.show({
                templateUrl: '/assets/admin/app/category/category.html',
                controller: 'categoryCtrl',
                locals: {checkedCats: checkedCats||[]}
            })
        }
    }
}]);