/*app.directive('input', [function () {
 return {
 restrict: "E", link: function (scope, element, attrs) {
 element.on('blur', function (e) {
 if (element.val().length) element.val(app.toEnglishDigits(element.val())).trigger('input');
 });
 }
 };
 }]);*/

app.toEnglishDigits = function (string) {
    if (!string || !string.length || !(typeof string === 'string' || string instanceof String)) {
        return string;
    }
    var charCodeZero = '۰'.charCodeAt(0);
    return (string.replace(/[۰-۹]/g, function (w) {
        return w.charCodeAt(0) - charCodeZero;
    }));
};