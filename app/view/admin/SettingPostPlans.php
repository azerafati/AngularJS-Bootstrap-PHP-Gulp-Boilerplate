<section ng-app="list" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li class="active">تنظیمات</li>
		</ol>
	</div>
	<div class="section-body contain-lg">
		<div class="card card-underline">
			<div class="card-head">
				<div class="tools">
					<div class="btn-post">
						<a class="btn btn-icon-toggle btn-refresh">
							<i class="fa fa-refresh"></i>
						</a>
						<a class="btn btn-icon-toggle btn-collapse">
							<i class="fa fa-angle-down"></i>
						</a>
						<a class="btn btn-icon-toggle btn-close">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<header>
					<i class="fa fa-fw fa-cog"></i> سایت ها
				</header>
			</div>
			<!--end .card-head -->
			<div class="card-body style-default-bright">

				<div class='row text-center fade' ng-class="{in:!load}">
					<div class='spinner'>
						<div class='ring1'>
							<div class='ring2'>
								<div class='ring3'></div>
							</div>
						</div>
					</div>
				</div>

				<table class="table rtl text-right table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>سایت</th>
							<th>فعال</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="post in posts" ng-click="edit(post)">
							<td>{{post.id}}</td>
							<td>{{post.name}}</td>
							<td>
								<label class="checkbox-inline checkbox-styled"> <input type="checkbox" ng-model="post.active"> <span></span>
								</label>
							</td>
						</tr>
					</tbody>
				</table>

			</div>

			<div class="card-actionbar ">
				<div class="card-actionbar-row">
					<button class="btn  ink-reaction btn-primary" ng-click="edit({prices:{}})"> جدید</button>
				</div>
			</div>
		</div>

	</div>


	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="formModalLabel">{{post.name}}</h4>
				</div>
				<form class="form-horizontal rtl" role="form">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="post.name" class="form-control" placeholder="نام روش پستی">
							</div>
							<div class="col-sm-3">
								<label class="control-label">نام روش پستی</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<label class="checkbox-inline checkbox-styled"> <input type="checkbox" ng-model="post.active"> <span></span>
								</label>
							</div>
							<div class="col-sm-3">
								<label class="control-label">فعال</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<table class="table rtl text-right table-hover table-pointer">
									<thead>
										<tr>
											<th>از وزن</th>
											<th>تا وزن</th>
											<th>قیمت</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="pr in post.prices" ng-click="editPrice(pr)">
											<td>{{pr.min}}</td>
											<td>{{pr.max}}</td>
											<td>{{pr.price}}</td>
										</tr>
									</tbody>
								</table>
								<button type="button" class="btn btn-sm ink-reaction btn-raised btn-primary pull-left" ng-click="editPrice({})">
									<i class="fa fa-plus"></i>
								</button>
							</div>
							<div class="col-sm-3">
								<label class="control-label">قیمت پلکانی ارسال</label>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
						<button type="button" class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="save()">ذخیره</button>
						<button type="button" class="btn ink-reaction btn-raised btn-danger" data-dismiss="modal" ng-click="remove()" ng-hide="post.id==1">حذف</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


	<div class="modal fade" id="modal-price" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form class="form-horizontal rtl" role="form">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="pr.min" class="form-control" placeholder="از وزن">
							</div>
							<div class="col-sm-3">
								<label class="control-label">از وزن</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="pr.max" class="form-control" placeholder="تا وزن">
							</div>
							<div class="col-sm-3">
								<label class="control-label">تا وزن</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="pr.price" class="form-control" placeholder="قیمت">
							</div>
							<div class="col-sm-3">
								<label class="control-label">قیمت</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
						<button type="button" class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="prsave()">ذخیره</button>
						<button type="button" class="btn ink-reaction btn-raised btn-danger" data-dismiss="modal" ng-click="prremove()">حذف</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</section>