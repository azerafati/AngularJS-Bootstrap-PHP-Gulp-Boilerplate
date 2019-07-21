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
					<div class="btn-link">
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
					<i class="fa fa-fw fa-cog"></i> کانال تلگرام
				</header>
			</div>
			<!--end .card-head -->
			<div class="card-body style-default-bright">
			<div class="col-sm-5">
				<form class="rtl form" role="form" action="api/telegram-post" method="post">
						<div class="form-group floating-label">
								<input type="text" ng-model="link" name='link' class="form-control" >
								<label>لینک محصول برای ارسال به کانال</label>
						</div>
						<button class="btn ink-reaction btn-raised btn-primary">ارسال</button>
				</form>
			</div>
			</div>
			
		</div>

	</div>



</section>