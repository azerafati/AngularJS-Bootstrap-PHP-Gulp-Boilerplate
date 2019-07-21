<div class="az-table fade" ng-class="{in:orderLoad}">
	<table class="table table-hover rtl text-center table-bordered " id="items" style="margin-bottom: 0;">
		<thead>
			<tr>
				<th class="">#</th>
                <th>تصویر</th>
                <th>نام کالا</th>
                <th>تعداد</th>
				<th>قیمت واحد</th>
				<th>جمع</th>
				<th>وضعیت</th>
			</tr>
		</thead>
		<tbody>
			<tr class="" ng-repeat="(index,item) in orderItems">
                <td>
                    <p class="item-idx">{{$index+1}}</p>
                </td>
                <td class="" data-title="تصویر : ">
                    <a href="/{{item.product_url}}" target="_blank">
                        <img class="img img-thumbnail" title="{{item.title}}" ng-src="{{'/res/img/prod/'+item.product_rnd+'/'+item.product_url+'.jpg'}}"/>
                    </a>
                </td>
                <td class="" data-title="نام کالا : ">
                    <a href="/{{item.product_url}}" target="_blank">
                        {{item.product_name}}<br/>
                        <small>{{item.product_code}}</small>
                    </a>
                </td>
				<td data-title="تعداد : ">
						<span class="">{{item.qty}}</span>
				</td>
				<td class="" data-title="قیمت:">{{item.unit_price| currency:'':0}}</td>
				<td class="" data-title="جمع:">{{item.total_price| currency:'':0}}</td>
				<td class="" data-title="وضعیت:">
					<span class="label label-fa" style="background-color: #{{item.status_color}}">
						{{item.status}}
					</span>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4">بسته بندی</td>
				<td colspan="3" class="text-right">{{order.pkg_price | currency:'':0}}</td>
			</tr>
			<tr>
				<td colspan="4" class="no-gutter">
					<div class="col-sm-6 col-xs-12">هزینه پست</div>
					<div class="col-sm-5 col-sm-pull-1  col-xs-12 up-xs">
						<span class="">ارسال : {{order.splan}}</span>
					</div>
				</td>
				<td id="pkg_price" colspan="3" class="text-right">{{order.shipment_price | currency:'':0}}</td>
			</tr>
			<tr>
				<th colspan="4">جمع کل</th>
				<th id="total_order_price" colspan="3" class="text-right">{{order.final_price | currency:'':0}} &nbsp;&nbsp;تومان</th>
			</tr>
		</tfoot>
	</table>
</div>