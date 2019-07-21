<section ng-app="order" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li> سفارش ها</li>
            <li class="active">ارسال به ایران</li>
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
                                        <div class="card-body" style="display: block;display: none;">
                                            <div class="row">
                                                <div class="col-sm-6 filter-sq">
                                                    <div class="card">
                                                        <div
                                                            class="card-head card-head-xs style-default dropdown-toggle">
                                                            <header>سایت </header>
                                                            <div class="tools">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-icon-toggle"
                                                                            ng-click="filterSites=[];filterSubmit()"><i
                                                                            class="fa fa-refresh"></i></button>
                                                                    <button class="btn btn-icon-toggle"
                                                                            data-toggle="dropdown"><i
                                                                            class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu dropdown-menu-left animation-dock"
                                                                        role="menu">
                                                                        <li ng-repeat="site in sites"
                                                                            ng-click="addFilterSite(site.id)"><a
                                                                                href="#">{{site.id}})
                                                                                         {{site.name}}</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="card-body small-padding">
                                                            <div class="btn-group btn-group-xs fa-right"
                                                                 ng-repeat="site_id in filterSites">
                                                                <button type="button"
                                                                        class="btn ink-reaction btn-default-light">
                                                                    {{findSite(site_id).name}}
                                                                </button>
                                                                <button type="button"
                                                                        class="btn ink-reaction btn-primary "
                                                                        ng-click="removeFilterSite(site_id)">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-sm-3 filter-sq">
                                                    <div class="card">
                                                        <div
                                                            class="card-head card-head-xs style-default dropdown-toggle">
                                                            <header> وضعیت</header>
                                                            <div class="tools">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-icon-toggle"
                                                                            ng-click="filterStatuses=[];filterSubmit()"><i
                                                                            class="fa fa-refresh"></i></button>
                                                                    <button class="btn btn-icon-toggle"
                                                                            data-toggle="dropdown"><i
                                                                            class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu dropdown-menu-left animation-dock"
                                                                        role="menu">
                                                                        <li ng-repeat="st in statuses"
                                                                            ng-click="addFilterStatus(st.id)"><a
                                                                                href="#">{{st.id}})
                                                                                         {{st.name}}</a>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="card-body small-padding">
                                                            <div class="btn-group btn-group-xs fa-right"
                                                                 ng-repeat="id in filterStatuses">
                                                                <button type="button"
                                                                        class="btn ink-reaction btn-default-light">
                                                                    {{findStatus(id).name}}
                                                                </button>
                                                                <button type="button"
                                                                        class="btn ink-reaction btn-primary "
                                                                        ng-click="removeFilterStatus(id)">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-sm-3">

                                                </div>
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
                                <div class="alert alert-warning hardfade rtl" ng-class="{in:shipments.length==0 }">هیچ
                                                                                                                موردی
                                                                                                                پیدا
                                                                                                                نشد!
                                </div>
                                <div>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#newShipment" ng-click="newShipmentShow();">
                                        <i class="fa fa-plus"></i> ارسال جدید
                                    </button>
                                </div>

                                <div class="table-responsive rtl fade" ng-class="{in:load && shipments.length }">
                                    <table class="table table-bordered text-right table-hover table-condensed text-sm">
                                        <thead>
                                        <tr class="active">
                                            <th>#</th>
                                            <th >کد</th>
                                            <th th-sortable="4">نام حامل</th>
                                            <th th-sortable="4">نوع بسته</th>
                                            <th th-sortable="5">تعداد کالا</th>
                                            <th th-sortable="6">وزن واقعی</th>
                                            <th th-sortable="8">وزن سیستم</th>
                                            <th th-sortable="9">هزینه ارسال</th>
                                            <th th-sortable="2">وضعیت</th>
                                            <th th-sortable="1">ارسال از استانبول</th>
                                            <th th-sortable="3">تحویل در ایران</th>
                                            <th th-sortable="7">مدت انتقال</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="shipment in shipments" title="{{shipment.id}}" ng-class="{loading:loading,active:selectedShipment==shipment.id}">
                                            <td>
                                                <button class="btn btn-default btn-sm btn-block ink-reaction btn-raised"
                                                        ng-click="showShipment(shipment)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
                                            <td>{{shipment.code}}</td>
                                            <td az-editable="shipmentiran-edit-carrier" ng-model="shipment.carrier"
                                                data-id="{{shipment.id}}" class="col-sm-2"></td>
                                            <td az-editable="shipmentiran-edit-package" ng-model="shipment.package"
                                                data-id="{{shipment.id}}" class="col-sm-1"></td>
                                            <td>{{shipment.sumitems}}</td>
                                            <td az-editable="shipmentiran-edit-weight" ng-model="shipment.weight"
                                                data-formatter="number" data-id="{{shipment.id}}" class="col-sm-1"></td>
                                            <td>{{shipment.sysweight|number}}</td>
                                            <td az-editable="shipmentiran-edit-cost" ng-model="shipment.cost"
                                                data-formatter="number" data-id="{{shipment.id}}" class="col-sm-1"></td>
                                            <td>
                                                <div class="dropdown">
                                                    <span class="label label-fa label-{{findStatus(shipment.status).color}}"
                                                        data-toggle="dropdown">
                                                     <span class="caret" ng-show="shipment.status<3"></span> {{findStatus(shipment.status).name}}
                                                    </span>
                                                    <ul class="dropdown-menu animation-dock" ng-show="shipment.status<3">
                                                        <li class="label-{{st.color}}"
                                                            ng-repeat="st in properStatuses(shipment.status)">
                                                            <a href="#" ng-click="updateStatus(shipment,st)">
                                                                {{st.name}}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td >{{shipment.sentdate | jdate:'jYYYY/jMM/jDD'}}</td>
                                            <td >{{shipment.recvdate | jdate:'jYYYY/jMM/jDD'}}</td>
                                            <td>{{shipment.days}}
                                                <span ng-show="shipment.days">روز</span>
                                            </td>
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

    <div class="modal fade " id="newShipment" tabindex="-1" role="dialog" aria-labelledby="newShipment">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">ارسال به ایران</h4>
                </div>
                <div class="modal-body col-xs-12" style="background-color: #fff">
                    <div class="row">
                        <form class="rtl form" name="newShipmentForm" id="newShipmentForm" ng-submit="saveNewShipment()">
                            <div class="col-sm-3">
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control input-sm" ng-model="newShipment.carrier" required="required"/>
                                    <label>نام حامل</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control input-sm" ng-model="newShipment.package"/>
                                    <label>نوع بسته</label>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control input-sm" place-holder="آدرس"
                                           ng-model="newShipment.weight"/>
                                    <label>وزن</label>
                                    <span class="help-block">گرم</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group floating-label">
                                    <input type="text" class="form-control input-sm" place-holder="آدرس"
                                           ng-model="newShipment.cost"/>
                                    <label>هزینه ارسال</label>
                                    <span class="help-block">تومان</span>
                                </div>
                            </div>


                        </form>
                    </div>
                    <div class="row half-gutter up-2" ng-show="newShipment.status==1">
                        <div class="col-sm-7" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-right"> موجودی انبار

                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <form class="rtl form" ng-submit="loadWarehouseItems()">
                                                <div class="form-group floating-label">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" id="groupbutton10"
                                                                   ng-model="newShipmentQuery"/>
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
                                    <div class="alert alert-warning rtl" ng-hide="newShipmentItems.length">هیچ موردی
                                                                                                           یافت نشد
                                    </div>
                                    <div class='row text-center hardfade spinner-abs'
                                         ng-class="{in:!newShipmentItemsLoaded }">
                                        <div class='spinner '>
                                            <div class='ring1'>
                                                <div class='ring2'>
                                                    <div class='ring3'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-hover rtl text-right table-condensed fade text-sm"
                                       ng-class="{in:newShipmentItemsLoaded && newShipmentItems.length}">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="checkbox-inline checkbox-styled">
                                                <input type="checkbox" ng-click="toggleSelectionItems($element)"
                                                       ng-model="newShipment_selectall">
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>مشتری</th>
                                        <th>تصویر</th>
                                        <th>سایز</th>
                                        <th>نام کالا</th>
                                        <th>تعداد</th>
                                        <th>تاریخ و شماره خرید</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="item in newShipmentItems" title="{{item.id}}">
                                        <td>
                                            <label class="checkbox-inline checkbox-styled">
                                                <input type="checkbox"
                                                       ng-checked="newShipment.items.indexOf(item.id) > -1"
                                                       ng-click="toggleSelectionItem(item)">
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="/admin/user-{{item.user_id}}#o={{item.order_id}}"
                                               target="_blank">
                                                {{item.user}}<br/>
                                                {{item.code}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{item.link}}" target="_blank">
                                                <img alt="" class="img-thumbnail" style="height: 100px;"
                                                     ng-src="/images/{{item.img}}.jpg"/>
                                            </a>
                                        </td>
                                        <td>
                                            <ul style=" padding: 2px;list-style-type: none; ">
                                                <li ng-repeat="(key, val) in item.vars">{{key+' : '+val}}</li>
                                            </ul>
                                        </td>
                                        <td>{{item.product_name}}<br/>
                                            <span class="text-accent-dark">{{item.product_code}}</span>
                                            <br/>
                                            <img alt="" width="70" ng-src="../res/img/sites/{{item.site}}.jpg"/>
                                        </td>
                                        <td><h4 class="text-ultra-bold">{{item.qty}}</h4></td>
                                        <td title="{{item.buydate}}">{{item.buydate|jdate:'jYYYY/jMM/jDD'}}<br/>
                                            <span class="text-accent-dark">{{item.site_order_num}}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <paging class="ltr" page="newShipmentPage.number" page-size="newShipmentPage.size"
                                        total="newShipmentPage.total" adjacent="false" show-prev-next="true"
                                        paging-action="newShipmentPaging(page, pageSize, total)"></paging>
                            </div>
                        </div>
                        <div class="col-sm-5" >
                            <div class="card card-outlined style-accent">
                                <div class="card-head card-head-sm">
                                    <header class="btn-block"><i class="fa fa-fw fa-tag"></i> کالاهای انتخاب شده
                                        <span class="badge pull-right"> تعداد: {{totalSelectionItems()}}</span>
                                    </header>
                                </div><!--end .card-head -->
                                <div class="card-body">
                                    <div class="col-sm-4 ship-prod" ng-repeat="item in newShipmentSelectedItems">
                                        <div class="card ">
                                            <div class="card-body p-0">
                                                <img alt="" class="img-responsive"
                                                     ng-src="/images/{{item.img}}.jpg"/>
                                            </div><!--end .card-body -->
                                            <div class="card-head card-head-xs style-gray">
                                                <span>{{item.product_name}}</span>
                                                <span>{{item.product_code}}</span>
                                                <span>{{item.user}}</span>
                                                <span>{{item.qty}}</span>
                                            </div><!--end .card-head -->
                                        </div>
                                        <i class="fa fa-times style-danger" ng-click="removeFromSelection(item)"></i>
                                    </div>
                                </div><!--end .card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row half-gutter up-2" ng-show="newShipment.status!=1">
                            <div class="card card-outlined style-accent">
                                <div class="card-head card-head-sm">
                                    <header class="btn-block"><i class="fa fa-fw fa-tag"></i> کالاهای انتخاب شده
                                        <span class="badge pull-right"> تعداد: {{totalSelectionItems()}}</span>
                                    </header>
                                </div><!--end .card-head -->
                                <div class="card-body">
                                    <div class="col-sm-1 ship-prod" ng-repeat="item in newShipmentSelectedItems">
                                        <div class="card ">
                                            <div class="card-body p-0">
                                                <img alt="" class="img-responsive"
                                                     ng-src="/images/{{item.img}}.jpg"/>
                                            </div><!--end .card-body -->
                                            <div class="card-head card-head-xs style-gray">
                                                <span>{{item.product_name}}</span>
                                                <span>{{item.product_code}}</span>
                                                <span>{{item.user}}</span>
                                                <span>{{item.qty}}</span>
                                            </div><!--end .card-head -->
                                        </div>
                                    </div>
                                </div><!--end .card-body -->
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" type="button" ng-click="print()" ng-show=" newShipment.id">
                        چاپ رسید
                    </button>
                    <button class="btn btn-danger" type="button" ng-click="removeShipment()" ng-show="newShipment.status==1 && newShipment.id">
                        حذف
                    </button>
                    <button class="btn btn-success" form="newShipmentForm" ng-show="newShipment.status==1">
                        ذخیره
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>



    <div class=" printable" >
        <div class="container">
            <div class="">
                <div class="table-responsive">
                    <table class="table table-condenced rtl text-right">
                        <thead>
                        <tr>
                            <th>کد بسته</th>
                            <th>نوع بسته</th>
                            <th>تعداد کالا</th>
                            <th>وزن</th>
                            <th>تاریخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{newShipment.code}}</td>
                            <td>{{newShipment.package}}</td>
                            <td>{{newShipment.sumitems}}</td>
                            <td>{{newShipment.weight|number}}</td>
                            <td>{{'now'|jdate:'jYYYY/jMM/jDD'}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="card card-outlined style-gray">
                    <div class="card-body half-gutter text-xs">
                        <div class="col-xs-1 ship-prod" ng-repeat="item in newShipmentSelectedItems">
                            <div class="card ">
                                <div class="card-body p-0">
                                    <img alt="" class="img-responsive" ng-src="/images/{{item.img}}.jpg"/>
                                </div><!--end .card-body -->
                                <div class="card-head card-head-xs style-gray">
                                    <span>{{item.product_name}}</span>
                                    <span>{{item.product_code}}</span>
                                    <span>{{item.user}}</span>
                                    <span>{{item.qty}}</span>
                                </div><!--end .card-head -->
                            </div>
                        </div>
                    </div><!--end .card-body -->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="pull-right">
                        امضا<br/>
                        {{newShipment.carrier}}
                    </div>
                    <div class="">
                        امضا<br/>
                        boilerplate
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>