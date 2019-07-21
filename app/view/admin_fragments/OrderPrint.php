<div class="printable">
	<div class="col-xs-4 ">
		<table class="table table-info rtl">
			<tbody>
				<tr>
					<td>کد سفارش</td>
					<td>{{order.code}}</td>
				</tr>
				<tr>
					<td>تاریخ</td>
					<td>{{''| jdate}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#" >
			<img width="80" src="../res/img/logo.png"></img>
		</a>
	</div>
	<div class="col-xs-4 text-right ">
		<table class="table table-info rtl">
			<tbody>
				<tr>
					<td>مشتری</td>
					<td>{{order.user_name}}</td>
				</tr>
				<tr>
					<td>تلفن</td>
					<td>{{order.user_tel}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<table class="table table-condensed rtl text-center table-bordered up">
		<thead>
			<tr>
				<th class="">#</th>
				<th colspan="2">جزییات</th>
				<th>گروه وزنی</th>
				<th>قیمت واحد</th>
				<th>تعداد</th>
				<th>جمع</th>
				<th>وضعیت</th>
			</tr>
		</thead>
		<tbody>
			<tr class="" ng-repeat="(index,item) in orderItems">
				<td>
					<p class="item-idx">{{$index+1}}</p>
				</td>
				<td class="ltr half-gutter ">
					<div class="col-xs-4">
						<img class="img img-thumbnail" title="{{item.title}}" ng-src="../images/{{item.img}}.jpg" style="height: 70px"></img>
					</div>
					<div class="col-xs-8 details text-left">
						{{item.product_name}}<br />{{item.product_code}}<br />
						<span style="direction: ltr">{{item.price}} TL </span>
						<br />
						<img class="img-responsive " ng-src="../res/img/sites/{{item.site.id}}.jpg" alt="" width="60">
					</div>
				</td>
				<td >
					<div class="form-group " ng-repeat="(name,values) in item.vars">
						<label>{{name==='size'?'سایز':name==='length'?'قد':name}} : </label>
						<span class="">{{item.selectedvars[name]}}</span>
					</div>
				</td>
				<td class="" >{{item.weight}}</td>
				<td class="" >{{item.unit_price| currency:'':0}}</td>
				<td class="" >{{item.qty}}</td>
				<td class="" >{{item.total_price| currency:'':0}}</td>
				<td class="" >
					<span class="label label-fa" style="background-color: #{{item.status_color}}"> {{item.status}} </span>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">کارگو</td>
				<td colspan="2" class="text-right">{{order.cargo_price | currency:'':0}}</td>
			</tr>
			<tr>
				<td colspan="6">هزینه ارسال خارج از کشور</td>
				<td colspan="2" class="text-right">{{order.import_price | currency:'':0}}</td>
			</tr>
			<tr>
				<td colspan="6" class="no-gutter">
					<div class="col-xs-6">هزینه بسته بندی و پست</div>
					<div class="col-xs-5 col-xs-pull-1">
						<span class="">ارسال : {{order.splan}}</span>
					</div>
				</td>
				<td colspan="2" class="text-right">{{order.shipment_price | currency:'':0}}</td>
			</tr>
			<tr>
				<td colspan="6">جمع کل</td>
				<td colspan="2" class="text-right "><span class="fa-right">{{order.final_price | currency:'':0}}</span> &nbsp;&nbsp; تومان</td>
			</tr>
		</tfoot>
	</table>
</div>