<?php

/* @var Page $page */
$page = $view['page'];

?><div class="row half-gutter">
    <div class="col-12 " ng-cloak>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">صفحه اصلی</a>
                </li>
                <li class="breadcrumb-item" ng-repeat="cat in cats" ng-class="{active:$last}">
                    <a href="/c{{cat.id}}/{{cat.title}}"> {{cat.title}}</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body" id="article">
				<?php include(AppRoot . '../res/article/' . $page->rndurl . '.html'); ?>
            </div>
        </div>
    </div>
</div>