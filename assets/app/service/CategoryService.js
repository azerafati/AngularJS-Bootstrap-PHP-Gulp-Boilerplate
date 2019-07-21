app.factory('CategoryService', ['API', function (API) {
    var categories = [];
    var loadCategories = new Promise(function (resolve, reject) {
        if (categories.length) { resolve(categories); } else {
            API.get('category/loadAll').then(function (loadedCategories) {
                categories = loadedCategories;
                resolve(loadedCategories);
            });
        }
    });
    loadCategories();


    function findCategoryById(element, id) {
        if (element.id == id) {
            return element;
        } else if (element.children != null) {
            var i;
            var result = null;
            for (i = 0; result == null && i < element.children.length; i ++) {
                result = findCategoryById(element.children[i], id);
            }
            return result;
        }
        return null;
    }


    function fillParentsById(element, id, parents) {
        if (element.id == id) {
            parents.push(element);
            return parents;
        } else if (element.children != null) {
            if (element.id != null) parents.push(element);
            var i;
            var result = null;
            for (i = 0; result == null && i < element.children.length; i ++) {
                result = fillParentsById(element.children[i], id, parents);
            }
            if (result != null) {
                return parents;
            } else {
                parents.splice(- 1, 1);
            }
        }
        return null;
    }

    return {
        getCategories: function () {
            return loadCategories;
        }, getLink: function (category) {
            return '/c' + category.id + '/' + category.name.replace(/\s/g, "-");
        }, getCategory: function (id) {
            return findCategoryById({id:null,children:categories},id);
        }, getParents: function (id) {
            var parents = [];
            return fillParentsById({id:null,children:categories},id,parents);
        }
    }

}]);
