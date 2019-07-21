<!DOCTYPE html>
<html lang="fa" >

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title>پنل مدیریت  </title>
    <meta name="Author" content="@azerafati">
    <meta property="Copyright" content="Copyright 2016 boilerplate.com">
    <meta property="Reply-to" content="boilerplate@gmail.com">
    <link type="text/css" rel="stylesheet" href="/dist/assets/admin/css/style.css"/>
    <meta name="theme-color" content="#1abc9c">
    <base href="/admin/">
</head>

<body ng-app="app-admin">

<div class="d-none">
    <ng-include src="'/dist/assets/admin/css/sprite_icon.svg'"></ng-include>
    <ng-include src="'/dist/assets/admin/css/sprite_pic.svg'"></ng-include>
</div>

<ng-include class="d-print-none" src="'/assets/admin/app/navbar/navbar.html'"></ng-include>


<div class="container-fluid p-sm-5 mt-5 d-print-none" ng-view>

</div>
<footer class="mt-4 text-light bg-dark text-center d-print-none">
    example
</footer>


<!-- build:js /assets/admin/js/app.js -->
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/angular/angular.min.js"></script>
<script src="/node_modules/angular-route/angular-route.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/dist/assets/admin/js/app.js"></script>
<!-- endbuild -->


<!-- build:remove -->
<script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
    //]]></script>
<!-- endbuild -->

</body>


</html>