<section ng-app="list" ng-controller="listCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li>مدیریت محتوا</li>
            <li class="active">محصولات</li>
        </ol>
    </div>
    <div class="section-body contain-lg">
        <div class="card tabs-left style-default-light">
            <!-- BEGIN SEARCH BAR -->
            <div class="card-body style-primary no-y-padding">
                <form class="form form-inverse" ng-submit="filterSubmit()">
                    <div class="form-group form-group-sm">
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
                                    <button class="btn btn-success" ng-click="edit({})" >محصول جدید
                                        <i class="fa fa-plus"></i></button>

                                </div>
                                <div class="alert alert-warning hardfade rtl" ng-class="{in:products.length==0 }">هیچ موردی
                                                                                                               پیدا نشد!
                                </div>
                                <div class="table-responsive rtl fade" ng-class="{in:load && products.length }">
                                    <table class="table table-bordered text-right table-hover table-condensed ">
                                        <thead>
                                        <tr class="active">
                                            <th style="width: 15px;max-width: 15px">#</th>
                                            <th style="width: 15px;max-width: 15px;">ویرایش</th>
                                            <th style="width: 35px;max-width: 35px">تصویر</th>
                                            <th>نام محصول</th>
                                            <th class="ltr"> (https://boilerplate.com/...) لینک</th>
                                            <th class="ltr">قیمت</th>
                                            <th class="col-sm-1 ">مخفی</th>
                                            <th style="width: 15px;max-width: 15px;">حذف</th>
                                            <th style="width: 15px;max-width: 15px;">مشاهده</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="product in products" title="{{product.id}}-{{product.rnd}}">
                                            <td>{{(($parent.page.number-1)*$parent.page.size)+$index+1}}</td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-xs btn-block ink-reaction btn-raised" ng-click="edit(product)">
                                                    <i class="fa fa-pencil fa-lg"></i>
                                                </button>
                                            </td>
                                            <td style=" padding: 0; text-align: center; "><img ng-if="product.imgs>0" ng-src="/res/img/prod/{{product.rnd}}/{{product.url}}.jpg" src="/res/css/blank.gif"  width="35" /></td>
                                            <td az-editable="name" ng-model="product" class="col-sm-3"></td>
                                            <td az-editable="url" ng-model="product" class="col-sm-4 ltr text-left"></td>
                                            <td az-editable="price" ng-model="product" data-formatter="number" class="col-sm-1 ltr text-left"></td>
                                            <td class="text-center">
                                                <div class="checkbox checkbox-styled no-margin">
                                                    <label>
                                                        <input type="checkbox" ng-model="product.hidden" ng-click="inlineEdit('hidden',product)">
                                                        <span style=" padding-right: 0; "></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-xs btn-block ink-reaction btn-raised" ng-click="remove(product)">
                                                    <i class="fa fa-times-circle fa-lg"></i></button>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-xs btn-block ink-reaction btn-raised" href="/{{product.url}}" target="_blank">
                                                    <i class="fa fa-eye fa-lg"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true" paging-action="DoCtrlPagingAct('Paging Clicked', page, pagesize, total)"></paging>
                            </div>
                        </div>
                        <!--end .col -->
                        <div class="modal fade " id="editProductModal" tabindex="-1" role="dialog" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">{{productEdit.name}} => https://boilerplate.com/{{productEdit.url}}</h4>
                                    </div>
                                    <div class="modal-body col-xs-12">
                                        <div class="row">
                                            <form class="rtl form" name="productEditForm" id="productEditForm" ng-submit="save(productEdit)">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control ltr" ng-model="productEdit.weight"/>
                                                                <label>وزن (گرم)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control ltr" ng-model="productEdit.price"/>
                                                                <label>قیمت (تومان)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control" ng-model="productEdit.code"/>
                                                                <label>کد محصول</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control" ng-model="productEdit.name"/>
                                                                <label>نام محصول</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control ltr" ng-model="productEdit.stock"/>
                                                                <label>موجودی</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control ltr" ng-model="productEdit.wholesale_price"/>
                                                                <label>قیمت عمده فروشی</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control ltr" ng-model="productEdit.old_price"/>
                                                                <label>قیمت قبلی</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-sm">
                                                                <ui-select multiple tagging="tagTransform" tagging-label="(گروه جدید)" ng-model="productEdit.cats">
                                                                    <ui-select-match placeholder="گروه کالا">
                                                                        {{$item.title}}
                                                                    </ui-select-match>
                                                                    <ui-select-choices repeat="cat in cats track by $index" refresh="getCats($select.search)" refresh-delay="200">
                                                                        <span>{{cat.title}}</span>
                                                                    </ui-select-choices>
                                                                </ui-select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-sm">
                                                                <input type="text" class="form-control ltr" ng-model="productEdit.url"/>
                                                                <label> لینک محصول</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm ">
                                                        <textarea id="info" type="text" class="form-control" rows="5" ng-model="productEdit.info"></textarea>
                                                        <label>توضیحات</label>
                                                    </div>
                                                    <div class="form-group form-group-sm ">
                                                        <input type="text" class="form-control"  ng-change="monitorLength(160)" ng-model="productEdit.seodesc"/>
                                                        <label>نتیجه جستجوی گوگل (فقط 160 کاراکتر)</label>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <div class="checkbox checkbox-styled">
                                                            <label>
                                                                <input type="checkbox" ng-model="productEdit.watermark" value="true">
                                                                <span>واترمارک تصاویر</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <input type="file" multiple="multiple" name="file[]" id="imgFiles">
                                                        <label> تصاویر </label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" form="productEditForm" >
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