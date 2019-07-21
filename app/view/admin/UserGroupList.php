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
					گروه های کاربری
				</header>
			</div>
			<!--end .card-head -->
			<div class="card-body style-default-bright">
				<p class="fade <?php echo $_POST['submit']? "in":""  ?>">yeaaa</p>

					<table class="table rtl text-right table-pointer">
						<thead>
							<tr>
								<th>#</th>
								<th>نام گروه</th>
								<th>نرخ لیره</th>
								<th>نرخ دلار</th>
								<th>نرخ یورو</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="group in groups" ng-click="edit(group)">
								<td>{{group.id}}</td>
								<td>{{group.name}}</td>
								<td>{{group.value_tl|number:0}}</td>
								<td>{{group.value_us|number:0}}</td>
								<td>{{group.value_eu|number:0}}</td>
							</tr>
						</tbody>
					</table>


			</div>
			<div class="card-actionbar ">
				<div class="card-actionbar-row">
					<button class="btn  ink-reaction btn-primary" ng-click="edit({})">گروه جدید</button>
				</div>
			</div>
		</div>

	</div>


	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="formModalLabel">{{group.name}}</h4>
				</div>
				<form class="form-horizontal rtl" role="form">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="group.name" class="form-control" placeholder="نام گروه">
							</div>
							<div class="col-sm-3">
								<label class="control-label">نام گروه</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="group.value_tl" class="form-control" placeholder="نرخ لیره">
							</div>
							<div class="col-sm-3">
								<label  class="control-label">نرخ لیره</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="group.value_us" class="form-control" placeholder="نرخ دلار">
							</div>
							<div class="col-sm-3">
								<label  class="control-label">نرخ دلار</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" ng-model="group.value_eu" class="form-control" placeholder="نرخ یورو">
							</div>
							<div class="col-sm-3">
								<label  class="control-label">نرخ یورو</label>
							</div>
						</div>
						

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
						<button type="button" class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="save()">ذخیره</button>
						<button type="button" class="btn ink-reaction btn-raised btn-danger" data-dismiss="modal" ng-click="remove()" ng-hide="group.id==1">حذف</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</section>