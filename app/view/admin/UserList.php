<section ng-app="post" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li class="active">مشتریان</li>
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

                                <a target="_blank" href="api/user/getCSV" class="btn btn-default-light dropdown-toggle" >
                                    <span class="fa fa-download"></span>
فایل CSV                                </a>
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
							<div class="alert alert-warning fade rtl" ng-class="{in:users.length==0 }">هیچ موردی پیدا نشد!</div>
							<div class="table-responsive rtl fade" ng-class="{in:load && users.length }">
								<table class="table table-bordered text-right table-hover table-condensed">
									<thead>
										<tr class="active">
											<th>#</th>
											<th th-sortable="2">نام</th>
											<th th-sortable="4">شماره تماس</th>
											<th>شهر</th>
											<th>گروه</th>
											<th th-sortable="5">اعتبار</th>
											<th th-sortable="1">عضویت</th>
											<th th-sortable="3">آخرین ورود</th>
											<th th-sortable="4">اخرین سفارش</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="user in users"  title="{{user.id}}">
											<td> <a class="btn btn-default btn-sm btn-block ink-reaction btn-raised" target="_blank"
                                                         href="user-{{user.id}}">
                                                    <i class="fa fa-plus-circle fa-lg"></i>
                                                </a></td>
											<td>
                                                <a  href="user-{{user.id}}" target="_blank" >{{user.fname }} {{ user.lname }}</a></td>
											<td><a  href="user-{{user.id}}" target="_blank" >{{user.tel}}</a></td>
											<td>{{user.province }} - {{ user.city }}</td>
											<td>{{user.group_name}}</td>
											<td class="ltr" style="color : {{user.balance<0?'red':'green'}}">{{user.balance|number:0}}</td>
											<td "  title="{{user.created|jdate}}">{{user.created|jdate:' '}}</td>
											<td "  title="{{user.last_login|jdate}}">{{user.last_login|jdate:' '}}</td>
											<td " title="{{user.last_order|jdate}}">{{user.last_order|jdate:' '}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true"
					paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"> </paging>

			</div>
			<!--end .card-body -->
			<!-- END TAB CONTENT -->

		</div>
		<!--end .card -->
	</div>



</section>