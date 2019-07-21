<section ng-app="post" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li class="active">بسته بندی و ارسال</li>
		</ol>
	</div>
	<div class="section-body contain-lg">
		<div class="card tabs-left ">
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
								<button type="button" class="btn btn-default-light dropdown-toggle" data-toggle="dropdown">
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
							<div class="alert alert-warning fade rtl" ng-class="{in:content.length==0 }">هیچ ارسالی پیدا نشد!</div>

							<div class="table-responsive rtl fade" ng-class="{in:load && shipments.length }">
								<table class="table table-bordered text-right table-hover table-condensed ">
									<thead>
										<tr class="active">
											<th>مشتری</th>
											<th>تعداد کالا</th>
											<th>وزن</th>
											<th>هزینه بسته بندی و ارسال</th>
											<th>پست</th>
											<th>وضعیت</th>
											<th>کد رهگیری</th>
											<th>وزن شرکت پست</th>
											<th>هزینه شرکت پست</th>
											<th> تاریخ</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="shipment in shipments"  title="{{shipment.id}}" ng-class="{success:shipment.paystat,active:selectedShipment==shipment.id,loading:shipment.loading}">
                                            <td class="hidden">
                                                <button class="btn btn-default btn-sm btn-block ink-reaction btn-raised"
                                                        ng-click="showInvoice(shipment)">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </button>
                                            </td>
											<td><a href="/admin/user-{{shipment.user_id}}" target="_blank">{{shipment.user_name}}<a/></td>
											<td>{{shipment.itemscount | number:0}}</td>
											<td>{{shipment.shipment_weight | number:0}}</td>
											<td>{{shipment.shipment_price | number}}</td>
											<td>{{shipment.post_plan_name}}</td>
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

											<td az-editable="shipment-edit-refcode" ng-model="shipment.refcode" data-id="{{shipment.id}}" class="col-sm-2"></td>
											<td az-editable="shipment-edit-weight" ng-model="shipment.weight" data-id="{{shipment.id}}" class="col-sm-1" data-formatter="number"></td>
											<td az-editable="shipment-edit-cost" ng-model="shipment.cost" data-id="{{shipment.id}}" class="col-sm-1" data-formatter="number"></td>
											<td class="text-sm">{{shipment.packdate | jdate:'jYYYY/jMM/jDD hh:mm'}}</td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>

					</div>
					<!--end .col -->
				</div>

				<paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true"
					paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"> </paging>

			</div>
			<!--end .card-body -->
			<!-- END TAB CONTENT -->

		</div>
		<!--end .card -->
	</div>


	<div class="modal fade " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoice">
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
					<div class=" fade" ng-class="{in:shipmentLoad}">


						<table class="table table-hover rtl text-center table-bordered table-condensed " id="items" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th class="">#</th>
									<th colspan="2">جزییات</th>
									<th>قیمت واحد</th>
									<th>جمع</th>
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
											<img class="img img-thumbnail" title="{{item.title}}" ng-src="{{item.image_url}}" data-link="{{item.link}}"></img>
										</div>
										<div class="col-sm-8 details text-left">
											{{item.product_name}}<br />{{item.product_code}}<br />
											<span style="direction: ltr">{{item.price}} TL </span>
											<br />
											<a href="{{item.site.url}}" class="logo" title="{{item.site.name}}" target="_blank">
												<img class="img-responsive " ng-src="../res/img/sites/{{item.site.id}}.jpg" alt="" width="80">
											</a>
										</div>
										<div class="form-group rtl">
											<label>گروه وزنی : </label>
											<span class="">{{item.group}}</span>
										</div>
									</td>
									<td data-title="آپشن : ">
										<div class="form-group " ng-repeat="(name,values) in item.vars">
											<label>{{name==='size'?'سایز':name==='length'?'قد':name}} : </label>
											<span class="">{{item.selectedvars[name]}}</span>
										</div>
										<div class="form-group ">
											<label>تعداد : </label>
											<span class="">{{item.qty}}</span>
										</div>
									</td>
									<td class="" data-title="قیمت:">{{item.unit_price| currency:'':0}}</td>
									<td class="" data-title="جمع:">{{item.total_price| currency:'':0}}</td>
									<td class="" data-title="وضعیت:">
										<span class="label label-default">{{item.status}}</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<hr />
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
					</dl>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="print()">چاپ آدرس</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade " id="newShipment" tabindex="-1" role="dialog" aria-labelledby="newShipment">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">ارسال جدید</h4>
				</div>
				<div class="modal-body" style="background-color: #fff">
					<form class="row rtl form">
						<div class="col-sm-5">
							<div class="panel panel-default fade" ng-class="{in:newShipmentItemsLoaded}">
								<div class="panel-heading">
									<h4 class="panel-title text-right">موجودی انبار</h4>
								</div>
								<div class="panel-body" ng-hide="newShipmentItems.length">
									<div class="alert alert-warning">هیچ محصولی برای این مشتری در انبار ثبت نشده است</div>
								</div>

								<table class="table table-hover rtl text-right table-condensed" ng-show="newShipmentItems.length">
									<thead>
										<tr>
											<th>
												<label class="checkbox-inline checkbox-styled"> <input type="checkbox" ng-click="toggleSelectionItems($element)" ng-model="newShipment_selectall"> <span></span>
												</label>
											</th>
											<th>کد</th>
											<th colspan="2">جزییات</th>
											<th>تعداد</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in newShipmentItems">
											<td>
												<label class="checkbox-inline checkbox-styled"> <input type="checkbox" ng-checked="newShipment.items.indexOf(item.id) > -1" ng-click="toggleSelectionItem(item.id)"> <span></span>
												</label>
											</td>
											<td>{{item.code}}</td>
											<td>
												<a href="{{item.link}}" target="_blank">
													<img alt="" class="img-thumbnail" style="height: 60px;" ng-src="{{item.image}}" />
												</a>
												<img alt="" width="50" ng-src="../res/img/sites/{{item.site}}.jpg" />
											</td>
											<td>
												<ul>
													<li ng-repeat="(key, val) in item.vars">{{key+' : '+val}}</li>
												</ul>
											</td>
											<td>{{item.qty}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="form-group floating-label">
								<!-- 								<input select2 class="form-control select2-list rtl" ng-model="$parent.newShipment.user_id" ng-change="loadWarehouseItems()" api="users" /> typeahead-input-formatter="formatUser()" -->
								<input type="text" ng-model="newShipment.user" typeahead-on-select="loadWarehouseItems()" typeahead="user as user.fname for user in loadUsers($viewValue)"
									typeahead-loading="loadingUsers" typeahead-no-results="noResults" typeahead-select-on-blur="true" class="form-control" typeahead-template-url="customTemplate.html"
									typeahead-wait-ms="300">
								<div ng-show="loadingUsers">
									<i class="fa fa-refresh fa-spin"></i> در حال جستجو
								</div>
								<div ng-show="noResults">
									<i class="fa fa-times"></i> کاربری یافت نشد
								</div>
								<label>مشتری</label>
							</div>
							<div class="form-group floating-label">
								<input type="text" class="form-control" ng-model="newShipment.refcode" />
								<label>کد رهگیری</label>
							</div>
							<div class="form-group floating-label">
								<!-- 								<input select2 class="form-control select2-list rtl" ng-model="$parent.newShipment.address_id" api="address" select2_rel="id={{newShipment.user_id}}" /> -->
								<select class="form-control" ng-model="newShipment.address_id" ng-options="val.id as val.title for val in newShipmentAddresses">
								</select>
								<label>آدرس {{newShipment.address_id}}</label>
							</div>
							<div class="form-group floating-label">
								<select class="form-control" ng-model="newShipment.post_plan_id">
									<option value="1" selected>پست - سفارشی</option>
									<option value="2">پست - پیشتاز</option>
								</select>
								<label>پست</label>
							</div>
							<div class="form-group floating-label">
								<input type="text" class="form-control" place-holder="آدرس" ng-model="newShipment.weight" />
								<label>وزن</label>
								<span class="help-block">گرم</span>
							</div>
							<div class="form-group floating-label">
								<input type="text" class="form-control" place-holder="آدرس" ng-model="newShipment.cost" />
								<label>هزینه ارسال</label>
								<span class="help-block">تومان</span>
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="saveNewShipment()">ذخیره</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
				</div>
			</div>
		</div>
	</div>
<script type="text/ng-template" id="customTemplate.html">
  <a>
      <span >{{match.model.fname}} {{match.model.lname}}</span>
	 <div ><small>{{match.model.tel}} - {{match.model.email}}</small></div>
  </a>
</script>
<div class="printable row" >
	<div class="table-responsive">
		<table class="table rtl text-center table-bordered" id="table_address">
			<tbody>
				<tr>
					<td>فرستنده</td>
					<td>تبریز، خیابان امام، خیابان شهید غلامی، کوی آخرتی، پلاک 1، طبقه 1</td>
				</tr>
				<tr>
					<td></td>
					<td>boilerplate - متین</td>
				</tr>
				<tr>
					<td>کد پستی</td>
					<td>5154834546</td>
				</tr>
				<tr>
					<td>شماره تماس</td>
					<td>04133364450</td>
				</tr>

			</tbody>
			<tbody>
				<tr>
					<td>گیرنده</td>
					<td>{{address.province}} - {{address.city}} - {{address.detail}}</td>
				</tr>
				<tr>
					<td></td>
					<td>{{address.name}}</td>
				</tr>
				<tr>
					<td>کد پستی</td>
					<td>{{address.postalcode}}</td>
				</tr>
				<tr>
					<td>شماره تماس</td>
					<td>{{address.tel}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</section>