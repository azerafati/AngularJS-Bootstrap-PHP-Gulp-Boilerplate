<?php

/* @var $product Product */
$product = $view['product'];

?><div itemscope itemtype="http://schema.org/Product" id="/p<?= $product->rndurl ?>">
    <div class="row half-gutter rtl"  id="product-page">
        <meta itemprop="name" content="<?= $product->name ?>"/>
        <loading class="fade" ng-class="{show:product.partial || !loaded}"></loading>
        <div class="col-12 ">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">صفحه اصلی</a>
                    </li>
                    <li class="breadcrumb-item" ng-repeat="b in product.breadcrumb" ng-class="{active:$last}">
                        <a href="/c{{b.id}}/{{b.url}}">{{b.title}}</a>
                    </li>
                </ol>
            </nav>
        </div>
        <spinner></spinner>
        <div class="col-sm-6 fade" ng-class="{show:product}">

            <div class="card no-paddin">
                <div class="card-body p-0">
                    <div id="prodSlider" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item" ng-class="{active:$first}" ng-repeat="img in getImgs(product,true)">
                                <img class="d-block w-100" itemprop="image" src="<?= $product->getImage(0, true) ?>" alt="<?= $product->name ?>">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#" data-target="#prodSlider" role="button" data-slide="prev" ng-if="product.imgs>1">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#" data-target="#prodSlider" role="button" data-slide="next" ng-if="product.imgs>1">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row half-gutter" ng-if="product.imgs>1">
                <div class="col-3" ng-repeat="img in getImgs(product)">
                    <div class="card">
                        <div class="card-body p-0 text-default-light">
                            <a href="#" data-target="#prodSlider" data-slide-to="{{$index}}">
                                <img class="img-fluid rounded btn-block" ng-src="{{img}}" alt="{{product.name}}"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-right">
                    <p>با دوستان خود به اشتراک بگذارید و نظر آنها را بپرسید</p>
                    <a href="https://t.me/share/url?url=https://boilerplate.com/p{{product.rndurl}}&text={{product.name}}" target="_blank" class="btn btn-light btn-icon">
                        <svg class="icon">
                            <use xlink:href="#telegram"></use>
                        </svg>
                    </a>
                    <a href="https://plus.google.com/share?url=https://boilerplate.com{{product.link}}&text={{product.name}}" target="_blank" class="btn btn-light btn-icon">
                        <svg class="icon">
                            <use xlink:href="#google-plus"></use>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{product.name}}&via=boilerplate&url=https://boilerplate.com{{product.link}}" target="_blank" class="btn btn-light btn-icon">
                        <svg class="icon">
                            <use xlink:href="#twitter"></use>
                        </svg>
                    </a>
                    <!--<a href="https://twitter.com/intent/tweet?text=نظرتون چیه؟ - {{product.name}}&via=boilerplate&url=https://boilerplate.com/<?= urlencode($view['product']->url) ?>" target="_blank" class="btn btn-light btn-icon">
                    <svg class="icon">
                        <use xlink:href="#instagram"></use>
                    </svg>
                </a>-->
                    <a href="http://pinterest.com/pin/create/link/?url=https://boilerplate.com{{product.link}}" target="_blank" class="btn btn-light btn-icon">
                        <svg class="icon">
                            <use xlink:href="#pinterest"></use>
                        </svg>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-sm-6 fade" ng-class="{show:product}">
            <div class="card">
                <div class="card-body text-right rtl">
                    <h3 class="no-margin">
                        <a href="<?= $product->getLink() ?>"><?= $product->name ?></a>
                    </h3>
                    <small class="text-default-light" itemprop="sku"><?= $product->code ?></small>
                </div>
                <div class="card-body text-right rtl" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <i class="fa fa-thumb-tack pull-left text-primary" ng-click="copy('https://boilerplate.com/p/',$event)"></i>
                    <hr/>
                    <s class="old-price text-lg" ng-if="product.old_price"></s>
                    <meta itemprop="priceCurrency" content="IRR"/>
                    <meta itemprop="price" content="<?= intval($product->price * 10) ?>"/>
                    <span ng-if="product.price>0" class="price text-xxl"><?= number_format($product->price) ?></span>
                    <span ng-if="product.price>0" class="">تومان </span>
                    <link itemprop="availability" href="http://schema.org/InStock"/>
                </div>
            </div>


            <div class="card">
                <div class="card-body text-default ">
                    <div class="col-sm-12" ng-if="!product.price>0">
                        <button class="btn btn-block btn-default m-0">
                            موجودی این محصول به اتمام رسیده است
                        </button>
                    </div>
                    <div class="row half-gutter" ng-if="product.price>0">
                        <div class="col-12">
                            <a class="btn btn-block btn-success btn-lg no-margin" ng-show="product.in_cart" href="/cart">
                                به سبد خرید اضافه شد
                                <svg class="icon">
                                    <use xlink:href="#checked"></use>
                                </svg>
                            </a>
                        </div>
                        <div class="col-sm-5" ng-hide="product.in_cart">
                                <div class="form-group row half-gutter">
                                    <label for="qty" class="col-5 col-form-label rtl">تعداد:</label>
                                    <div class="col-7">
                                        <select id="qty" name="qty" class="form-control ">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="3">4</option>
                                            <option value="3">5</option>
                                            <option value="3">6</option>
                                            <option value="3">7</option>
                                            <option value="3">8</option>
                                            <option value="3">9</option>
                                            <option value="3">10</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-7">
                            <button class="btn btn-block btn-primary " ng-click="addToCart(product)" ng-hide="product.in_cart" type="button">
                                افزودن به سبد خرید
                                <svg class="icon">
                                    <use xlink:href="#cart"></use>
                                </svg>
                            </button>
                        </div>

                    </div>
                    <hr/>
                    <ul class="rtl text-right text-sm">
                        <li>حداکثر طی سه روز کاری به دست شما می رسد</li>
                        <li>سلامت فیزیکی مرسوله را تضمین می کنیم</li>
                        <li>تمامی کالا ها تولید داخل هستند</li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <div class="row half-gutter">
                        <div class="col">

                            <a href="https://telegram.me/boilerplate_com" class="btn btn-outline-info btn-block ">
                                پشتیبانی در تلگرام
                                <svg class="icon">
                                    <use xlink:href="#telegram"></use>
                                </svg>
                            </a>
                        </div>
                        <div class="col">
                            <a href="tel:09188139096" class="btn btn-outline-dark btn-block ">
                                0918-908-9096
                                <svg class="icon">
                                    <use xlink:href="#phone"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-justify text-sm">
                    <div itemprop="description"><?= $product->info ?></div>
                    <div>
                        <span class="label"><a ng-href="/t{{tag.id}}/{{tag.title}}" target="_self">{{tag.title}}</a></span>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
