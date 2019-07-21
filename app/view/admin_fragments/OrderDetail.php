<div>
	<div class="col-sm-12 ">
		<div class="" ng-show="order.basket">
			<form ng-submit="addItem()" name="addItemForm">
				<div class=" row half-gutter">
					<div class=" col-sm-10  ">
						<div class="form-group">
							<input name="link" id="link" ng-model="addItemLink" class="form-control " placeholder="لینک" />
						</div>
					</div>
					<div class=" col-sm-2  ">
						<button class="btn btn-primary btn-block" id="addProd" ng-class="{loading:addingItem}">
							افزودن به سبد <i class="fa fa-plus "></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="fade table-responsive" ng-class="{in:orderLoad}">
	<table class="table table-hover rtl text-right table-bordered " id="items" style="margin-bottom: 0;">
		<thead>
			<tr class="active">
				<th>#</th>
				<th></th>
				<th>نوع</th>
				<th>تعداد</th>
				<th>
					قیمت
				</th>

				<th>
					وزن <small>(گرم)</small>
				</th>
				<th>شماره خرید</th>
				<th>وضعیت</th>
				<th>مبلغ</th>
			</tr>
		</thead>
		<tbody class="text-center" style="font-size: 12px;" title="{{item.id}}">
			<tr ng-repeat="item in orderItems">

				<td>
					<span class="btn-remove" title="حذف محصول" ng-click="removeItem(item)" ng-show="order.basket">
						<i class="fa fa-times"></i>
					</span>
					<p class="item-idx">{{$index+1}}</p>
				</td>
				<td class="ltr no-gutter az-table-row" style="padding: 2px; max-width: 200px;">
					<div class="col-sm-4">
						<a href="{{item.link}}" target="_blank">
							<img class="img img-thumbnail" title="{{item.title}}" ng-src="{{'/res/img/prod/'+item.product_rnd+'/'+item.product_url+'.jpg'}}" style="height: 80px;"></img>
						</a>
					</div>
					<div class="col-sm-8 details text-left">
						{{item.product_name}}<br />
						<span style="color: #8A1010;">{{item.product_code}}</span>


					</div>
				</td>

				<td>
					<div class="form-group " ng-repeat="(name,values) in item.vars">
						<label>{{name==='size'?'سایز':name==='length'?'قد':name}}</label>
						<select class="form-control input-sm" ng-model="item.selectedvars[name]" ng-change="update_var(item)"
							ng-class="{loading:item.loadingVar,'input-alert':!item.selectedvars[name]}" ng-options="val disable when existsVar(name,val,item) for val in values" required>
							<option value="" class="hidden"></option>
						</select>
					</div>
				</td>
				<td az-editable="qty" ng-model="item" class="col-sm-1" az-act="refreshOrder()"></td>
				<td az-editable="price" ng-model="item" class="col-sm-1" az-act="refreshOrder()"></td>
				<td az-editable="weight" ng-model="item" class="col-sm-1" az-act="refreshOrder()"></td>
				<td az-editable="site_order_num" ng-model="item" class="col-sm-1" az-act="refreshOrder()"></td>
				<td>
					<div class="dropdown">
						<span class="label label-fa" data-toggle="dropdown" style="background-color: #{{getStatusItem(item.status).color}}">
							<span class="caret"></span>
							{{getStatusItem(item.status).title}}
						</span>
						<ul class="dropdown-menu animation-dock" aria-labelledby="dropdownMenu1">
							<li ng-repeat="status in statusesItem" style="background-color: #{{status.color}}"><a href="#" ng-click="updateStatusItem(item,status)">{{status.title}}</a></li>
						</ul>
					</div>
				</td>
				<td>{{item.total_price|number}}</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">مجموع قیمت کالا</td>
				<td colspan="1" class="text-right">{{order.total_price | number}}</td>
			</tr>
			<tr>
				<td colspan="8">مجموع وزن</td>
				<td colspan="1" class="text-right">{{order.weight|number}}</td>
			</tr>
			<tr>
				<td colspan="8">هزینه ارسال خارج از کشور</td>
				<td colspan="1" class="text-right">{{order.import_price | currency:'':0}}</td>
			</tr>
			<tr>
                <td colspan="1" class="no-gutter">
					 {{order.splan}}
				</td>
                <td colspan="1" class="rtext">
                    <div class="checkbox checkbox-styled no-margin"><label>
                            <input type="checkbox" ng-click="editOrder(order,'post_manual',!order.post_manual)" ng-model="order.post_manual">
                            <span>محاسبه توسط سیستم</span>
                        </label></div>
                </td>

                <td colspan="1" class="rtext">
                 بسته بندی =
                </td>
                <td az-editable="order-set-pkg_price" ng-model="order.pkg_price" data-id="{{order.id}}"
                    data-formatter="number" class="col-sm-1" az-act="refreshOrder()"></td>
                <td colspan="1" class="rtext">
پست =                </td>
                <td az-editable="order-set-shipment_price" ng-model="order.post_price" data-id="{{order.id}}"
                    data-formatter="number" class="col-sm-1" az-act="refreshOrder()"></td>
                <td colspan="2" class="rtext">
					هزینه بسته بندی و پست
				</td>
				<td id="pkg_price" colspan="1" class="text-right">{{order.shipment_price | currency:'':0}}</td>
			</tr>
			<tr>
				<th colspan="8">جمع کل</th>
				<th id="total_order_price" colspan="1" class="text-right">{{order.final_price | currency:'':0}} &nbsp;&nbsp;تومان</th>
			</tr>
		</tfoot>
	</table>
</div>