<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1" ng-app="payment" ng-controller="listCtrl">
	<div class="row">
		<div class="row text-center">
			<a href="//boilerplate.ir" title="boilerplate - خرید از سایت های خارجی">
				<img width="120" src="/res/img/logo.png"></img>
			</a>
		</div>
	</div>
	<hr />
	<div class="row">
	
	<div class="alert alert-info fade rtl" ng-class="{in:balance != null}">
		اعتبار شما نزد boilerplate <strong class="ltr" style="display: inline-block;">{{balance | number:0}}</strong> تومان است

		<button class="btn btn-default ltr hidden" ng-show="balance<0" ng-click="pay_all()" ng-class="{loading:payingAll}">
			 پرداخت <i class="fa fa-credit-card"></i>
		</button>
	</div>
	
	</div>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-right">
					پرداخت ها <i class="fa fa-th-list"></i>
				</h3>
			</div>
			<div class="panel-body">
				<div >
					<button class="btn btn-default " data-target="#addNew" data-toggle="modal">
						ثبت پرداخت <i class="fa fa-plus"></i>
					</button>
				</div>
				<div class="alert alert-warning hardfade rtl up" ng-class="{in:payments.length==0 }">هیچ تراکنشی از سمت شما ثبت نشده است!</div>

				<div class='row text-center hardfade' ng-class="{in:!loaded }">
					<div class='spinner  '>
						<div class='ring1'>
							<div class='ring2'>
								<div class='ring3'></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="az-table table-responsive rtl fade" ng-class="{in:loaded && payments.length }">
				<table class="table table-bordered text-right table-hover ">
					<thead>
						<tr class="active">
							<th>#</th>
							<th>
								مبلغ <small>(تومان)</small>
							</th>
							<th>سفارش</th>
							<th>کد پیگیری از بانک</th>
							<th>وضعیت</th>
							<th>تاریخ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="payment in payments" ng-class="{loading:payment.loading,success:payment.income==3,danger:payment.income==2}">
							<td>{{$index+1}}</td>
							<td>{{payment.amount| currency:'':0}}</td>
							<td ng-hide="payment.income==2">{{payment.order_code}}</td>
							<td colspan="3" ng-show="payment.income==2">این مبلغ به شما عودت داده شده و به حساب {{payment.refnum}} واریز شده است</td>
							<td colspan="2" ng-show="payment.income==3">این مبلغ از اعتبار شما برای سفارش {{payment.order_code}} استفاده شده است</td>
							<td ng-show="payment.income==1">{{payment.refnum}}</td>
							<td ng-show="payment.income==1">
								<span class="label label-fa label-success" ng-show="payment.ok">تایید شده است </span>
								<span class="label label-fa label-default" ng-hide="payment.ok">در انتظار تایید </span>
							</td>
							<td>
								<small>{{payment.date | jdate}}</small>
							</td>
							<td>
								<div class="btn-group" ng-hide="payment.ok">
									<button class="btn btn-xs btn-info" ng-click="repeat(payment)" ng-hide="payment.paytype !=1">
										<i class="fa fa-repeat"></i> تلاش دوباره
									</button>
									<button class="btn btn-xs btn-danger" ng-click="remove(payment.id)">
										<i class="fa fa-times"></i> حذف
									</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true"
			paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"> </paging>
	</div>



	<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="formModalLabel">ثبت پرداخت</h4>
				</div>
				<form class="rtl" role="form" name="newPaymentForm">
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label">مبلغ (فقط عدد)</label>
							<input type="number" ng-model="newPayment.amount" class="form-control" placeholder="مبلغ به تومان" required />
						</div>
						<div class="form-group">
							<label class="control-label"> تاریخ و ساعت </label>
							<div class="row">
								<div class="col-sm-7">
									<div class="input-group ltr no-gutter">
										<div class="col-xs-6">
											<div class="input-group">
												<select type="text" class="form-control" ng-model="newPayment.day">
													<option class="hidden" value="0">روز</option>
													<option ng-repeat="day in range(1,31)" value="{{day}}">{{day}}</option>
												</select>
												<span class="input-group-addon" style="border-radius: 0">/</span>
											</div>
										</div>
										<div class="col-xs-6">
											<select type="text" class="form-control" ng-model="newPayment.month">
												<option class="hidden" value="0">ماه</option>
												<option value="1">فروردین</option>
												<option value="2">اردیبهشت</option>
												<option value="3">خرداد</option>
												<option value="4">تیر</option>
												<option value="5">مرداد</option>
												<option value="6">شهریور</option>
												<option value="7">مهر</option>
												<option value="8">آبان</option>
												<option value="9">آذر</option>
												<option value="10">دی</option>
												<option value="11">بهمن</option>
												<option value="12">اسفند</option>
											</select>
										</div>
										<span class="input-group-addon">/1394</span>
									</div>
								</div>
								<div class="col-sm-5 up-xs">
									<div class="input-group ltr no-gutter">
										<select type="text" class="form-control" ng-model="newPayment.hour">
											<option class="hidden" value="0">ساعت</option>
											<option ng-repeat="h in range(0,23)" value="{{h}}">{{h}}</option>
										</select>
										<span class="input-group-addon">ساعت</span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">کد پیگیری (سریال یا شماره ارجاع)</label>
							<input type="text" ng-model="newPayment.refnum" class="form-control" placeholder="کد پیگیری">
						</div>
						<div class="form-group">
							<label class="control-label"> شماره حساب boilerplate </label>
							<input type="text" ng-model="newPayment.trace_code" class="form-control" placeholder="به کدام شماره حساب واریز کردید؟" required>
						</div>
						<div class="form-group">
							<label class="control-label">کد سفارش <small>(اگر خالی و یا اشتباه باشد، مبلغ پرداختی به اعتبار شما اضافه می شود)</small></label>
							<input type="number" ng-model="newPayment.order" class="form-control" placeholder="کد سفارش" ng-maxlength="6">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">بستن</button>
						<button class="btn ink-reaction btn-raised btn-primary" data-dismiss="modal" ng-click="savePayment()" ng-disabled="newPaymentForm.$invalid" ng-class="{loading:saving}">ذخیره</button>
					</div>
				</form>
			</div>
		</div>
	</div>


</div>