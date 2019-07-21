<section ng-app="order" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li>حسابداری</li>
            <li class="active">ثبت تراکنش ها</li>
        </ol>
    </div>
    <div class="section-body contain-lg">
        <div class="card tabs-left style-default-light">
            <!-- BEGIN SEARCH BAR -->
            <div class="card-body style-primary no-y-padding">
                <form class="form form-inverse" ng-submit="filterSubmit()">
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-content">
                                <input type="text" class="form-control" id="searchInput" placeholder="جستجو"
                                       ng-model="mainSearch">
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
            <!--end .card-body -->
            <!-- END SEARCH BAR -->
            <!-- BEGIN TAB RESULTS -->
            <!-- END TAB RESULTS -->
            <!-- BEGIN TAB CONTENT -->
            <div class="card-body tab-content style-default-bright">
                <div class="tab-pane active" id="web1">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- BEGIN PAGE HEADER -->
                            <div class="margin-bottom-xxl">
								<span class="text-light text-right">
									مورد
									<span class="badge">{{page.total}}</span>
								</span>
                            </div>
                            <!--end .margin-bottom-xxl -->
                            <!-- END PAGE HEADER -->
                            <!-- BEGIN RESULT LIST -->
                            <div class="">
                                <div class="row">
                                    <div class="card card-outlined style-primary p-0 card-collapsed">
                                        <div class="card-head card-head-xs">
                                            <div class="tools">
                                                <div class="btn-group">
                                                    <button class="btn btn-icon-toggle" ng-click="sites=[]"><i
                                                            class="fa fa-refresh"></i></button>
                                                    <a class="btn btn-icon-toggle btn-collapse"><i
                                                            class="fa fa-angle-down"></i></a>
                                                </div>
                                            </div>
                                            <header><i class="fa fa-fw fa-sliders"></i></header>
                                        </div><!--end .card-head -->
                                        <div class="card-body" style="display: none;">
                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                            </div>
                                        </div><!--end .card-body -->
                                    </div>
                                </div>
                                <div class='row text-center hardfade spinner-abs' ng-class="{in:!load}">
                                    <div class='spinner '>
                                        <div class='ring1'>
                                            <div class='ring2'>
                                                <div class='ring3'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-warning hardfade rtl" ng-class="{in:transactions.length==0 }">
                                    هیچ
                                    موردی
                                    پیدا
                                    نشد!
                                </div>
                                <div>
                                    <button class="btn btn-warning btn-sm"
                                            ng-click="showNewTransaction()">
                                        <i class="fa fa-plus"></i> ثبت تراکنش
                                    </button>
                                </div>
                                 <div class="table-responsive rtl fade" ng-class="{in:load && transactions.length }">
                                    <table class="table table-bordered text-right table-hover table-condensed text-sm">
                                        <thead>
                                            <tr class="active">
                                                <th>#</th>
                                                <th th-sortable="2">عنوان</th>
                                                <th th-sortable="3">مبلغ</th>
                                                <th th-sortable="4">دریافت/واریز کننده</th>
                                                <th th-sortable="5">کد رهگیری</th>
                                                <th th-sortable="6">شماره حساب</th>
                                                <th th-sortable="1">تاریخ</th>
                                                <th th-sortable="7">ثبت کننده</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="t in transactions" title="{{t.id}}"
                                                ng-class="{loading:loading,active:selectedTrans==t.id,success:t.income}">
                                                <td>
                                                    <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showTransaction(t)">
                                                        <i class="fa fa-plus-circle fa-lg"></i>
                                                    </button>
                                                </td>
                                                <td>{{t.title}}</td>
                                                <td class="">{{t.amount|number}}</td>
                                                <td>{{t.subject}}</td>
                                                <td>{{t.refnum}}</td>
                                                <td>{{t.accnumber}}</td>
                                                <td>{{t.paydate | jdate:'jYYYY/jMM/jDD _ jMMMM'}}</td>
                                                <td title="{{t.created|jdate}}">{{t.staff_name}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <paging page="page.number" page-size="page.size" total="page.total" adjacent="false"
                                        show-prev-next="true"
                                        paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"></paging>
                            </div>
                        </div>
                        <!--end .col -->
                    </div>
                    <!--end .row -->
                </div>
                <!--end .tab-pane -->
            </div>
            <!--end .card-body -->
            <!-- END TAB CONTENT -->
        </div>
        <!--end .card -->
    </div>
    <!--end .section-body -->
    <div class="modal fade" id="addNewTransaction" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">ثبت تراکنش</h4>
                </div>
                <form class="rtl" role="form" name="newTransactionForm">
                    <div class="modal-body">
                        <div class="card card-outlined no-margin" ng-class="{'style-success':newTransaction.income,'style-danger':!newTransaction.income}">
                            <!--end .card-head -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label">نوع تراکنش</label>
                                    <div class="col-xs-12 ltr">
                                        <label class="radio-inline radio-styled radio-success">
                                            <input type="radio" name="newTransIncome" ng-value="true" ng-model="newTransaction.income">
                                            <span>درآمد</span>
                                        </label>
                                        <label class="radio-inline radio-styled radio-danger">
                                            <input type="radio" name="newTransIncome" ng-value="false" ng-model="newTransaction.income">
                                            <span>هزینه</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="control-label">مبلغ (فقط عدد)</label>
                                            <input ng-model="newTransaction.amount" class="form-control ltr" required/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">عنوان</label>
                                            <input ng-model="newTransaction.title" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">تاریخ</label>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="input-group ltr no-gutter">
                                                <div class="col-xs-4">
                                                    <div class="input-group">
                                                        <select type="text" class="form-control"
                                                                ng-model="newTransaction.day" required ng-options="day for day in range(1,31)">
                                                        </select>
                                                        <span class="input-group-addon"
                                                              style="border-radius: 0">/</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="input-group">
                                                    <select type="text" class="form-control"
                                                            ng-model="newTransaction.month" required>
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
                                                     <span class="input-group-addon"
                                                           style="border-radius: 0">/</span>
                                                </div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <select type="text" class="form-control"
                                                            ng-model="newTransaction.year" required
                                                            ng-options="year for year in range(1394,1400)"></select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">کد پیگیری (سریال یا شماره ارجاع)</label>
                                    <input type="text" ng-model="newTransaction.refnum" class="form-control"
                                           placeholder="کد پیگیری">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">شماره حساب</label>
                                    <input type="text" ng-model="newTransaction.accnumber" class="form-control"
                                           placeholder="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">دریافت/واریز کننده</label>
                                    <input type="text" ng-model="newTransaction.subject" class="form-control"
                                           placeholder="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label ">توضیحات</label>
                                    <textarea ng-model="newTransaction.info" class="form-control input-sm"
                                           rows="4" >
                                        </textarea>
                                </div>
                            </div><!--end .card-body -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
                        <button class="btn ink-reaction btn-raised btn-accent" data-dismiss="modal"
                                ng-click="saveTransaction()" ng-disabled="newTransactionForm.$invalid"
                                ng-class="{loading:saving}">
                            ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>