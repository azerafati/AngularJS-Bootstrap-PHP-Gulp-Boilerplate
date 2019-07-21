app.factory('ProductService', ['API', '$q', function (API, $q) {
    var cache = [];

    var putInCache = function (product) {
        var cachedProduct = lookInCache(product.rndurl);
        if (!cachedProduct) {
            if (cache.length > 100) {
                cache.shift();
            }
            cache.push(product);
        } else {
            if (cachedProduct.partial) {
                cache[cache.indexOf(cachedProduct)] = product;
            }
        }
    };


    var lookInCache = function (rid) {
        return cache.find(function (p) {
            return p.rndurl === rid;
        });
    };
    var getLink = function (product) {
        if (!product) {
            return;
        }
        return "/p" + product.rndurl + '/' + product.url;
    };
    var getImage = function (product, num, zoom) {
        if (!product) {
            return;
        }
        if (product.img_count < 1) {
            return false;//"/res/img/main-menu/blank-image.jpg";
        }
        //'/res/img/prod/' + product.rnd + '/' + product.url + '.jpg';
        return '/res/img/prod/' + product.rnd + '/' + product.url + (num > 0 ? '-' + num : (zoom ? '-' : '')) + (zoom ? 'z' : '') + '.jpg';
        //return "/product/" + product.id + '_' + product.rnd_img + "/" + (num || 0) + (zoom ? 'z' : '') + ".jpg";
    };

    return {

        getImage: getImage,

        getImages: function (product, zoom) {
            if (!product) {
                return;
            }
            imageList = [];
            for (var i = 0; i < product.imgs; i++) {
                imageList.push(getImage(product, i, zoom));
            }
            return imageList;
        }, loadProducts: function (params) {
            return API.page('product', params).then(function (data) {
                data.content.forEach(function (product) {

                    if (product.item) {
                        for (var i = product.unit_list.length - 1; i >= 0; i--) {
                            if (product.item.amount % product.unit_list[i].ratio === 0) {
                                product.item.unit = product.unit_list[i];
                                product.unit_amount = product.item.amount / product.unit_list[i].ratio;
                                break;
                            }
                        }
                    }
                    product.img = '/res/img/prod/' + product.rnd + '/' + product.url + '.jpg';
                    product.link = getLink(product);
                    product.partial = true;
                    putInCache(product);
                });
                return data;
            });
        }, loadProduct: function (product_rid) {
            var cachedProduct = lookInCache(product_rid);
            if (cachedProduct && !cachedProduct.partial) {
                return $q.when(cachedProduct);
            }
            return API.get('product/get', {rid: product_rid}).then(function (product) {
                product.link = getLink(product);
                putInCache(product);
                return product;
            });
        }, getCache: function (product_rid) {
            return lookInCache(product_rid);
        }
    }


}]);