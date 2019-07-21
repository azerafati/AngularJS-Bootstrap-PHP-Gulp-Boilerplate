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
					<div class="btn-group">
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
					<i class="fa fa-fw fa-cog"></i>
					هزینه های بسته بندی
				</header>
			</div>
			<!--end .card-head -->
			<div class="card-body style-default-bright">
					<table class="table rtl text-right table-pointer">
						<thead>
							<tr>
								<th>#</th>
								<th>از وزن</th>
								<th>تا وزن</th>
								<th>هزینه</th>
							</tr>

						</thead>
						<tbody>
							<tr ng-repeat="price in prices" ng-click="showPkgPrice(price)">
								<td>{{price.id}}</td>
								<td>{{price.min | number:0}}</td>
								<td>{{price.max | number:0}}</td>
								<td>{{price.price | number:0}}</td>
							</tr>
						</tbody>

					</table>


			</div>
			<div class="card-actionbar ">
				<div class="card-actionbar-row">
					<button class="btn  ink-reaction btn-primary" ng-click="showPkgPrice({keywords:[]})">افزودن</button>
				</div>
			</div>
		</div>

	</div>


	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="formModalLabel">{{editPkgPrice.max}} - {{editPkgPrice.min}}</h4>
				</div>
				<form class="form-horizontal rtl" role="form">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="editPkgPrice.min" class="form-control" placeholder="">
							</div>
							<div class="col-sm-3">
								<label for="email1" class="control-label">از وزن</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="editPkgPrice.max" class="form-control" placeholder="">
							</div>
							<div class="col-sm-3">
								<label class="control-label">تا وزن</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="editPkgPrice.price" class="form-control" placeholder="">
							</div>
							<div class="col-sm-3">
								<label class="control-label">هزینه بسته بندی</label>
							</div>
						</div>
						

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
						<button type="button" class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="saveEditPkgPrice()">ذخیره</button>
						<button type="button" class="btn ink-reaction btn-raised btn-danger" data-dismiss="modal" ng-click="removeEditPkgPrice()">حذف</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</section>