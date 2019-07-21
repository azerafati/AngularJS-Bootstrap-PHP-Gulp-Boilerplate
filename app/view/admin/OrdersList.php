<section ng-app="order" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li>سفارش ها</li>
			<li class="active">سفارش های ثبت شده</li>
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
			<ul class="card-head nav nav-tabs tabs-accent" data-toggle="tabs">
				<li class="active"><a href="#web1">Web</a></li>
				<li><a href="#web1">Images</a></li>
				<li><a href="#web1">Documents</a></li>
				<li><a href="#web1">Videos</a></li>
				<li><a href="#web1">Contacts</a></li>
			</ul>
			<!-- END TAB RESULTS -->

			<!-- BEGIN TAB CONTENT -->
			<div class="card-body tab-content style-default-bright">
				<div class="tab-pane active" id="web1">
					<div class="row">
						<div class="col-lg-12">

							<!-- BEGIN PAGE HEADER -->
							<div class="margin-bottom-xxl">
								<span class="text-light text-right">
									سفارش
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
								<div class='row text-center fade' ng-class="{in:!load}">
									<div class='spinner '>
										<div class='ring1'>
											<div class='ring2'>
												<div class='ring3'></div>
											</div>
										</div>
									</div>
								</div>
								<div class="alert alert-warning fade rtl" ng-class="{in:orders.length==0 }">هیچ سفارشی پیدا نشد!</div>
								<div class="table-responsive rtl fade" ng-class="{in:load && orders.length }">
									<table class="table table-bordered text-right table-hover table-condensed">
										<thead>
											<tr class="active">
												<th>مشتری</th>
												<th>موبایل</th>
												<th>کد سفارش</th>
												<th>مبلغ</th>
												<th>پرداخت شده</th>
												<th>وضعیت</th>
												<th>تاریخ</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="order in orders"  title="{{order.id}}">

                                                <td>
                                                    <a href="/admin/user-{{order.user_id}}#o={{order.id}}"
                                                       target="_blank">
                                                        {{order.user}}
                                                    <a/>
                                                </td>
                                                <td>
                                                    <a href="/admin/user-{{order.user_id}}#o={{order.id}}"
                                                       target="_blank">
                                                        {{order.tel}}
                                                    </a>
                                                <td>
                                                    <a href="/admin/user-{{order.user_id}}#o={{order.id}}"
                                                       target="_blank">{{order.code}}
                                                    </a>
                                                </td>
                                                <td>{{order.final_price| currency:'':0}}</td>
												<td>{{order.payment| currency:'':0}}</td>
												<td >
													<div class="dropdown">
														<span class="label label-fa" data-toggle="dropdown" style="background-color: #{{getStatus(order.status).color}}" >
															<span class="caret"></span>
															{{getStatus(order.status).title}}
														</span>
														<ul class="dropdown-menu animation-dock">
															<li ng-repeat="status in statuses" style="background-color: #{{status.color}}"><a href="#" ng-click="updateStatus(order,status)">{{status.title}}</a></li>
														</ul>
													</div>
												</td>
												<td>{{order.created | jdate}}</td>
											</tr>
										</tbody>
									</table>
								</div>

								<paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true"
									paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"> </paging>

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
					<?php  $this->get('OrderDetail'); ?>
				</div>
				<div class="modal-footer">
					<a class="btn btn-warning" href="/admin/items?q={{order.code}}&u={{order.user_id}}" target="_self">
						ویرایش محصولات <i class="fa fa-pencil"></i>
					</a>
					<button class="btn btn-info " ng-click="printInvoice()">
						چاپ <i class="fa fa-print"></i>
					</button>
					<a class="btn btn-info" href="../order-{{order.id}}.pdf" target="_blank" download="boilerplate_{{order.code}}.pdf">
						PDF <i class="fa fa-file-pdf-o"></i>
					</a>
					<a class="btn btn-info" href="../order-{{order.id}}.jpg" target="_blank" download="boilerplate_{{order.code}}.jpg">
						ذخیره تصویر <i class="fa fa-file-image-o"></i>
					</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
				</div>
			</div>
		</div>
	</div>
	
		<?php  $this->get('OrderPrint'); ?>		
		
</section>