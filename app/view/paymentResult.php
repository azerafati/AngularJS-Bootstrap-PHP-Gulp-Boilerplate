<div class="col-12 col-sm-12 col-md-10 offset-md-1" >
    <h2 class=" text-center text-accent">
        نتیجه پرداخت <i class="fa fa-credit-card fa-lg"></i>
    </h2>
    <hr/>
    <div class="row half-gutter">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body text-default-dark">
                    <?php if(!$view['payment']->ok):?>
                        <div class="alert alert-warning text-right" id="noProd">
                            متاسفانه پرداخت شما به دلیل زیر تایید نشده است. <i class="fa fa-warning"></i>
                            <ul class="rtl">
                                <li>خطا: <?= $view['payment']->msg ?></li>
                                <li>کد پیگیری بانک : <?= $view['payment']->tracecode??'' ?></li>
                                <li>تاریخ : <?= Util::persianDate($view['payment']->created); ?></li>
                            </ul>

                            <a class="btn btn-primary up-2" href="/orders">
                                پرداخت دوباره <i class="fa fa-arrow-right"></i>
                            </a>
                            <a class="btn btn-outline-secondary up-2" href="/">
                                بازگشت به صفحه اصلی <i class="fa fa-home"></i>
                            </a>
                        </div>
                    <?php endif;?>
                    <?php if($view['payment']->ok):?>
                        <div class="alert alert-success text-right  " id="noProd">
                            <h4>
                                boilerplate از خرید شما تشکر می کند <i class="fa fa-check-circle fa-lg"></i>
                            </h4>
                            <ul class="rtl">
                                <li>مبلغ پرداخت شده: <?= number_format($view['payment']->amount); ?></li>
                                <li>کد پیگیری بانک : <?= $view['payment']->tracecode??'' ?></li>
                                <li>تاریخ : <?= Util::persianDate($view['payment']->created); ?></li>
                            </ul>

                            <a class="btn btn-primary up-2" href="/">
                                بازگشت به صفحه اصلی <i class="fa fa-home"></i>
                            </a>

                        </div>
                    <?php endif;?>


                </div>

            </div>
        </div>
    </div>


</div>