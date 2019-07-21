<section ng-app="list" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li>مدیریت محتوا</li>
            <li class="active">صفحه ها</li>
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
                                <input type="text" class="form-control" id="searchInput" placeholder="جستجو" ng-model="mainSearch">
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
									تعداد
									<span class="badge">{{page.total}}</span>
								</span>
                            </div>
                            <!--end .margin-bottom-xxl -->
                            <!-- END PAGE HEADER -->
                            <!-- BEGIN RESULT LIST -->
                            <div class="">
                                <div class='row text-center fade' ng-class="{in:!load}">
                                    <div class='spinner '>
                                        <div class='ring1'>
                                            <div class='ring2'>
                                                <div class='ring3'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#newPage">صفحه جدید
                                        <i class="fa fa-plus"></i></button>
                                </div>
                                <div class="alert alert-warning hardfade rtl" ng-class="{in:pages.length==0 }">هیچ موردی
                                                                                                               پیدا نشد!
                                </div>
                                <div class="table-responsive rtl fade" ng-class="{in:load && pages.length }">
                                    <table class="table table-bordered text-right table-hover table-condensed">
                                        <thead>
                                        <tr class="active">
                                            <th style="width: 15px;max-width: 15px">#</th>
                                            <th style="width: 15px;max-width: 15px;">ویرایش</th>
                                            <th>نام</th>
                                            <th>آدرس (.../)</th>
                                            <th class="col-sm-1 ">مخفی</th>
                                            <th style="width: 15px;max-width: 15px;">حذف</th>
                                            <th style="width: 15px;max-width: 15px;">مشاهده</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="page in pages" title="{{page.id}}">
                                            <td>{{(($parent.page.number-1)*$parent.page.size)+$index+1}}</td>
                                            <td>
                                                <a class="btn btn-default btn-sm btn-block ink-reaction btn-raised" href="/admin/page-edit?url={{page.url}}" target="_blank">
                                                    <i class="fa fa-pencil fa-lg"></i>
                                                </a>
                                            </td>
                                            <td az-editable="title" ng-model="page" class="col-sm-3"></td>
                                            <td az-editable="url" ng-model="page" class="col-sm-4 ltr text-left"></td>
                                            <td class="text-center">
                                                <div class="checkbox checkbox-styled">
                                                    <label>
                                                        <input type="checkbox" ng-model="page.hidden" ng-click="inlineEditPage('hidden',page)">
                                                        <span style=" padding-right: 0; "></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-xs btn-block ink-reaction btn-raised" ng-click="removePage(page)">
                                                    <i class="fa fa-times-circle fa-lg"></i></button>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-xs btn-block ink-reaction btn-raised" href="/{{page.url}}" target="_blank">
                                                    <i class="fa fa-eye fa-lg"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true" paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"></paging>
                            </div>
                        </div>
                        <!--end .col -->
                        <div class="modal fade " id="newPage" tabindex="-1" role="dialog" aria-labelledby="newPage">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">صفحه جدید</h4>
                                    </div>
                                    <div class="modal-body col-xs-12">
                                        <div class="row">
                                            <form class="rtl form" name="newPageForm" id="newPageForm" ng-submit="saveNewPage()">
                                                <div class="col-sm-12">
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control" ng-model="newPage.title"/>
                                                        <label>عنوان صفحه</label>
                                                    </div>
                                                    <div class="form-group floating-label">
                                                        <input type="text" class="form-control ltr" ng-model="newPage.url"/>
                                                        <label> لینک صفحه</label>
                                                    </div>
                                                    <div class="form-group floating-label">
                                                        <div class="checkbox checkbox-styled">
                                                            <label>
                                                                <input type="checkbox" ng-model="newPage.hidden">
                                                                <span>مخفی</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" form="newPageForm">
                                            ذخیره
                                        </button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
</section>