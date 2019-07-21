app.controller('articleModalCtrl', ['$scope', 'API', 'bsModal', 'article', 'CategoryService', function ($scope, API, bsModal, article, CategoryService) {

    $scope.article = article;

    /*
        API.get('article/get', {id: article.id}).then(function (article) {
            $scope.article = article;
            $scope.loaded = true;
        });
    */


    $scope.selectCategory = function () {
        CategoryService.selectCategories($scope.article.categories).then(function (cats) {
            $scope.article.categories = cats;
            $scope.article_form.$setDirty();
        });
    };

    $scope.save = function (article) {
        $scope.loading = true;
        API.post('article/save',
            article
        ).then(function (res) {
        }).finally(function () {
            $scope.loading = false;
            bsModal.hide();
        });
    }

}]);