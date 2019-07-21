<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1" ng-controller="orderCtrl">

	<div class="row">
		<div class="card rtl">
			<div class="card-head card-head-sm">
				<header>
                     سفارش ها <i class="fa fa-th-list"></i>
				</header>
			</div>
			<div class="panel-body ">
				<div class="alert alert-warning hardfade rtl" ng-class="{in:orders.length==0 }">هیچ سفارشی پیدا نشد!</div>
				<div class="alert alert-info fade rtl" ng-class="{in:balance != null}">
					اعتبار boilerplate شما <strong class="ltr" style="display: inline-block;">{{balance | number:0}}</strong> تومان است

					<button class="btn btn-default ltr hidden" ng-show="balance<0" ng-click="pay_all()" ng-class="{loading:payingAll}">
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
			<div class="az-table rtl fade" ng-class="{in:load && orders.length }">
				<table class="table table-bordered text-center table-hover ">
					<thead>
						<tr class="active">
							<th></th>
							<th>کد سفارش</th>
							<th>جمع مبلغ</th>
							<th>جمع پرداخت</th>
							<th>وضعیت</th>
							<th>تاریخ ثبت</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="order in orders" ng-class="{loading:order.loading}">
							<td data-title=" جزییات : ">
								<button class="btn btn-default btn-sm"  ng-click="showInvoice(order)">
									<i class="fa fa-hand-pointer-o fa-lg"></i> جزییات سفارش
								</button>
							</td>
							<td data-title="کد سفارش : ">{{order.code}}</td>
							<td data-title="جمع مبلغ : ">{{order.final_price| currency:'':0}}</td>
							<td data-title="جمع پرداخت : ">{{order.payment| number:0}}</td>
							<td data-title="وضعیت : " data-toggle="popover" data-container="body"  data-trigger="hover" data-placement="auto top"
								data-content="{{getMsgStatus(order.status)}}">
								<span class="label label-fa" style="background-color: #{{getStatus(order.status).color}}">{{getStatus(order.status).title}} </span>
							</td>
							<td data-title="تاریخ ثبت : ">{{order.created | jdate}}</td>
							<td data-title="پرداخت : " ng-class="{'hidden-xs':!(order.status==1||order.status==4)}">
								<button class="btn btn-info btn-sm" ng-show="order.status==1||order.status==4" ng-click="pay(order ,$event)">
									<i class="fa fa-credit-card"></i> پرداخت مبلغ سفارش
								</button>
							</td>
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
					<a class="btn btn-info up-xs" href="order-{{order.id}}.jpg" target="_blank" download="boilerplate_{{order.code}}.jpg">
						ذخیره تصویر <i class="fa fa-file-image-o"></i>
					</a>
					<button type="button" class="btn btn-default up-xs" data-dismiss="modal">بازگشت </button>
				</div>
			</div>
		</div>
	</div>



	

<?php  $this->get('OrderPrint'); ?>

</div>




