<section ng-app="order" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li>حسابداری</li>
            <li class="active">محاسبه سود</li>
        </ol>
    </div>
    <div class="section-body contain-lg">
        <div class="card style-default-light">
            <!-- BEGIN SEARCH BAR -->
            <div class="card-head card-head-xs style-primary">
                <header>
                    <div class="form-group">
                        <div class="col-xs-12 ltr">
                            <label class="radio-inline radio-styled radio-default-dark">
                                <input type="radio" name="newTransIncome" ng-value="true" ng-model="monthly"
                                       ng-change="filterSubmit()">
                                <span>ماهیانه</span>
                            </label>
                            <label class="radio-inline radio-styled radio-default-dark">
                                <input type="radio" name="newTransIncome" ng-value="false" ng-model="monthly"
                                       ng-change="filterSubmit()">
                                <span>بازه زمانی</span>
                            </label>
                        </div>
                    </div>
                </header>
            </div>
            <!--end .card-body -->
            <!-- END SEARCH BAR -->
            <!-- BEGIN TAB RESULTS -->
            <!-- END TAB RESULTS -->
            <!-- BEGIN TAB CONTENT -->
            <div class="card-body tab-content style-default-bright">
                <div class="row" ng-show="monthly">
                    <div class="col-sm-8">
                        <div class="input-group ltr no-gutter">
                            <div class="col-sm-4 col-md-3">
                                <div class="input-group input-group-sm">
                                    <select type="number" class="form-control" ng-model="month"
                                            ng-change="filterSubmit()">
                                        <option value="1">فروردین</option>
                                        <option value="2">اردیبهشت</option>
                                        <option value="3">خرداد</option>
                                        <option value="4">تیر</option>
                                        <option value="5">مرداد</option>
                                        <option value="6">شهریور</option>
                                        <option value="7">مهر</option>
                                        <option value="8">آبان</option>
                                        <option value="9">آذر</option>
                                        <option value="10">دی</option>
                                        <option value="11">بهمن</option>
                                        <option value="12">اسفند</option>
                                    </select>
                                    <span class="input-group-addon" style="border-radius: 0">/</span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <select type="number" class="form-control input-sm" ng-model="year"
                                        ng-change="filterSubmit()"
                                        ng-options="year.toString() as year for year in range(1394,1400)"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" ng-show="!monthly">
                    <div class="col-sm-5">
                        <div class="input-group ltr no-gutter">
                            <div class="col-xs-4 col-md-3">
                                <div class="input-group">
                                    <select type="text" class="form-control input-sm" ng-model="period.ed" required
                                            ng-options="day for day in range(1,31)" ng-change="filterSubmit()"></select>
                                                        <span class="input-group-addon"
                                                              style="border-radius: 0">/</span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <div class="input-group input-group-sm">
                                    <select type="number" class="form-control" ng-model="period.em"
                                            ng-change="filterSubmit()">
                                        <option value="1">فروردین</option>
                                        <option value="2">اردیبهشت</option>
                                        <option value="3">خرداد</option>
                                        <option value="4">تیر</option>
                                        <option value="5">مرداد</option>
                                        <option value="6">شهریور</option>
                                        <option value="7">مهر</option>
                                        <option value="8">آبان</option>
                                        <option value="9">آذر</option>
                                        <option value="10">دی</option>
                                        <option value="11">بهمن</option>
                                        <option value="12">اسفند</option>
                                    </select>
                                    <span class="input-group-addon" style="border-radius: 0">/</span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <select type="number" class="form-control input-sm" ng-model="period.ey"
                                        ng-change="filterSubmit()"
                                        ng-options="year.toString() as year for year in range(1394,1400)"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">تا</div>
                    <div class="col-sm-5">
                        <div class="input-group ltr no-gutter">
                            <div class="col-xs-4 col-md-3">
                                <div class="input-group">
                                    <select type="text" class="form-control input-sm" ng-model="period.sd" required
                                            ng-options="day for day in range(1,31)" ng-change="filterSubmit()"></select>
                                                        <span class="input-group-addon"
                                                              style="border-radius: 0">/</span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <div class="input-group input-group-sm">
                                    <select type="number" class="form-control" ng-model="period.sm"
                                            ng-change="filterSubmit()">
                                        <option value="1">فروردین</option>
                                        <option value="2">اردیبهشت</option>
                                        <option value="3">خرداد</option>
                                        <option value="4">تیر</option>
                                        <option value="5">مرداد</option>
                                        <option value="6">شهریور</option>
                                        <option value="7">مهر</option>
                                        <option value="8">آبان</option>
                                        <option value="9">آذر</option>
                                        <option value="10">دی</option>
                                        <option value="11">بهمن</option>
                                        <option value="12">اسفند</option>
                                    </select>
                                    <span class="input-group-addon" style="border-radius: 0">/</span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <select type="number" class="form-control input-sm" ng-model="period.sy"
                                        ng-change="filterSubmit()"
                                        ng-options="year.toString() as year for year in range(1394,1400)"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row text-center fade ' ng-class="{in:!load}">
                    <div class='spinner '>
                        <div class='ring1'>
                            <div class='ring2'>
                                <div class='ring3'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card card-bordered style-default">
                            <div class="card-head card-head-xs rtl">
                                <header><i class="fa fa-fw fa-circle"></i> {{start|jdate}} تا {{end|jdate}}</header>
                            </div><!--end .card-head -->
                            <div class="card-body style-default-bright p-0">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="table-responsive rtl fade" ng-class="{in:load }">
                                            <table class="table table-bordered text-right table-hover no-margin">
                                                <thead>
                                                <tr class="active">
                                                    <th style="width: 50px">#</th>
                                                    <th style="width: 50px"></th>
                                                    <th>عنوان</th>
                                                    <th class="col-xs-2"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>4-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل هزینه پست و بسته بندی</td>
                                                    <td>{{shipment_pkg|number}}</td>
                                                </tr>
                                                <tr>
                                                    <td>1-4-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل هزینه های پست</td>
                                                    <td>{{shipment|number}}</td>
                                                </tr>
                                                <tr>
                                                    <td>2-4-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل هزینه های بسته بندی</td>
                                                    <td>{{pkg|number}}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل فاکتور ها ({{orders_count|number}} عدد)
                                                    </td>
                                                    <td>{{final_price|number}}</td>
                                                </tr>
                                                <tr>

                                                    <td colspan="4" class="text-sm">متوسط قیمت کالا ها {{price_tr/qty|number:0}} لیر و متوسط نرخ لیر {{item_price/price_tr|number:0}} تومان و متوسط قیمت تمام شده هر لیر {{final_price/price_tr|number:0}} تومان است</td>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="table-responsive rtl fade" ng-class="{in:load }">
                                            <table class="table table-bordered text-right table-hover no-margin">
                                                <thead>
                                                <tr class="active">
                                                    <th style="width: 50px">#</th>
                                                    <th style="width: 50px"></th>
                                                    <th>عنوان</th>
                                                    <th class="col-xs-2"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>تعداد کالاهای فروخته شده
                                                    </td>
                                                    <td> {{qty|number:0}} عدد</td>
                                                </tr>
                                                <tr>
                                                    <td>1-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل قیمت کالاهای فروخته شده</td>
                                                    <td> {{item_price|number:0}}</td>
                                                </tr>
                                                <tr>
                                                    <td>2-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل کارگو</td>
                                                    <td>{{cargo|number:0}}</td>
                                                </tr>
                                                <tr>
                                                    <td>3-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td>مجموع کل هزینه ارسال خارج از کشور</td>
                                                    <td>{{import|number}}</td>
                                                </tr>
                                                <tr>
                                                    <td>1-3-2</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                            <i class="fa fa-plus-circle fa-lg"></i>
                                                        </button>
                                                    </td>
                                                    <td> مجموع کل وزن کالای فروخته شده (کیلوگرم)</td>
                                                    <td>{{weight/1000|number}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .card-body -->
                        </div>
                    </div>
                    <!--end .col -->
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-bordered style-info">
                            <div class="card-head card-head-xs rtl">
                                <header><i class="fa fa-fw fa-circle"></i> هزینه ها</header>
                            </div><!--end .card-head -->
                            <div class="card-body style-default-bright p-0">
                                <div class="table-responsive rtl fade" ng-class="{in:load }">
                                    <table class="table table-bordered text-right table-hover no-margin">
                                        <thead>
                                        <tr class="active">
                                            <th style="width: 30px">#</th>
                                            <th style="width: 50px"></th>
                                            <th>عنوان</th>
                                            <th class="col-xs-2">مبلغ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>تعداد {{qty|number:0}} کالا ({{price_tr|number:0}} لیر) خریداری شده</td>
                                            <td>{{netprice|number:0}}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>مجموع هزینه های ارسال از ترکیه با وزن کل
                                                {{shipment_iran_weight/1000|number:0}}
                                                کیلو گرم
                                            </td>
                                            <td>{{shipment_iran_cost|number}}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>مجموع هزینه های جانبی</td>
                                            <td>{{expense|number}}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>مجموع مبلغ برگشت داده شده به مشتریان</td>
                                            <td>{{payment_returned|number}}</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr class="active">
                                            <th colspan="3" class="text-center ">مجموع</th>
                                            <th>{{total_expense|number:0}}</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div><!--end .card-body -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card card-bordered style-success">
                            <div class="card-head card-head-xs rtl">
                                <header><i class="fa fa-fw fa-circle"></i> درآمد ها</header>
                            </div><!--end .card-head -->
                            <div class="card-body style-default-bright p-0">
                                <div class="table-responsive rtl fade" ng-class="{in:load }">
                                    <table class="table table-bordered text-right table-hover no-margin ">
                                        <thead>
                                        <tr class="active">
                                            <th style="width: 30px">#</th>
                                            <th style="width: 50px"></th>
                                            <th>عنوان</th>
                                            <th class="col-xs-2">مبلغ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>مجموع پرداخت های آنلاین</td>
                                            <td>{{payment_online|number}}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>مجموع پرداخت های نقدی و کارت به کارت</td>
                                            <td>{{payment_cash|number}}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>
                                                <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                        ng-click="showTransaction(t)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>مجموع درآمدهای های جانبی</td>
                                            <td>{{income|number}}</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr class="active">
                                            <th colspan="3" class="text-center ">مجموع</th>
                                            <th>{{total_income|number:0}}</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div><!--end .card-body -->
                        </div>
                    </div>
                    <!--end .col -->
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <button class="btn btn-block btn-accent ">
                            {{profit|number:0}}
                        </button>
                    </div>
                    <!--end .col -->
                </div>
                <!--end .row -->
            </div>
            <!--end .card-body -->
            <!-- END TAB CONTENT -->
        </div>
        <!--end .card -->
    </div>
    <!--end .section-body -->
</section>