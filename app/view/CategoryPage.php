<?php
/* @var $category Category */
$category = $view['category'];

?><div class="row half-gutter" id="category-page">
    <div class="col-sm-12" ng-show="category.info" id="category-info">
        <div class="card">
            <div class="card-body">
                <a href="<?=$category->getLink()?>"><h4><?=$category->title?></h4></a>
                <img src="<?=$category->img?>" class="rounded" alt="<?=$category->title?>">
                <p>
					<?=$category->info?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="prods row half-gutter">
            <product class="col-6 col-sm-4 col-md-3" ng-model="p" ng-repeat="p in products track by p.rndurl"></product>
        </div>
        <spinner></spinner>
    </div>

</div>