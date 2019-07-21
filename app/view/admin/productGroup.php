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
					گروه های وزنی
				</header>
			</div>
			<!--end .card-head -->
			<div class="card-body style-default-bright">
					<table class="table rtl text-right table-pointer">
						<thead>
							<tr>
								<th>#</th>
								<th>نام گروه</th>
								<th>وزن</th>
								<th>کلید واژه</th>
							</tr>

						</thead>
						<tbody>
							<tr ng-repeat="pg in productGroups" ng-click="showGroup(pg)">
								<td>{{pg.id}}</td>
								<td>{{pg.title}}</td>
								<td>{{pg.weight}}</td>
								<td>
									<button type="button" class="btn ink-reaction btn-default btn-xs fa-right" ng-repeat="key in pg.keywords">{{key.keyword}}</button>
								</td>
							</tr>
						</tbody>

					</table>


			</div>
			<div class="card-actionbar ">
				<div class="card-actionbar-row">
					<button class="btn  ink-reaction btn-primary" ng-click="showGroup({keywords:[]})">گروه جدید</button>
				</div>
			</div>
		</div>

	</div>


	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="formModalLabel">{{editPg.title}}</h4>
				</div>
				<form class="form-horizontal rtl" role="form">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="editPg.title" class="form-control" placeholder="نام گروه">
							</div>
							<div class="col-sm-3">
								<label class="control-label">نام گروه</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="editPg.info" class="form-control" placeholder="توضیحات">
							</div>
							<div class="col-sm-3">
								<label  class="control-label">توضیحات</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="editPg.weight" class="form-control" placeholder="وزن">
							</div>
							<div class="col-sm-3">
								<label  class="control-label">وزن</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<div class="input-group">
									<div class="input-group-content">
										<input type="text" class="form-control" ng-model="newKey">
									</div>
									<div class="input-group-btn">
										<button class="btn btn-default" type="button" ng-click="addKey()"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<label for="password1" class="control-label">کلید واژه جدید</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<div class="btn-group btn-group-xs fa-right up" ng-repeat="key in editPg.keywords">
									<button type="button" class="btn ink-reaction btn-default-light">{{key.keyword}}</button>
									<button type="button" class="btn ink-reaction btn-primary " ng-click="editPg.keywords.splice($index, 1)">
										<i class="fa fa-times"></i>
									</button>
								</div>
							</div>
							<div class="col-sm-3">
								<label class="control-label">کلید ها</label>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
						<button type="button" class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="saveEditPg()">ذخیره</button>
						<button type="button" class="btn ink-reaction btn-raised btn-danger" data-dismiss="modal" ng-click="removeEditPg()">حذف</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</section>