<?php
if (isset($view['is_server_side']) && $view['is_server_side']) {
	$isServerSide = true;
} else {
	$isServerSide = false;
}
?><!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" type='image/x-icon' href="/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="theme-color" content="#1abc9c">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title>Boilerplate</title>
    <meta name="description" content="description">
    <meta property="Copyright" content="Copyright 2018 boilerplate.com">
    <meta property="Reply-to" content="example@gmail.com">
    <meta property="og:site_name" content="example">

    <meta property="og:image" content="https://boilerplate.com/res/img/logo.jpg"/>
    <meta property="og:title" content="<?= $view['title']; ?> - boilerplate"/>
    <meta property="og:url" content="<?= "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
    <link type="text/css" rel="stylesheet" href="/dist/assets/css/style.css"/>
</head>


<body ng-app="app">

<div class="position-absolute invisible">
    <ng-include src="'/dist/assets/css/sprite_icon.svg'"></ng-include>
    <ng-include src="'/dist/assets/css/sprite_pic.svg'"></ng-include>
</div>


<nav class="navbar navbar-expand-lg navbar-light justify-content-sm-around ltr" ng-controller="navbarCtrl" ng-include="'/assets/app/navbar/navbar.html'"></nav>

<?php if ($isServerSide) {
	echo '<ng-view-delay  >';

	call_user_func_array($view['content'], [$view]);

	echo '</ng-view-delay>';
} ?>
<ng-view <?= ($isServerSide ? 'ng-if="::serverLoaded"' : '') ?> ></ng-view>


<footer class="mt-4">
    <div class=" text-center text-sm" style="color: #fff; background-color: #777;">
        Copyright © 2018 boilerplate.com -
        تمامی حقوق برای
        <a href="//boilerplate.com" style="color: white">boilerplate</a>
        محفوظ است
    </div>
</footer>


<!-- build:js /assets/js/app.js -->
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/angular/angular.min.js"></script>
<script src="/node_modules/angular-route/angular-route.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/dist/assets/js/app.js"></script>
<!-- endbuild -->


<!-- build:remove -->
<script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
    //]]></script>
<!-- endbuild -->


</body>
</html>

