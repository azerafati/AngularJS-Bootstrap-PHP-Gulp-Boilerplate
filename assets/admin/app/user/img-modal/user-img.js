app.controller('userImageCtrl', ['$scope', 'bsModal', 'img', 'API', '$timeout', 'canvas', function ($scope, bsModal, img, API, $timeout, canvas) {
    var crop;
    $scope.imgChanged = false;
    $scope.hasImg = false;
    $scope.loading = true;

    //update
    function setCroppie(url) {
        return crop.replace(url);
    }

    bsModal.element.on('shown.bs.modal', function () {
        $timeout(function () {

            var base = bsModal.element.find('#crop-image img');
            crop = new Cropper(base[0], {
                viewMode: 2,
                dragMode: 'move',
                aspectRatio: 1,
                autoCropArea: 1,
                wheelZoomRatio: 0.2,
                minContainerHeight: 300
            });
            base.on('ready', function () {
                $scope.imgChanged = true;
                $scope.$apply();
            });
            /*crop = bsModal.element.find('#crop-image img').cropper({
                viewMode: 0,
                dragMode: 'move',
                aspectRatio: 1,
                autoCropArea: 1,
                wheelZoomRatio: 0.2,
               minContainerHeight: 300
            }).on('crop', function () {
                $scope.imgChanged = true;
                $scope.$apply();
            });
*/

            $scope.loading = false;
            if (canvas) {
                setCroppie(canvas);
            } else if (img) {
                $scope.hasImg = true;
                setCroppie(img);
                base.one('crop', function () {
                    $scope.imgChanged = false;
                    $scope.$apply();
                });
            }

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        setCroppie(e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            bsModal.element.find('#upload').on('change', function () {
                readFile(this);
            });

        }, 100);

    });

    $scope.save = function () {
        bsModal.hide(crop.getCroppedCanvas({
            fillColor: '#fff',
            minWidth: 300,
            minHeight: 300
        }).toDataURL("image/jpeg"));
        crop.destroy();
    };

    $scope.remove = function () {
        img.removed = true;
        bsModal.hide();
    };

}]);



