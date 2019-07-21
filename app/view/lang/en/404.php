<!--
         Slider section start         	  =
    ======================================= -->
<section class="slider-section-2 slider-section-2-bg">
    <div class="bannar-image">
        <img src="/assets/images/bannar-img.jpg" alt="bannar">
    </div><!-- /.bannar-image -->
    <div class="container">
        <div class="row">
            <div class="slide">
                <div class="site-page-header clear-fix">
                    <div class="site-title">
                        <h2>Error</h2>
                    </div><!-- /.site-title -->

                    <div class="breadcrumb">
                        <ul>
                            <li class="breadcrumb-item"><a href="/en/">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Error</a></li>
                        </ul>
                    </div><!-- /.breadcrumb -->
                </div><!-- /.site-page-header -->
            </div><!-- /.slide -->
        </div>
    </div><!-- /.container -->
</section>


<!--
        Error page  start 	         =
======================================= -->
<section id="error-page">
    <div class="section-padding">
        <div class="container">
            <div class="error">
                <div class="error-inside">
                    <div class="inside-content">
                        <h1>404</h1>
                        <h3>Somethings is wrong</h3>
                        <p>The page you are looking for was moved, removed, renamed or might never existed.</p>
                        <a href="/en/" class="custom-btn">Go Home</a>
                    </div><!-- /.inside-content -->
                </div><!-- /.error-inside -->
            </div><!-- /.error -->
        </div><!-- /.container -->
    </div><!-- /.section-padding -->
</section>



<?php if (UserService::isUserAdmin()){
    echo '
        <div id="PageEdit" style=" position: fixed; bottom: 5px; left: 5px; z-index: 99999; ">
            <a class="btn btn-default btn-xs" target="_blank" href="/admin/page-edit?url='.substr($_SERVER['REQUEST_URI'],4). '">ایجاد صفحه <i class="fa fa-pencil-square"></i></a>
        </div>
        ';
}
?>