<section ng-app="dashboard" ng-controller="ctrl">
    <div class="section-body">
        <div class="row">
            <!-- BEGIN ALERT - REVENUE -->
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="alert alert-callout alert-info no-margin p-0" style=" border: none; ">
                            <a class="btn btn-default-bright btn-block" href="items?status=2&v=2&sort=-1"
                               target="_self">
                                <div>
                                    <span class="opacity-50 ">کالا در انتظار خرید</span>
                                    <span class="text-xl pull-right"><?= (OrderItemRepository::countWithStatus(2)); ?></span>
                                </div>
                                <br/>
                            </a>
                        </div>
                    </div>
                    <!--end .card-body -->
                </div>
                <!--end .card -->
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="alert alert-callout alert-warning no-margin p-0" style=" border: none; ">
                            <a class="btn btn-default-bright btn-block" href="package-que"
                               target="_self">
                                <div>
                                    <span class="opacity-50 ">کالا در انتظار بسته بندی</span>
                                    <span class="text-xl pull-right"><?= (OrderItemRepository::countWithStatus(9)+OrderItemRepository::countWithStatus(8)); ?></span>
                                </div>
                                <br/>
                            </a>
                        </div>
                    </div>
                    <!--end .card-body -->
                </div>
                <!--end .card -->
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="alert alert-callout alert-success no-margin p-0" style=" border: none; ">
                            <a class="btn btn-default-bright btn-block" href="post?s=1"
                               target="_self">
                                <div>
                                    <span class="opacity-50 "> بسته در نوبت ارسال</span>
                                    <span class="text-xl pull-right"><?= (ShipmentRepository::countReady()); ?></span>
                                </div>
                                <br/>
                            </a>
                        </div>
                    </div>
                    <!--end .card-body -->
                </div>
                <!--end .card -->
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="alert alert-callout alert-danger no-margin p-0" style=" border: none; ">
                            <a class="btn btn-default-bright btn-block" href="order-control?sort=2"
                               target="_self">
                                <div>
                                    <span class="opacity-50 "> خرید ناقص در انتظار بررسی</span>
                                    <span class="text-xl pull-right">0</span>
                                </div>
                                <br/>
                            </a>
                        </div>
                    </div>
                    <!--end .card-body -->
                </div>
                <!--end .card -->
            </div>



        </div>
        <!--end .row -->
        <?php //AuthorizationService::hasPermission(Permission::DAILY_SALES_CHART)
        if (true) echo'
        <div class="row">
            <!-- BEGIN SITE ACTIVITY -->
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-head" ng-class="{loading:loadingChart}">
                        <header class="col-md-10" >کارکرد سایت
                            <div class="btn-group btn-group-xs pull-right btn-group-hideinput">
                                <label class="btn btn-primary " ng-repeat="t in chartTypes"
                                       ng-class="{active:t.id==chartType}">
                                    <input type="radio" name="chartType" ng-model="$parent.chartType" ng-value="t.id"
                                           ng-change="loadChartData()"> {{t.label}}
                                </label>
                            </div>
                        </header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body" ng-cloak>
                        <div class="col-md-10">
                           <canvas id="orderChart"  height="400"></canvas>
                        </div>
                            <div class="col-md-2 rtl"> 
                                <span>مجموع سفارشات:</span> 
                                <span class="pull-left text-danger">{{curOrders|number}}</span> 
                                <hr class="style-primary"/>
                                <span>مجموع پرداخت ها:</span> 
                                <span class="pull-left text-info">{{curPayments|number}}</span> 
                                <hr class="style-primary"/>
                                <span>پرداخت آنلاین:</span> 
                                <span class="pull-left text-default">{{curOnlinePayments|number}}</span> 
                                <hr class="style-primary"/>
                                <span>واریز وجه:</span> 
                                <span class="pull-left text-default">{{curCashPayments|number}}</span> 
                                <hr class="style-primary"/>
                                <span>واریزی سامان</span> 
                                <span class="pull-left text-default">{{curSaman|number}}</span> 
                                <hr class="style-primary"/>
                                <header class="text-center">{{curDate}}</header> 
                            </div>
                    </div>
                </div>
                <!--end .row -->
            </div>
            <!--end .card -->
        </div>';
        ?>
        <div class="row">
            <!-- BEGIN SITE ACTIVITY -->
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-head">
                        <div class="card-body style-primary no-y-padding">
                            <form class="form form-inverse" action="users" method="get">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-content">
                                            <input type="text" class="form-control" name="q" placeholder="جستجوی کاربران" ng-model="mainSearch">
                                            <div class="form-control-line"></div>
                                        </div>
                                        <div class="input-group-btn">
                                            <button class="btn btn-floating-action btn-default-bright" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--end .form-group -->
                            </form>
                        </div>
                        <header class="text-center btn-block"><i class="fa fa-users"></i> آخرین کاربران فعال</header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body">

                        <div class="table-responsive rtl fade" ng-class="{in:userLoad && users.length }">
                            <table class="table no-margin text-right table-hover table-condensed">
                                <thead>
                                <tr class="active">
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>شماره تماس</th>
                                    <th>شهر</th>
                                    <th>گروه</th>
                                    <th>اعتبار</th>
                                    <th>عضویت</th>
                                    <th>آخرین ورود</th>
                                    <th>اخرین سفارش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="user in users"  title="{{user.id}}">
                                    <td> <a class="btn btn-default btn-sm btn-block ink-reaction btn-raised" target="_blank"
                                            href="user-{{user.id}}">
                                            <i class="fa fa-plus-circle fa-lg"></i>
                                        </a></td>
                                    <td>
                                        <a  href="user-{{user.id}}" target="_blank" >{{user.fname }} {{ user.lname }}</a></td>
                                    <td><a  href="user-{{user.id}}" target="_blank" >{{user.tel}}</a></td>
                                    <td>{{user.province }} - {{ user.city }}</td>
                                    <td>{{user.group_name}}</td>
                                    <td class="ltr" style="color : {{user.balance<0?'red':'green'}}">{{user.balance|number:0}}</td>
                                    <td >{{user.created|jdate:' '}}</td>
                                    <td >{{user.last_login|jdate:' '}}</td>
                                    <td >{{user.last_order|jdate:' '}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!--end .card-body -->
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <!--end .card -->
        </div>
        <div class="row">
            <!-- BEGIN SITE ACTIVITY -->
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-head">
                        <header class="text-center btn-block">
                            <a href="users?sort=-4,-5&debt=true" target="_self" ><i class="fa fa-users"></i> کاربران بدهکار</a></header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body">

                        <div class="table-responsive rtl fade" ng-class="{in:debtorLoad && debtors.length }">
                            <table class="table no-margin text-right table-hover table-condensed text-sm">
                                <thead>
                                <tr class="active">
                                    <th>نام</th>
                                    <th>تلفن</th>
                                    <th>اعتبار</th>
                                    <th>عضویت</th>
                                    <th>آخرین ورود</th>
                                    <th>اخرین سفارش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="user in debtors"  title="{{user.id}}">
                                    <td>
                                        <a href="user-{{user.id}}" target="_blank">{{user.fname }} {{ user.lname }}
                                        </a>
                                    </td>
                                    <td>{{user.tel}}</td>
                                    <td class="ltr" style="color : {{user.balance<0?'red':'green'}}">{{user.balance|number:0}}</td>
                                    <td  title="{{user.created|jdate}}">{{user.created|jdate:' '}}</td>
                                    <td  title="{{user.last_login|jdate}}">{{user.last_login|jdate:' '}}</td>
                                    <td  title="{{user.last_order|jdate}}">{{user.last_order|jdate:' '}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end .card-body -->
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-head">
                        <header class="text-center btn-block">
                            <a href="order?status=1&cart=true&sort=1" target="_self" ><i class="fa fa-th-list"></i> سفارش های پرداخت نشده</a></header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body">

                        <div class="table-responsive rtl fade" ng-class="{in:ordersNotPaidLoad && ordersNotPaid.length }">
                            <table class="table no-margin text-right table-hover table-condensed text-sm">
                                <thead>
                                <tr class="active">
                                    <th>نام</th>
                                    <th>تلفن</th>
                                    <th>کد سفارش</th>
                                    <th>مبلغ سفارش</th>
                                    <th>تعداد کالا</th>
                                    <th>زمان ثبت</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="order in ordersNotPaid"  title="{{order.id}}">
                                    <td>
                                        <a href="user-{{order.user_id}}#o={{order.id}}" target="_blank">{{order.user_name
                                                                                                        }}
                                        </a>
                                    </td>
                                    <td ">{{order.tel}}</td>
                                    <td>
                                        <a href="user-{{order.user_id}}#o={{order.id}}" target="_blank">{{order.code
                                                                                                        }}
                                        </a>
                                    </td>
                                    <td>{{order.final_price| currency:'':0}}</td>
                                    <td>{{order.qty}}</td>
                                    <td  title="{{order.created|jdate}}">{{order.created|jdate:' '}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end .card-body -->
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <!--end .card -->
        </div>


        <div class="row">
            <!-- BEGIN SITE ACTIVITY -->
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-head">
                        <header class="">بازدید سایت

                        </header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body">
                        <div id="chart-1-container"></div>
                    </div>
                    <!--end .card-body -->
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <!--end .card -->
        </div>

        <div class="row">
            <!-- BEGIN SITE ACTIVITY -->
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-head">
                        <header >صفحات پر بازدید

                        </header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body">
                        <div class="col-sm-6">
                            <div id="chart-2-container"></div>
                        </div>
                        <div class="col-sm-6">
                            <div id="chart-3-container"></div>
                        </div>

                    </div>
                    <!--end .card-body -->
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <!--end .card -->
        </div>


        <div class="row">
            <!-- BEGIN SITE ACTIVITY -->
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-head">
                        <header >سایت های هدایت کننده کاربران به boilerplate</header>
                    </div>
                    <!--end .card-head -->
                    <div class="card-body">
                        <div class="col-sm-6">
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class="rtl">منبع (ماه گذشته)</th>
                                        <th>تعداد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="refer in referralLastMonth">
                                        <td>{{$index+1}}</td>
                                        <td>
                                            <small>{{refer.ref}}</small>
                                        </td>
                                        <td>{{refer.count}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class="rtl">منبع (امروز)</th>
                                        <th>تعداد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="refer in referralToday">
                                        <td>{{$index+1}}</td>
                                        <td>
                                            <small>{{refer.ref}}</small>
                                        </td>
                                        <td>{{refer.count}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!--end .card-body -->
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <!--end .card -->
        </div>






        <!--end .col -->
    </div>
    <!--end .row -->
    </div>
</section>