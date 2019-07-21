app.controller('categoryCtrl', ['$scope', 'bsModal', 'API', "$timeout", "checkedCats", function ($scope, bsModal, API, $timeout,checkedCats) {
    var zTreeObj;
    $timeout(function () {
        bsModal.element.find('.ui-select-search').focus();
    });
    //Init categories as empty array in case when categories are not loaded yet.
    $scope.categories = [];
    // Get all categories from DB
    var getJson = function () {
        $scope.loaded = false;
        API.post('category/loadAll').then(function (data) {
            $scope.loaded = true;
            $scope.categories = data;
            var openNodes = JSON.parse(localStorage.getItem("openNodes") || '[]');
            $scope.categories.forEach(function (cat) {
                cat.open = openNodes.indexOf(cat.id) > -1;
                cat.checked = checkedCats.find(function (x) {
                        return cat.id===x.id;
                    })!== undefined;
            });
            zTreeObj = $.fn.zTree.init($("#prodCategoryTree"), setting, $scope.categories);

        });
    };
    getJson();

    var setting = {
        check: {enable: true, chkboxType: {"Y": "", "N": ""}, radioType: "all", chkStyle: "checkbox"},
        edit: {enable: false},
        view: {selectedMulti: false},
        callback: {
            beforeExpand: function (treeId, treeNode) {
                var openNodes = JSON.parse(localStorage.getItem("openNodes") || '[]');
                openNodes.push(treeNode.id);
                localStorage.setItem("openNodes", JSON.stringify(openNodes));
                return true;
            }, beforeCollapse: function (treeId, treeNode) {
                var openNodes = JSON.parse(localStorage.getItem("openNodes") || '[]');
                var index = openNodes.indexOf(treeNode.id);
                if (index > -1) {
                    openNodes.splice(index, 1);
                }
                localStorage.setItem("openNodes", JSON.stringify(openNodes));
                return true;
            }
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: null
            }
        }
    }

    $scope.returnCategory = function () {
        var nodes = zTreeObj.getCheckedNodes(true);
        if (nodes.length) {
            bsModal.hide(nodes.map(function (n) {
                    return {name: n.name, id: n.id};
                })
            );
        }
    };
    $scope.searchCategories = function (q) {
        if (!zTreeObj) return [];
        nodeList = zTreeObj.getNodesByParamFuzzy("name", q);
        $scope.searchCats = nodeList;
    };
    $scope.selectCat = function (cat) {
        if (!zTreeObj || !cat) return;
        cat = zTreeObj.getNodeByTId(cat.tId);
        zTreeObj.expandAll(false);
        $timeout(function () {
            zTreeObj.expandNode(cat.getParentNode(), true);
            zTreeObj.checkNode(cat, true);
            zTreeObj.selectNode(cat);
        }, 300);

    }

}]);