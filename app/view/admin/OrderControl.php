<section ng-app="order" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li> سفارش ها</li>
            <li class="active">کنترل خرید های سایت های خارجی</li>
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
                            
                            <div class="row">
                                    <div class="card card-outlined style-primary p-0">
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
                                        <div class="card-body" style="display: block;">
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
                                                                        class="btn ink-reaction btn-primary " ng-class="findStatus(id).color"
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
                                <div class="alert alert-warning hardfade rtl" ng-class="{in:orders.length==0 }">هیچ
                                                                                                                موردی
                                                                                                                پیدا
                                                                                                                نشد!
                                </div>
                                <div class="table-responsive rtl fade" ng-class="{in:load && orders.length }">
                                    <table class="table table-bordered text-right table-hover table-condensed">
                                        <thead>
                                        <tr class="active">
                                            <th>#</th>
                                            <th th-sortable="3">سایت</th>
                                            <th th-sortable="4">شماره خرید</th>
                                            <th th-sortable="5">تعداد محصولات</th>
                                            <th th-sortable="6">دریافت نشده</th>
                                            <th th-sortable="2">وضعیت</th>
                                            <th th-sortable="1">تاریخ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="order in orders">
                                            <td>
                                                <a class="btn btn-default btn-sm btn-block ink-reaction btn-raised"
                                                   href="/admin/items?sort=7&q={{order.site_order_num}}" target="_blank">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </a>
                                            </td>
                                            <td><img width="80px" src="/res/img/sites/{{order.site}}.jpg"/></td>
                                            <td>{{order.site_order_num}}</td>
                                            <td>{{order.items}}</td>
                                            <td>{{order.items3}}</td>
                                            <td>
														<span class="label label-fa"
                                                              ng-class="findStatus(order.status).color">
															{{findStatus(order.status).name}}
                                                        </span>
                                            </td>
                                            <td>{{order.buydate | jdate}}</td>
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

    <div class="modal fade " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoice">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">صورتحساب سفارش {{order.code}}</h4>
                </div>
                <div class="modal-body">
                    <div class='row text-center fade' ng-class="{in:!orderLoad}">
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
                    <a class="btn btn-warning" href="/admin/items?q={{order.code}}&u={{order.user_id}}"
                       target="_self">
                        ویرایش محصولات <i class="fa fa-pencil"></i>
                    </a>
                    <button class="btn btn-info " ng-click="printInvoice()">
                        چاپ <i class="fa fa-print"></i>
                    </button>
                    <a class="btn btn-info" href="../order-{{order.id}}.pdf" target="_blank"
                       download="boilerplate_{{order.code}}.pdf">
                        PDF <i class="fa fa-file-pdf-o"></i>
                    </a>
                    <a class="btn btn-info" href="../order-{{order.id}}.jpg" target="_blank"
                       download="boilerplate_{{order.code}}.jpg">
                        ذخیره تصویر <i class="fa fa-file-image-o"></i>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->get('OrderPrint'); ?>

</section>