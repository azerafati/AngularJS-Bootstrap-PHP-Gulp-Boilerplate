<section ng-app="userPage" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li class="active">مشتری</li>
        </ol>
    </div>
    <div class="section-body contain-lg" ng-cloak>
        <div class="card tabs-below style-primary card-outlined card-underline"
             ng-class="{'style-danger':user.balance<0}">
            <!-- BEGIN SEARCH BAR -->
            <div class="card-head" ng-cloak>
                <header class="rtl">
                    <small>{{user.tel}}</small>
                    &nbsp;&nbsp; {{user.fname}} {{user.lname}}
                </header>
                <header class="pull-right">
                    <small class="rtl inline"> عضویت: {{user.created | jdate:' '}}</small>
                </header>
            </div>
            <div class="card-body tab-content style-default-bright">
                <div class="tab-pane" id="userinfo">
                    <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <table class="table rtl text-right fade" ng-class="{in:user}">
                                    <tbody>
                                    <tr>
                                        <th>نام</th>
                                        <td az-editable="fname" ng-model="user"
                                            class="abs"></td>
                                    </tr>
                                    <tr>
                                        <th>نام خانوادگی</th>
                                        <td az-editable="lname" ng-model="user"
                                            class="abs">
                                            {{user.lname}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ایمیل</th>
                                        <td az-editable="email" ng-model="user"
                                            class="abs">
                                            {{user.email}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>تلفن</th>
                                        <td az-editable="tel" ng-model="user" class="abs">
                                            {{user.tel}}
                                        </td>
                                    </tr>
                                    <?php if (AuthorizationService::hasPermission(Permission::USER_MANAGEMENT)) echo'
                                    <tr>
                                        <th>گروه</th>
                                        <td>
                                            <select class="form-control input-sm" ng-model="user.user_group_id"
                                                    ng-change="changeGroup()"
                                                    ng-options="group.id as group.name for group in user.groups"></select>
                                        </td>
                                    </tr>'
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="row">

                        <div class="form-group rtl ">
                            <textarea id="info" type="text" class="form-control" rows="8" ><?= $view['user']->info ?></textarea>
                            <label>توضیحات</label>
                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="sms">
								<span class="text-light text-right">
									مورد
									<span class="badge">{{pageSms.total}}</span>
								</span>

                    <div class="modal fade" id="newSMS" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="formModalLabel">ارسال اس ام اس</h4>
                                </div>
                                <form class="rtl" role="form" name="newSMSForm">
                                    <div class="modal-body">
                                        <div class="card card-outlined no-margin" ng-class="{'style-success':newTransaction.income,'style-danger':!newTransaction.income}">
                                            <!--end .card-head -->
                                            <div class="card-body">



                                                <div class="form-group">
                                                    <label class="control-label">شماره موبایل</label>
                                                    <input type="text" ng-model="newSMS.number" readonly class="form-control ltr"
                                                           >
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label ">پیام</label>
                                                    <textarea ng-model="newSMS.msg" class="form-control input-sm"
                                                              rows="4" >
                                        </textarea>
                                                </div>
                                                <p>تعداد پیامک : {{countSMS()}}</p>
                                            </div><!--end .card-body -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
                                        <button class="btn ink-reaction btn-raised btn-accent" data-dismiss="modal"
                                                ng-click="saveSMS()" ng-disabled="newSMSForm.$invalid"
                                                ng-class="{loading:saving}">
                                            ارسال
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="list-chats height-12" style="overflow-y: scroll;" id="sms-list">
                        <li ng-class="{'chat-left':sms.incoming}" ng-repeat="sms in smss| orderBy:'-'">
                            <div class="chat">
                                <div class="chat-avatar"></div>
                                <div class="chat-body">
                                    <p ng-bind-html="sms.msg | url"></p>
                                    <small class="rtl">{{sms.created | jdate}} <a href="user-{{sms.staff_id}}" ng-if="sms.staff_id && !sms.incoming" target="_self">{{sms.staff_name}}</a> <span ng-if="!sms.staff_id && !sms.incoming">سیستم</span></small>
                                </div>
                            </div> <!--end .chat -->
                        </li>
                    </ul>

                    <div class="table-responsive rtl fade hidden" ng-class="{in:load && smss.length }">
                        <table class="table table-bordered text-right table-hover table-condensed text-sm">
                            <thead>
                                <tr class="active">
                                    <th>#</th>
                                    <th th-sortable="2">مشتری</th>
                                    <th th-sortable="3">شماره</th>
                                    <th th-sortable="4" class="col-sm-3">پیام</th>
                                    <th th-sortable="1">وضعیت</th>
                                    <th th-sortable="1">تاریخ</th>
                                    <th th-sortable="7">ثبت کننده</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="sms in smss" title="{{sms.id}}"
                                    ng-class="{loading:loading,active:selectedSms==sms.id,success:sms.incoming}">
                                    <td>
                                        <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                ng-click="showTransaction(t)">
                                            <i class="fa fa-plus-circle fa-lg"></i>
                                        </button>
                                    </td>
                                    <td>{{sms.user}}</td>
                                    <td>
                                        <a href="users?q={{sms.number}}" target="_blank">{{sms.number}}</a>
                                    </td>
                                    <td>{{sms.msg}}</td>
                                    <td>
                                        <span class="label label-fa label-success" ng-show="sms.sent">ارسال شد</span>
                                        <span class="label label-fa label-warning" ng-show="!sms.sent">در نوبت ارسال</span>
                                    </td>
                                    <td class="text-sm">{{sms.created|jdate}}</td>
                                    <td title="">{{sms.staff_name}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <paging page="pageSms.number" page-size="pageSms.size" total="pageSms.total" adjacent="false"
                            show-prev-next="true"
                            paging-action="DoCtrlPagingActSms(page)">
                    </paging>
                    <div>
                        <button class="btn btn-warning btn-sm pull-right" style="margin-top:auto"
                                data-target="#newSMS" data-toggle="modal">
                            <i class="fa fa-plus"></i> ارسال پیامک
                        </button>
                    </div>

                </div>
                <div class="tab-pane" id="agencyinfo">
                    <div class="row">
                        <!-- BEGIN ALERT - REVENUE -->
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="alert alert-callout alert-info no-margin p-0" style=" border: none; ">
                                        <a class="btn btn-default-bright btn-block" href="user-{{agencyInfo.id}}"
                                           target="_self">
                                            <div>
                                                <span class="opacity-50 ">اعتبار</span>
                                                <span
                                                    class="text-xl pull-right">{{agencyInfo.balance|number}}</span>
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
                                        <a class="btn btn-default-bright btn-block" href="#"
                                           target="_self">
                                            <div>
                                                <span class="opacity-50 ">مجموع سفارشات</span>
                                                <span
                                                    class="text-xl pull-right">{{userInfo.sum_orders_iranshik|number}}</span>
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
                                        <a class="btn btn-default-bright btn-block" href="order?agency={{agencyInfo.id}}"
                                           target="_self">
                                            <div>
                                                <span class="opacity-50 ">جمع فروش</span>
                                                <span
                                                    class="text-xl pull-right">{{agencyInfo.sum_orders_agency|number}}</span>
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
                                        <a class="btn btn-default-bright btn-block" href="users?sort=2&agency={{agencyInfo.id}}"
                                           target="_self">
                                            <div>
                                                <span class="opacity-50 ">مشتریان</span>
                                                <span
                                                    class="text-xl pull-right">{{agencyInfo.user_count}}</span>
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
                    <div class="row">
                        <!-- BEGIN SITE ACTIVITY -->
                        <div class="col-sm-6">
                            <div class="card height-8 card-outlined style-primary">
                                <div class="card-head text-right">
                                    <header>کارکرد</header>
                                </div>
                                <div class="card-body height-6 scroll style-default-bright rtl" ng>
                                    <div class="row">
                                        <div class="col-xs-7">
                                            <h2 class="no-margin text-primary-dark text-center">
                                                <span class="text-lg ltr inline">{{unpaid_profit_counter|number}}</span>
                                            </h2>
                                        </div>
                                        <div class="col-xs-5">اعتبار تسویه نشده:</div>
                                    </div>
                                    <div class="row up-2 half-gutter">
                                        <div>آخرین پرداخت به حساب:
                                            <span ng-show="agencyInfo.last_payment">{{agencyInfo.last_payment|jdate:' '}}</span>
                                            <span class=" fa-right text-sm" ng-hide="agencyInfo.last_payment">تا بحال پرداختی به شما انجام نشده است</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <ul>
                                            <li>جهت دریافت سود و تسویه می بایست حداقل {{agencyInfo.period}} روز از تسویه حساب قبلی
                                                بگذرد.
                                            </li>
                                            <li ng-show="agencyInfo.profit>0">سود بازاریابی شما در هر فروش {{agencyInfo.profit}}
                                                درصد می باشد.
                                            </li>
                                            <li>حداقل مبلغ مورد نیاز جهت تسویه {{agencyInfo.required_credit|number}} هزار تومان است.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card height-8 card-outlined style-primary">
                                <div class="card-head text-right">
                                    <header>لینک اختصاصی کوتاه شده دعوت کاربران به عضویت</header>
                                </div>
                                <!--end .card-head -->
                                <div class="card-body" >
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" readonly="readonly" ng-model="agencyInfo.shortLink.shortLink">
                                                </div>
                                                <div class="input-group-addon">
                                                    <button class="btn btn-primary ink-reaction" type="button" data-toggle="modal" data-target="#shortLinkModal">
                                                        تغییر لینک
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="rtl text-justify">
                                    <li>بعد از قرار دادن این لینک در سایت خود و یا شبکه های اجتماعی، کسانی که از این طریق در ایران
                                        شیک عضو می شوند در تمامی خرید هایشان
                                        {{(agencyInfo.profit||0)|number}}
                                        درصد سود بازاریابی به شما تعلق می
                                        گیرد.
                                    </li>
                                </ul>

                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <!-- BEGIN SITE ACTIVITY -->
                        <div ng-class="{ 'col-sm-12': !shortLinkLoaded, 'col-sm-7': shortLinkLoaded }">
                            <div class="card height-8 card-outlined style-primary">
                                <div class="card-head text-right">
                                    <header>ایجاد لینک کوتاه کالاها
                                    </header>
                                </div>
                                <!--end .card-head -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-content">
                                                        <input type="text" class="form-control" ng-model="shortLink.link" id="groupbutton9">
                                                        <label for="groupbutton9">لینک کالا را از سایت خارجی به اینجا کپی کنید</label>
                                                    </div>
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-primary" type="button" ng-click="createShortLink()" ng-class="{loading:shortLink.loading}">
                                                            ایجاد لینک
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr class="style-default-dark">
                                    <ul class="rtl text-right">
                                        <li>لینک کوتاه شده را در شبکه های اجتماعی و یا سایت خود قرار دهید تا هر کسی که از طریق این لینک
                                            وارد ایران شیک می شود و خرید انجام می دهد سود بازاریابی آن به شما تعلق بگیرد.
                                        </li>
                                        <li>
                                            با کلیک بر روی لینک کوتاه، محصول بدون انجام هیچ کاری به سبد خرید اضافه می شود.
                                        </li>
                                        <li>
                                            اگر قیمت اصلی محصول را تغییر بدهید ما به التفاوت آن در اعتبار شما محاسبه می شود.
                                        </li>
                                    </ul>
                                </div>
                                <!--end .card-body -->
                                <!--end .col -->
                            </div>
                            <!--end .row -->
                        </div>
                        <div class="col-sm-5">
                            <div class="card height-8 card-outlined style-primary" ng-show="shortLinkLoaded">
                                <div class="card-head text-right">
                                    <header  ng-show="shortLink.shortLink && shortlink.is_product"> لینک کوتاه شده اضافه به سبد خرید کالا </header>
                                    <header  ng-show="shortLink.shortLink && !shortlink.is_product"> لینک دعوت از کاربران جهت مشاهده کالاها </header>
                                </div>
                                <!--end .card-head -->
                                <div class="card-body hardfade" ng-class="{in:shortLink.shortLink && shortlink.is_product}">
                                    <div class="row">
                                        <div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" ng-model="shortLink.shortLink" ng-class="{loading:shortLink.loading}">
                                            </div>
                                        </div>
                                        <div class="row no-gutter">
                                            <div class="col-sm-4">
                                                <img ng-src="{{shortLink.img}}" width="85" alt="">
                                            </div>
                                            <div class="rtl col-sm-8 fade in text-justify" ng-class="{in:!shortLink.loading}">
                                                <span>قیمت محصول :</span>
                                                <b> {{shortLink.price|number}} </b>
                                                <span>تومان برای گروه مشتری های عادی شما می باشد. اگر بخواهید می توانید قیمت دلخواه خود را برای این محصول ثبت کنید</span>
                                                <div class="form-group ltr">
                                                    <div class="input-group">
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" ng-model="shortLink.agency_price" id="groupbutton9">
                                                            <label for="groupbutton9">قیمت همکار فروش</label>
                                                        </div>
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-primary" type="button" ng-click="saveAgencyPrice()" ng-class="{loading:shortLink.loading}">
                                                                ثبت
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body hardfade" ng-class="{in:shortLink.shortLink && !shortlink.is_product}">
                                    <div class="row">
                                        <div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" ng-model="shortLink.shortLink" ng-class="{loading:shortLink.loading}">
                                            </div>
                                        </div>
                                        <div class="row no-gutter">
                                            <div class="rtl col-sm-12 fade in text-justify" ng-class="{in:!shortLink.loading}">
                                                <span>این لینک بر اساس ادرس وارد شده توسط شما ساخته شده و هیچ کالایی را به سبد خرید اضافه نخواهد کرد.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="rtl text-justify">
                                    <li>بعد از قرار دادن این لینک در سایت خود و یا شبکه های اجتماعی، کسانی که از این
                                        طریق در ایران شیک عضو می شوند در تمامی خرید هایشان {{agencyInfo.profit}} درصد
                                        سود بازاریابی به شما تعلق می گیرد.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal fade" id="shortLinkModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h3 class="text-right">تغییر لینک کوتاه عضویت</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" name="groupForm" role="form">
                                            <div class="row">
                                                <div class="input-group col-sm-10 col-md-push-1">
                                                    <span class="input-group-addon">{{agencyInfo.shortLink.base}}</span>
                                                    <div class="input-group-content">
                                                        <input type="text" class="form-control" ng-model="agencyInfo.shortLink.id">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-10 col-md-pull-1 rtl pull-right">
                                                        شما می توانید قسمت انتهایی لینک را به مقدار مورد نظر تغییر داده و برای ثبت نهایی بر
                                                        روی
                                                        دگمه
                                                        ذخیره کلیک نمایید.
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
                                                <button type="button" class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="saveAgencyLink()">
                                                    ذخیره
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>



                        <!--end .card-body -->
                        <!--end .col -->
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card height-8 card-outlined style-primary">
                                <div class="card-head text-right">
                                    <header>رویدادها <i class="fa fa-list-alt" aria-hidden="true"></i></header>
                                </div>
                                <div class="card-body height-6 scroll style-default-bright rtl">
                                    <div ng-hide="events.length" class="alert alert-info">هنوز فعالیتی در حساب شما ثبت
                                                                                        نشده است
                                    </div>
                                    <table class="table text-center text-sm" ng-show="events.length">
                                        <thead>
                                        <tr class="text-center">
                                            <th>مشتری</th>
                                            <th>پیام</th>
                                            <th>کد سفارش</th>
                                            <th>تغییر در کارکرد</th>
                                            <th>تاریخ</th>
                                        </tr>
                                        </thead>
                                        <tr ng-repeat="event in events" title="{{event.item_id}}__{{event.id}}">
                                            <td>
                                                <a href="/admin/user-{{event.user_id}}" target="_blank">
                                                    {{event.user_name}}
                                                    <a/>
                                            </td>
                                            <td>{{event.msg}}</td>
                                            <td>
                                                <a href="/admin/user-{{event.user_id}}#o={{event.order_id}}" target="_blank">
                                                    {{event.order_code}}
                                                </a>
                                            </td>
                                            <td class="ltr">{{event.change_balance|number}}</td>
                                            <td>{{event.created|jdate:' '}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="ordertab">
                    <div class="row text-center half-gutter rtl">
                        <div class="col-sm-3">
                            اعتبار:
                            <span style="color : {{user.balance<0?'red':'green'}}" class="ltr inline">{{user.balance|number}}</span>
                        </div>
                        <div class="col-sm-3" >جمع سفارشات: {{user.order_total_agency | number}}</div>
                        <div class="col-sm-3">فاکتور : {{user.order_total | number}}</div>
                        <div class="col-sm-3">جمع پرداخت ها: {{user.payment_total|number}}</div>
                        <div class="col-sm-1">کد تغییر رمز: {{user.pin}}</div>
                        <div class="col-sm-2">
                            آخرین ورود:
                            {{user.last_login|jdate:' '}}
                        </div>
                    </div>
                    <hr />
                    <div class="row rtl">
                        <div class="col-xs-12" id="infoWrap">
                            <?= $view['user']->info ?>
                        </div>
                    </div>

                    <hr class="style-primary" style="border-top-width: 3px;"/>

                    <div class="">
                        <h3 class="text-right text-primary">
                            سفارش ها <i class="fa fa-pencil-square-o "></i>
                        </h3>
                        <div class="alert alert-warning hardfade rtl" ng-class="{in:orders.length==0 }">هیچ سفارشی پیدا
    حخ                                                                                                    نشد!
                        </div>
                        <div class="table-responsive rtl fade" ng-class="{in:orders.length }">
                            <table class="table table-bordered text-right table-hover table-condensed">
                                <thead>
                                <tr class="active">
                                    <th></th>
                                    <th>کد سفارش</th>
                                    <th>قیمت خرید</th>
                                    <th>فاکتور</th>
                                    <th>پرداخت شده</th>
                                    <th>مجموع وزن</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="order in orders" title="{{order.id}}"
                                    ng-class="{loading:order.loading,active:selectedOrder==order.id}">
                                    <td>
                                        <button class="btn btn-default btn-sm btn-block ink-reaction btn-raised"
                                                ng-click="showInvoice(order)">
                                            <i class="fa fa-plus-circle fa-lg"></i>
                                        </button>
                                    </td>

                                    <td>{{order.code}}</td>
                                    <td az-editable="order-set-value_tl" ng-model="order.value_tl"  data-id="{{order.id}}" data-formatter="number" class="col-sm-1" az-act="refreshPage()"></td>
                                    <td az-editable="order-set-agency_value_tl" ng-show="order.agency_id" ng-model="order.agency_value_tl"  data-id="{{order.id}}" data-formatter="number" class="alert alert-info col-sm-1" az-act="refreshPage()">{{order.agency_value_tl| currency:'':0}}</td>
                                    <td>{{order.final_price| currency:'':0}}</td>
                                    <td>{{order.payment| currency:'':0}}</td>
                                    <td>{{order.weight|number}}</td>
                                    <td>
                                        <div class="dropdown">
												<span class="label label-fa" data-toggle="dropdown"
                                                      style="background-color:#{{getStatus(order.status).color}}">
													<span class="caret"></span>
													{{getStatus(order.status).title}}
												</span>
                                            <ul class="dropdown-menu animation-dock">
                                                <li ng-repeat="status in statuses"
                                                    style="background-color: #{{status.color}}">
                                                    <a href="#"
                                                       ng-click="updateStatus(order,status)">{{status.title}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{order.created | jdate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <paging class="small" page="pageOrder.number" page-size="pageOrder.size" total="pageOrder.total" adjacent="false"
                                show-prev-next="true" hide-if-empty="true" ng-show="pageOrder.total>pageOrder.size"
                                paging-action="doPagingOrder(page)"></paging>
                        <div>
                            <a class="btn btn-primary btn-sm ink-reaction btn-raised" target="_blank"
                               href="order?u={{user.id}}">
                                همه سفارش ها</a>
                            <a class="btn btn-primary btn-sm ink-reaction btn-raised" target="_blank"
                               href="items?v=1&sort=6&u={{user.id}}">تفکیک بار</a>
                            <button class="btn btn-primary btn-sm ink-reaction btn-raised" ng-click="showInvoice()">سبد
                                                                                                                   خرید
                            </button>
                        </div>
                        <div class='row text-center fade' ng-class="{in:!loadOrder}">
                            <div class='spinner '>
                                <div class='ring1'>
                                    <div class='ring2'>
                                        <div class='ring3'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="style-primary" style="border-top-width: 3px;"/>
                    <div class="">
                        <h3 class="text-right text-accent">
                            پرداخت ها <i class="fa fa-money"></i>
                        </h3>
                        <div class="alert alert-warning hardfade rtl" ng-class="{in:payments.length==0 }">هیچ پرداختی
                                                                                                          پیدا نشد!
                        </div>
                        <div class="table-responsive rtl fade" ng-class="{in:payments.length }">
                            <table class="table table-bpaymented text-right table-hover table-condensed">
                                <thead>
                                <tr class="active">
                                    <th>کد سفارش</th>
                                    <th>شکل پرداخت</th>
                                    <th>
                                        مبلغ
                                        <small>(تومان)</small>
                                    </th>
                                    <th>کد پیگیری از بانک</th>
                                    <th>شماره حساب</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="payment in payments"
                                    ng-class="{info:payment.income==3,danger:payment.income==2}" title="{{payment.id}}"
                                    ng-class="{loading:payment.loading}">
                                    <td>{{payment.code}}</td>
                                    <td ng-show="payment.income==1">{{payment.paytype==1?'درگاه پرداخت آنلاین':'انتقال
                                                                    بانکی'}}
                                    </td>
                                    <td ng-show="payment.income==2">واریز به حساب مشتری</td>
                                    <td ng-show="payment.income==3">پرداخت از اعتبار</td>
                                    <td>{{payment.amount| currency:'':0}}</td>
                                    <td>{{payment.refnum}}</td>
                                    <td>{{payment.trace_code}}</td>
                                    <td>
                                        <div class="dropdown" ng-show="payment.income==1">
												<span class="label label-fa"
                                                      ng-class="{'label-success':payment.ok,'label-default':!payment.ok}"
                                                      data-toggle="dropdown">
													<span class="caret"></span>
													{{payment.ok?'تایید شده ':'در انتظار تایید'}}
												</span>
                                            <ul class="dropdown-menu animation-dock">
                                                <li><a href="#" ng-click="updateVerified(payment)">{{!payment.ok?'تایید
                                                                                                   شده ':'در انتظار
                                                                                                   تایید'}}</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{payment.created | jdate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <a class="btn btn-accent btn-sm ink-reaction btn-raised" target="_blank"
                           href="payment?u={{user.id}}">همه
                                                        پرداخت ها</a>
                        <button class="btn btn-accent btn-sm ink-reaction btn-raised" data-target="#addNewPayment"
                                data-toggle="modal">
                            <i class="fa fa-plus"></i> ثبت پرداخت
                        </button>
                        <button class="btn btn-accent btn-sm ink-reaction btn-raised" data-target="#addNewOnlinePayment"
                                data-toggle="modal">
                            <i class="fa fa-credit-card"></i> پرداخت آنلاین
                        </button>
                        <div class='row text-center fade' ng-class="{in:!loadPayment}">
                            <div class='spinner '>
                                <div class='ring1'>
                                    <div class='ring2'>
                                        <div class='ring3'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="style-primary" style="border-top-width: 3px;"/>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="text-right text-warning">
                                ارسال ها <i class="fa fa-truck "></i>
                            </h3>
                            <div class="alert alert-warning hardfade rtl" ng-class="{in:!shipments.length}">هیچ ارسالی
                                                                                                            پیدا نشد!
                            </div>
                            <div class="table-responsive rtl fade" ng-class="{in:shipments.length }">
                                <table class="table table-bordered text-right table-hover table-condensed">
                                    <thead>
                                    <tr class="active">
                                        <th></th>
                                        <th>نوع بسته</th>
                                        <th>وزن شرکت پست</th>
                                        <th>مجموع وزن</th>
                                        <th>هزینه شرکت پست</th>
                                        <th>بسته بندی و ارسال</th>
                                        <th>تعداد کالا</th>
                                        <th>کد رهگیری</th>
                                        <th>وضعیت</th>
                                        <th>بسته بندی</th>
                                        <th>ارسال</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="shipment in shipments" title="{{shipment.id}}"
                                        ng-class="{active:selectedShipment==shipment.id,loading:shipment.loading}">
                                        <td>
                                            <button class="btn btn-default btn-sm btn-block ink-reaction btn-raised"
                                                    ng-click="showShipment(shipment)">
                                                <i class="fa fa-plus-circle fa-lg"></i>
                                            </button>
                                        </td>
                                        <td>{{shipment.package}}</td>
                                        <td az-editable="shipment-edit-weight" ng-model="shipment.weight"
                                            data-id="{{shipment.id}}" data-formatter="number" class="col-sm-1"></td>
                                        <td>{{shipment.shipment_weight|number}}</td>
                                        <td az-editable="shipment-edit-cost" ng-model="shipment.cost"
                                            data-formatter="number" data-id="{{shipment.id}}" class="col-sm-1"></td>
                                        <td>{{shipment.shipment_price|number}}</td>
                                        <td>{{shipment.itemscount}}</td>
                                        <td az-editable="shipment-edit-refcode" ng-model="shipment.refcode"
                                            data-id="{{shipment.id}}" class="col-sm-2"></td>
                                        <td>
                                            <div class="dropdown">
                                                <span class="label label-fa label-warning" data-toggle="dropdown" ng-show="shipment.status==1"><span class="caret"></span> بسته بندی شد</span>
                                                <span class="label label-fa label-success" data-toggle="dropdown" ng-show="shipment.status==2"><span class="caret"></span> ارسال شد </span>
                                                <span class="label label-fa label-danger" data-toggle="dropdown" ng-show="shipment.status==3"><span class="caret"></span> برگشت خورد </span>

                                                <ul class="dropdown-menu animation-dock">
                                                    <li class="label-warning">
                                                        <a href="#" ng-click="updateShipmentStatus(shipment,1)">بسته بندی شد</a>
                                                    </li>
                                                    <li class="label-success">
                                                        <a href="#" ng-click="updateShipmentStatus(shipment,2)">ارسال شد</a>
                                                    </li>
                                                    <li class="label-danger">
                                                        <a href="#" ng-click="updateShipmentStatus(shipment,3)">برگشت خورد</a>
                                                    </li>
                                                </ul>
                                            </div>


                                        </td>
                                        <td>{{shipment.packdate | jdate:'jYYYY/jMM/jDD'}}</td>
                                        <td>{{shipment.sentdate | jdate:'jYYYY/jMM/jDD'}}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <a class="btn btn-sm btn-warning ink-reaction btn-raised" target="_blank"
                                   href="post?u={{user.id}}">همه
                                                             ارسال ها</a>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#newShipment"
                                        ng-click="loadWarehouseItems()">
                                    <i class="fa fa-plus"></i> ارسال جدید
                                </button>
                            </div>
                            <div class='row text-center fade' ng-class="{in:!loadShipment}">
                                <div class='spinner '>
                                    <div class='ring1'>
                                        <div class='ring2'>
                                            <div class='ring3'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end .tab-pane -->
            </div>
            <!--end .card-body -->
            <!-- BEGIN TAB RESULTS -->
            <ul class="card-head nav nav-tabs tabs-primary " data-toggle="tabs">
                <li class="active"><a href="#ordertab">داشبورد</a></li>
                <li><a href="#userinfo">اطلاعات مشتری</a></li>
                <li><a href="#sms">پیامک ها</a></li>
                <?php if (AuthorizationService::checkUserPermission($view['user']->id,'AGENCY')): ?>
                    <li>
                        <a href="#agencyinfo">اطلاعات همکار فروش</a>
                    </li>
                <?php endif ?>
            </ul>
            <!-- END TAB RESULTS -->
        </div>
        <!--end .card -->
    </div>
    <!--end .section-body -->
    <div class="modal fade " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoice">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" title="{{order.id}}">{{order.user_name}} - {{order.user_tel}} - کد سفارش
                                                                 {{order.code}}</h4>
                </div>
                <div class="modal-body">
                    <div class='row text-center hardfade' ng-class="{in:!orderLoad}">
                        <div class='spinner '>
                            <div class='ring1'>
                                <div class='ring2'>
                                    <div class='ring3'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->get('OrderDetail'); ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" ng-click="removeOrder(order)" ng-show="order.status==1" >
                         حذف سفارش <i class="fa fa-times"></i> </button>
                    <a class="btn btn-warning" href="/admin/address?id={{order.address_id}}" target="_blank">
                        مشاهده آدرس <i class="fa fa-truck"></i> </a>
                    <button class="btn btn-success " ng-click="closeBasket()" ng-show="order.basket"
                            data-dismiss="modal">
                        ثبت سفارش <i class="fa fa-check"></i>
                    </button>
                    <button class="btn btn-info " ng-click="printInvoice()">
                        چاپ <i class="fa fa-print"></i>
                    </button>
                    <a class="btn btn-info" href="../order-{{order.id}}.pdf" target="_blank"
                       download="ایران شیک_{{order.code}}.pdf">
                        PDF <i class="fa fa-file-pdf-o"></i> </a>
                    <a class="btn btn-info" href="../order-{{order.id}}.jpg" target="_blank"
                       download="ایران شیک_{{order.code}}.jpg">
                        ذخیره تصویر <i class="fa fa-file-image-o"></i> </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->get('OrderPrint'); ?>
    <div class="modal fade" id="addNewPayment" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel"> ثبت پرداخت - {{user.fname}} {{user.lname}}</h4>
                </div>
                <form class="rtl" role="form" name="newPaymentForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">نوع پرداخت</label>
                            <select class="form-control" ng-model="newPayment.income">
                                <option value="1" selected="selected">واریز به حساب ایران شیک</option>
                                <option value="2">برگشت مبلغ به حساب مشتری</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">مبلغ (فقط عدد)</label>
                            <input type="number" ng-model="newPayment.amount" class="form-control"
                                   placeholder="مبلغ به تومان" required/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> تاریخ و ساعت</label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="input-group ltr no-gutter">
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <select type="text" class="form-control" ng-model="newPayment.day"
                                                        required>
                                                    <option class="hidden" value="0">روز</option>
                                                    <option ng-repeat="day in range(1,31)" value="{{day}}">{{day}}
                                                    </option>
                                                </select>
                                                <span class="input-group-addon" style="border-radius: 0">/</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <select type="text" class="form-control" ng-model="newPayment.month"
                                                    required>
                                                <option class="hidden" value="0">ماه</option>
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
                                        </div>
                                        <span class="input-group-addon">/1395</span>
                                    </div>
                                </div>
                                <div class="col-sm-5 up-xs">
                                    <div class="input-group ltr no-gutter">
                                        <select type="text" class="form-control" ng-model="newPayment.hour" required>
                                            <option class="hidden" value="0">ساعت</option>
                                            <option ng-repeat="h in range(0,23)" value="{{h}}">{{h}}</option>
                                        </select>
                                        <span class="input-group-addon">ساعت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">کد پیگیری (سریال یا شماره ارجاع)</label>
                            <input type="text" ng-model="newPayment.refnum" class="form-control"
                                   placeholder="کد پیگیری">
                        </div>
                        <div class="form-group">
                            <label class="control-label"> شماره حساب</label>
                            <input type="text" ng-model="newPayment.trace_code" class="form-control"
                                   placeholder="به کدام شماره حساب واریز کردید؟">
                        </div>
                        <div class="form-group">
                            <label class="control-label">کد سفارش
                                <small>(اگر خالی و یا اشتباه باشد، مبلغ پرداختی به اعتبار اضافه می شود)</small>
                            </label>
                            <input type="number" ng-model="newPayment.order" class="form-control" placeholder="کد سفارش"
                                   ng-maxlength="6">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
                        <button class="btn ink-reaction btn-raised btn-accent" data-dismiss="modal"
                                ng-click="savePayment()" ng-disabled="newPaymentForm.$invalid"
                                ng-class="{loading:saving}">
                            ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewOnlinePayment" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel"> ثبت پرداخت آنلاین- {{user.fname}} {{user.lname}}</h4>
                </div>
                <form class="rtl" role="form" name="newOnlinePaymentForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">مبلغ (فقط عدد)</label>
                            <input type="number" ng-model="newOnlinePayment.amount" class="form-control"
                                   placeholder="مبلغ به تومان" required/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">کد سفارش
                                <small>(اگر خالی و یا اشتباه باشد، مبلغ پرداختی به اعتبار اضافه می شود)</small>
                            </label>
                            <input type="number" ng-model="newOnlinePayment.order" class="form-control" placeholder="کد سفارش"
                                   ng-maxlength="6">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
                        <button class="btn ink-reaction btn-raised btn-accent" data-dismiss="modal"
                                ng-click="saveOnlinePayment()" ng-disabled="newOnlinePaymentForm.$invalid"
                                ng-class="{loading:saving}">
                            ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="newShipment" tabindex="-1" role="dialog" aria-labelledby="newShipment">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">ارسال جدید - {{user.fname}} {{user.lname}}</h4>
                </div>
                <div class="modal-body col-xs-12" style="background-color: #fff">
                    <div class="row">
                        <form class="rtl form" name="newShipmentForm" id="newShipmentForm" ng-submit="saveNewShipment()">
                            <div class="col-sm-6">
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control" ng-model="newShipment.refcode"/>
                                    <label>کد رهگیری</label>
                                </div>
                                <div class="form-group floating-label">
                                    <select class="form-control" ng-model="newShipment.address_id"
                                            ng-options="val.id as val.title for val in newShipmentAddresses" required="required">
                                        <option></option>
                                    </select>
                                    <label>آدرس {{newShipment.address_id}}</label>
                                </div>
                                <div class="form-group floating-label">
                                    <select class="form-control" ng-model="newShipment.post_plan_id" required="required">
                                        <option></option>
                                        <option value="1" selected>پست - سفارشی</option>
                                        <option value="2">پست - پیشتاز</option>
                                    </select>
                                    <label>پست</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control" place-holder="آدرس"
                                           ng-model="newShipment.weight"/>
                                    <label>وزن</label>
                                    <span class="help-block">گرم</span>
                                </div>
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control" place-holder="آدرس"
                                           ng-model="newShipment.cost"/>
                                    <label>هزینه ارسال</label>
                                    <span class="help-block">تومان</span>
                                </div>
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control" place-holder="نوع بسته"
                                           ng-model="newShipment.package" required="required"/>
                                    <label>نوع بسته</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="panel panel-default fade" ng-class="{in:newShipmentItemsLoaded}">
                            <div class="panel-heading">
                                <h4 class="panel-title text-right"> موجودی انبار <span class="badge pull-left">{{totalSelectionItems()}}</span>
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-warning" ng-hide="newShipmentItems.length">هیچ محصولی برای این
                                                                                                   مشتری در انبار ثبت
                                                                                                   نشده است
                                </div>
                                <div class="col-sm-3">
                                    <form class="rtl form" ng-submit="loadWarehouseItems()">
                                        <div class="form-group floating-label">
                                            <div class="input-group">
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" id="groupbutton10"
                                                           ng-model="newShipmentQuery">
                                                    <label for="groupbutton10">جستجو در انبار</label>
                                                </div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default">
                                                        <i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-hover rtl text-right table-condensed"
                                   ng-show="newShipmentItems.length">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="checkbox-inline checkbox-styled">
                                            <input type="checkbox" ng-click="toggleSelectionItems($element)"
                                                   ng-model="newShipment_selectall">
                                            <span></span></label>
                                    </th>
                                    <th>کد سفارش</th>
                                    <th colspan="2">جزییات</th>
                                    <th>نام کالا</th>
                                    <th>کد کالا</th>
                                    <th>تعداد</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="item in newShipmentItems">
                                    <td>
                                        <label class="checkbox-inline checkbox-styled">
                                            <input type="checkbox" ng-checked="newShipment.items.indexOf(item.id) > -1"
                                                   ng-click="toggleSelectionItem(item)">
                                            <span></span></label>
                                    </td>
                                    <td>{{item.code}}</td>
                                    <td>
                                        <a href="{{item.link}}" target="_blank">
                                            <img alt="" class="img-thumbnail" style="height: 100px;"
                                                 ng-src="/shop/images/{{item.img}}.jpg"/>
                                        </a>
                                        <img alt="" width="50" ng-src="../res/img/sites/{{item.site}}.jpg"/>
                                    </td>
                                    <td>
                                        <ul>
                                            <li ng-repeat="(key, val) in item.vars">{{key+' : '+val}}</li>
                                        </ul>
                                    </td>
                                    <td>{{item.product_name}}</td>
                                    <td>{{item.product_code}}</td>
                                    <td ng-class="{warning:item.qty>1}"><b>{{item.qty}}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <paging class="ltr" page="newShipmentPage.number" page-size="newShipmentPage.size"
                                total="newShipmentPage.total" adjacent="false" show-prev-next="true"
                                paging-action="newShipmentPaging(page, pageSize, total)"></paging>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-warning" form="newShipmentForm">
                        ذخیره
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="shipmentDetail" tabindex="-1" role="dialog" aria-labelledby="invoice">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">اطلاعات مرسوله</h4>
                </div>
                <div class="modal-body" style="background-color: #fff">
                    <div class='row text-center' style="position: relative;">
                        <div class='spinner fade' ng-class="{in:!shipmentLoad}">
                            <div class='ring1'>
                                <div class='ring2'>
                                    <div class='ring3'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="az-table fade" ng-class="{in:shipmentLoad}">
                        <table class="table table-hover rtl text-center table-bordered table-condensed " id="items"
                               style="margin-bottom: 0;">
                            <thead class="">
                            <tr>
                                <th class="">#</th>
                                <th colspan="2">جزییات</th>
                                <th>تعداد</th>
                                <th>کد سفارش</th>
                                <th>وزن</th>
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="" ng-repeat="(index,item) in orderItems">
                                <td>
                                    <p class="item-idx">{{$index+1}}</p>
                                </td>
                                <td class="ltr half-gutter az-table-row">
                                    <div class="col-sm-4">
                                        <img alt="" class="img-thumbnail" style="height: 100px;"
                                             ng-src="/shop/images/{{item.img}}.jpg"/>
                                    </div>
                                    <div class="col-sm-8 details text-left">
                                        {{item.product_name}}<br/>{{item.product_code}}<br/>
                                        <span style="direction: ltr">{{item.price}} TL </span> <br/>
                                        <a href="#" class="logo" target="_blank">
                                            <img class="img-responsive " ng-src="/shop/res/img/sites/{{item.site}}.jpg"
                                                 alt="" width="80">
                                        </a>
                                    </div>

                                </td>
                                <td >
                                    <div class="form-group " ng-repeat="(name,value) in item.vars">
                                        <label>{{name==='size'?'سایز':name==='length'?'قد':name}} :
                                        </label>
                                        <span class="">{{value}}</span>
                                    </div>
                                </td>
                                <td ng-class="{warning:item.qty>1}">{{item.qty}}</td>
                                <td>{{item.code}}</td>
                                <td>{{item.weight}}</td>
                                <td>
                                    <span class="label label-fa" style="background-color: #{{getStatusItem(item.status).color}}">
                                        {{getStatusItem(item.status).title}}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr/>
                    <h3 class="rtl">اطلاعات گیرنده</h3>
                    <dl class="dl-horizontal rtl">
                        <dt>نام و نام خانوادگی</dt>
                        <dd>{{address.name}}</dd>
                        <dt>تلفن</dt>
                        <dd>{{address.tel}}</dd>
                        <dt>آدرس</dt>
                        <dd>{{address.province}} - {{address.city}} - {{address.detail}}</dd>
                        <dt>کدپستی</dt>
                        <dd>{{address.postalcode}}</dd>
                        <dt>پست</dt>
                        <dd>{{post.label}}</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" ng-show="shipment.status==1" ng-click="removeShipment(shipment)">حذف</button>
                    <a class="btn btn-warning" href="/shop/admin/address?s={{shipment.id}}" target="_blank"> چاپ آدرس
                        <i class="fa fa-truck"></i> </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="itemInfo" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">توضیحات</h4>
                </div>
                <div class="modal-body rtl clearfix">

                <textarea  class="form-control" rows="4" ng-model="itemCusInfo">


                </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" ng-click="saveInfo()">ذخیره</button>
                </div>
            </div>
        </div>
    </div>

</section>