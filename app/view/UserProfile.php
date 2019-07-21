<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1" ng-app="order" ng-controller="listCtrl">
	<div class="row">
		<div class="row text-center">
			<a href="//boilerplate.ir" title="boilerplate - خرید از سایت های خارجی">
				<img width="120" src="/res/img/logo.png"></img>
			</a>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-right">
					لیست سفارش ها <i class="fa fa-th-list"></i>
				</h3>
			</div>
			<div class="panel-body ">
				<div class="alert alert-warning hardfade rtl" ng-class="{in:orders.length==0 }">هیچ سفارشی پیدا نشد!</div>
				<div class="alert alert-info fade rtl" ng-class="{in:balance != null}">
					اعتبار boilerplate شما <strong class="ltr" style="display: inline-block;">{{balance | number:0}}</strong> تومان است

					<button class="btn btn-default ltr" ng-show="balance<0" ng-click="pay_all()" ng-class="{loading:payingAll}">
						پرداخت <i class="fa fa-credit-card"></i>
					</button>
				</div>
				<div class='row text-center hardfade' style="position: relative;" ng-class="{in:!load || addingItem}">
					<div class='spinner'>
						<div class='ring1'>
							<div class='ring2'>
								<div class='ring3'></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive rtl fade" ng-class="{in:load && orders.length }">
				<table class="table table-bordered text-right table-hover table-pointer">
					<thead>
						<tr class="active">
							<th>کد سفارش</th>
							<th>جمع مبلغ</th>
							<th>جمع پرداخت</th>
							<th>وضعیت</th>
							<th>تاریخ ثبت</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="order in orders" ng-click="showInvoice(order)" ng-class="{loading:order.loading}">
							<td>{{order.code}}</td>
							<td>{{order.final_price| currency:'':0}}</td>
							<td>{{order.payment| currency:'':0}}</td>
							<td data-toggle="popover" data-container="body" title="{{getStatus(order.status).title}}" data-trigger="hover" data-placement="auto top"
								data-content="{{getMsgStatus(order.status)}}">
								<span class="label label-fa" style="background-color: #{{getStatus(order.status) .color">{{getStatus(order.status).title}} </span>
								<button class="btn btn-info btn-sm pull-left" ng-show="order.status==1||order.status==4" ng-click="pay(order ,$event)">
									<i class="fa fa-credit-card"></i> پرداخت
								</button>
							</td>
							<td>{{order.created | jdate}}</td>
							<!-- <td>
								<button class="btn btn-info btn-sm">فاکتور</button>
							</td> -->
						</tr>
					</tbody>

				</table>
			</div>

		</div>
		<paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true"
			paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"> </paging>
	</div>

	<div class="modal fade " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoice">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">صورتحساب سفارش {{order.code}}</h4>
				</div>
				<div class="modal-body " style="background-color: #fff">
					<div class='row text-center' style="position: relative;">
						<div class='spinner fade' ng-class="{in:!orderLoad}">
							<div class='ring1'>
								<div class='ring2'>
									<div class='ring3'></div>
								</div>
							</div>
						</div>
					</div>
					<?php  $this->get('OrderDetail'); ?>		
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger" ng-click="removeOrder(order)" ng-show="order.status==1">
						حذف سفارش <i class="fa fa-times"></i>
					</button>
					<button class="btn btn-info " ng-click="printInvoice()">
						چاپ <i class="fa fa-print"></i>
					</button>
					<a class="btn btn-info" href="order-{{order.id}}.pdf" target="_blank" download="boilerplate_{{order.code}}.pdf">
						PDF <i class="fa fa-file-pdf-o"></i>
					</a>
					<a class="btn btn-info" href="order-{{order.id}}.jpg" target="_blank" download="boilerplate_{{order.code}}.jpg">
						ذخیره تصویر <i class="fa fa-file-image-o"></i>
					</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
				</div>
			</div>
		</div>
	</div>



	

<?php  $this->get('OrderPrint'); ?>

</div>




