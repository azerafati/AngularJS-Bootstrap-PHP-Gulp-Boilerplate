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
					<div class="btn-site">
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
							<th>هزینه واردات (گرم)</th>
							<th>کارگو (لیر برای هر محصول)</th>
							<th>فعال</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="site in sites" ng-click="edit(site)">
							<td>{{site.id}}</td>
							<td>{{site.name}}</td>
							<td az-editable="site-import" ng-model="site.import_price"  data-id="{{site.id}}" class="col-sm-2"></td>
							<td az-editable="site-cargo" ng-model="site.cargo"  data-id="{{site.id}}" class="col-sm-2"></td>
							<td>
								<label class="checkbox-inline checkbox-styled">
									<input type="checkbox" ng-click="toggleActive(site)" ng-model="site.active" >
									<span></span>
								</label>
							</td>
						</tr>
					</tbody>
				</table>

			</div>
			
		
		</div>

	</div>




</section>