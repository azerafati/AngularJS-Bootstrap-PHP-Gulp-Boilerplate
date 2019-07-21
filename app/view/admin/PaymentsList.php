<section ng-app="list" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li>پرداخت ها</li>
			<li class="active">
			<?php
			echo isset($_REQUEST["paid"]) ? 'پرداخت های تایید شده' : 'همه پرداخت ها';
			?>
			</li>
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
									پرداخت
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
								<div class="alert alert-warning fade rtl" ng-class="{in:payments.length==0 }">هیچ پرداختی پیدا نشد!</div>
								<div class="table-responsive rtl fade" ng-class="{in:load && payments.length }">
									<table class="table table-bpaymented text-right table-hover table-condensed">
										<thead>
											<tr class="active">
												<th>#</th>
												<th>مشتری</th>
												<th>کد سفارش</th>
												<th>
													مبلغ <small>(تومان)</small>
												</th>
												<th>کد پیگیری از بانک</th>
												<th>وضعیت</th>
												<th>تاریخ</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="payment in payments" ng-class="{info:payment.income==3,danger:payment.income==2}">
												<td>{{payment.id}}</td>
												<td>{{payment.fname}} {{payment.lname}}</td>
												<td>{{payment.code}}</td>
												<td>{{payment.amount| currency:'':0}}</td>
												<td ng-show="payment.income==1">{{payment.refnum}}</td>
												<td ng-show="payment.income==2">واریز به حساب مشتری</td>
												<td ng-show="payment.income==3">پرداخت از اعتبار</td>
												<td>
													<div class="dropdown" ng-show="payment.income==1">
														<span class="label label-fa" ng-class="{'label-success':payment.ok,'label-default':!payment.ok}"data-toggle="dropdown" >
															<span class="caret"></span>
															{{payment.ok?'تایید شده ':'در انتظار تایید'}}
														</span>
														<ul class="dropdown-menu animation-dock">
															<li  ><a href="#" ng-click="updateVerified(payment)">{{!payment.ok?'تایید شده ':'در انتظار تایید'}}</a></li>
														</ul>
													</div>
												</td>
												<td>{{payment.created | jdate}}</td>
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

</section>