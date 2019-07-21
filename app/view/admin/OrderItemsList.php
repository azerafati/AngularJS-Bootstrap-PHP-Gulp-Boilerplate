<section ng-app="item">
    <div class="section-header">
        <ol class="breadcrumb">
            <li>سفارش ها</li>
            <li class="active">ریز سفارش ها</li>
        </ol>
    </div>
    <div class="section-body contain-lg" ng-controller="listCtrl">
        <div class="card tabs-left ">

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

            <!-- BEGIN TAB CONTENT -->
            <div class="card-body style-default-bright">
                <div class="row">
                    <div class="col-xs-12">

                        <!-- BEGIN PAGE HEADER -->
                        <div class="margin-bottom-xxl">
							<span class="text-light text-right">
								مورد یافت شد
								<span class="badge">{{page.total}}</span>
							</span>
                            <div class="btn-group btn-group-sm pull-right">
                                <button type="button" class="btn btn-default-light dropdown-toggle"
                                        data-toggle="dropdown">
                                    <span class="fa fa-arrow-down"></span>
                                    مرتب کردن
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right animation-dock" role="menu">
                                    <li ng-class="{active:sort_id==null}" ng-click="sort(1)"><a href="#">وضعیت</a></li>
                                    <li ng-class="{active:sort_id==2}"><a href="#" ng-click="sort(2)">تاریخ</a></li>
                                    <li ng-class="{active:sort_id==3}"><a href="#" ng-click="sort(3)">مبلغ</a></li>
                                    <li ng-class="{active:sort_id==4}"><a href="#" ng-click="sort(4)">اسم محصول</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--end .margin-bottom-xxl -->
                        <!-- END PAGE HEADER -->

                        <!-- BEGIN RESULT LIST -->
                        <div class="">
                            <div class='row text-center hardfade' ng-class="{in:!load}">
                                <div class='spinner '>
                                    <div class='ring1'>
                                        <div class='ring2'>
                                            <div class='ring3'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-warning fade rtl" ng-class="{in:content.length==0 }">هیچ سفارشی پیدا
                                                                                                         نشد!
                            </div>
                            <div class="table-responsive rtl fade" ng-class="{in:load && content.length }">
                                <table class="table table-bordered text-right table-hover table-condensed text-sm">
                                    <thead>
                                    <tr class="active">
                                        <th></th>
                                        <th>سایز</th>
                                        <th>تعداد</th>
                                        <th>مشتری</th>
                                        <th ng-hide="location().v==1 || location().v==3">قیمت اصلی
                                            <small>(TL)</small>
                                        </th>
                                        <th th-sortable="4">مبلغ</th>
                                        <th th-sortable="3" ng-hide="location().v==1 || location().v==3">
                                            کارگو
                                            <small>(لیر)</small>
                                        </th>
                                        <th th-sortable="5">
                                            وزن
                                            <small>(گرم)</small>
                                        </th>
                                        <th>شماره خرید</th>
                                        <th th-sortable="1">تاریخ</th>
                                        <th ng-hide="location().v==2" th-sortable="2">وضعیت</th>
                                        <th ng-show="location().v==1 || location().v==2 || location().v==3 ">تغییر وضعیت </th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center" >
                                    <tr ng-repeat="item in content" title="{{item.id}}"
                                        ng-class="{loading:item.loading}">

                                        <td class="ltr no-gutter az-table-row" style="padding: 2px;max-width: 200px;">
                                            <div class="col-sm-4">
                                                <a href="{{item.link}}" target="_blank">
                                                    <img class="img img-thumbnail" title="{{item.title}}"
                                                         ng-src="../images/{{item.img}}.jpg"
                                                         style="height: 80px;"/>
                                                </a>
                                            </div>
                                            <div class="col-sm-8 details text-left">
                                                {{item.product_name}}<br/><span style=" color: #8A1010; ">{{item.product_code}}</span><br/>
                                                <img class="img-responsive " ng-src="/res/img/sites/{{item.site}}.jpg"
                                                     alt="" width="60">
                                            </div>
                                        </td>

                                        <td>
                                            <ul style=" padding: 2px;list-style-type: none; ">
                                                <li ng-repeat="(key, val) in item.vars">{{key+' : '+val}}</li>
                                            </ul>
                                            <p ng-show="item.cus_info && item.cus_info.length<40">{{item.cus_info}}</p>
                                            <button class="btn btn-warning btn-xs" ng-show="item.cus_info && (item.cus_info.length>39)" ng-click="alert(item.cus_info)">توضیحات</button>
                                        </td>
                                        <td az-editable="order-item-set-qty" ng-model="item.qty" data-id="{{item.id}}"
                                            class="col-sm-1"></td>
                                        <td><a href="/admin/user-{{item.user_id}}" target="_blank">{{item.user}}<br/>{{item.code}}</a></td>
                                        <td ng-hide="location().v==1 || location().v==3" az-editable="order-item-set-price"
                                            ng-model="item.price" data-id="{{item.id}}" class="col-sm-1"></td>
                                        <td>{{item.total_price}}</td>
                                        <td ng-hide="location().v==1 || location().v==3" az-editable="order-item-set-cargo_price"
                                            ng-model="item.cargo" data-id="{{item.id}}" class="col-sm-1"></td>
                                        <td az-editable="order-item-set-weight" ng-model="item.weight"
                                            data-id="{{item.id}}" class="col-sm-1"></td>
                                        <td az-editable="site-order-num" ng-model="item.site_order_num"
                                            data-id="{{item.id}}" class="col-sm-1"></td>
                                        <td>
                                            <small>{{item.created | jdate}}</small>
                                        </td>
                                        <td ng-hide="location().v==2">
                                            <div class="dropdown">
													<span class="label label-fa" data-toggle="dropdown"
                                                          style="background-color: #{{getStatus(item.status) .color}}">
														<span class="caret"></span>
														{{getStatus(item.status).title}}
													</span>
                                                <ul class="dropdown-menu animation-dock"
                                                    aria-labelledby="dropdownMenu1">
                                                    <li ng-repeat="status in statuses"
                                                        style="background-color: #{{status.color}}"><a href="#"
                                                                                                       ng-click="updateStatus(item,status)">{{status.title}}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td ng-show="location().v==1">
                                            <button class="btn btn-sm btn-default" ng-hide="item.status == '9'"
                                                    ng-click="updateStatus(item,getStatus('9'))"
                                                    style="background-color: #{{getStatus('9').color}}">
                                                {{getStatus('9').title}}
                                            </button>
                                        </td>
                                        <td ng-show="location().v==3">
                                            <button class="btn btn-sm btn-default" ng-hide="item.status == '8'"
                                                    ng-click="updateStatus(item,getStatus('8'))"
                                                    style="background-color: #{{getStatus('8').color}}">
                                                {{getStatus('8').title}}
                                            </button>
                                        </td>
                                        <td ng-show="location().v==2">
                                            <button class="btn btn-xs btn-default btn-raised"
                                                    ng-click="updateStatus(item,getStatus('3'))"
                                                    style="background-color: #{{getStatus('3').color}}">
                                                {{getStatus('3').title}}
                                            </button>
                                            <button class="btn btn-xs btn-default up btn-raised"
                                                    ng-click="updateStatus(item,getStatus('7'))"
                                                    style="background-color: #{{getStatus('7').color}}">
                                                {{getStatus('7').title}}
                                            </button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end .col -->
                </div>

                <paging page="page.number" page-size="page.size" total="page.total" adjacent="false"
                        show-prev-next="true"
                        paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"></paging>

                <div class="row">
                    <form>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>سایت محصول</label>
                                <select class="form-control select2-list select2-control"
                                        data-placeholder="یک یا چند سایت انتخاب کنید" multiple ng-model="siteModel"
                                        ng-change="filterSubmit()">
                                    <option value="1">Trendyol</option>
                                    <option value="2">LC Waikiki</option>
                                    <option value="3">DeFacto</option>
                                    <option value="4">İroni Tekstil</option>
                                    <option value="5">Markafoni</option>
                                    <option value="6">Tozlu</option>
                                    <option value="7">1V1Y</option>
                                    <option value="8">adL</option>
                                    <option value="9">Sateen</option>
                                    <option value="10">Pierre Cardin</option>
                                    <option value="11">Alvina</option>
                                    <option value="12">DenoKids</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            <!--end .card-body -->
            <!-- END TAB CONTENT -->

        </div>
        <!--end .card -->
    </div>
    <!--end .section-body -->
</section>