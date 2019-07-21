<section ng-app="order" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li>داشبورد</li>
            <li class="active">عملکرد سیستم</li>
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
                                <div class="alert alert-warning hardfade rtl" ng-class="{in:smss.length==0 }"> هیچ موردی پیدا نشد!</div>

                                 <div class="table-responsive rtl fade" ng-class="{in:load && logs.length }">
                                    <table class="table table-bordered text-right table-hover table-condensed text-sm">
                                        <thead>
                                            <tr class="active">
                                                <th>#</th>
                                                <th th-sortable="2">کاربر</th>
                                                <th th-sortable="3">اولویت</th>
                                                <th th-sortable="4" class="col-sm-6">پیام</th>
                                                <th th-sortable="7">بخش</th>
                                                <th th-sortable="1">تاریخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="log in logs" title="{{log.id}}"
                                                ng-class="{loading:loading,active:selectedlog==log.id}">
                                                <td>
                                                    <button class="btn btn-default btn-xs btn-block ink-reaction btn-raised"
                                                            ng-click="showLog(log)">
                                                        <i class="fa fa-plus-circle fa-lg"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="user-{{log.user_id}}" target="_self">{{log.user_name}}</a>
                                                </td>
                                                <td>
                                                    <span class="label label-fa" style="background-color: {{getLevel(log.level).color}}">{{getLevel(log.level).title}}</span>
                                                </td>
                                                <td style=" max-width: 200px; ">
                                                    <div style=" white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">
                                                        {{log.msg}}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{log.type}}
                                                </td>
                                                <td>{{log.created|jdate}}</td>
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
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">لاگ</h4>
                </div>
                <form class="" role="form" name="newSMSForm">
                    <div class="modal-body">
                        <textarea ng-model="log.msg" class="form-control input-sm" rows="10"> </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>