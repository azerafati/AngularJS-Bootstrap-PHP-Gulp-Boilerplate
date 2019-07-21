<section ng-app="list" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li>بسته بندی و ارسال</li>
			<li class="active">اولویت بسته بندی</li>
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
								<div class="btn-group btn-group-sm pull-right">
									<button type="button" class="btn btn-default-light dropdown-toggle" data-toggle="dropdown">
										<span class="fa fa-arrow-down"></span>
										مرتب کردن
									</button>
									<ul class="dropdown-menu dropdown-menu-right animation-dock" role="menu">
										<li ng-class="{active:sort_id==2}"><a href="#" ng-click="sort(2)">تاریخ</a></li>
										<li ng-class="{active:sort_id==3}"><a href="#" ng-click="sort(3)">تعداد کالا</a></li>
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
								<div class="alert alert-warning fade rtl" ng-class="{in:users.length==0 }">هیچ موردی پیدا نشد!</div>
								<div class="table-responsive rtl fade" ng-class="{in:load && users.length }">
									<table class="table table-bordered text-right table-hover table-condensed">
										<thead>
											<tr class="active">
												<th>#</th>
                                                <th>مشتری</th>
                                                <th>تلفن</th>
                                                <th>تعداد کالا</th>
												<th>مجموع وزن</th>
												<th>هزینه بسته بندی و ارسال</th>
												<th>تاریخ سفارش اولین کالا</th>
											</tr>
										</thead>
										<tbody>
                                        <tr ng-repeat="user in users" title="{{user.id}}">
                                            <td>{{user.idx}}</td>
                                            <td><a href="/admin/user-{{user.id}}" target="_blank">{{user.fname}}
                                                                                                       {{user.lname}}</a>
                                            </td>
                                            <td><a href="/admin/user-{{user.id}}" target="_blank">{{user.tel}}</a>
                                            </td>
                                            <td>{{user.items}}</td>
                                            <td>{{user.items_weight|number}}</td>
                                            <td>{{user.shipment_price|number}}</td>
                                            <td>{{user.fdate|jdate}}</td>
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