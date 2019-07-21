<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 main-col" ng-controller="basketPageCtrl">
    <h2 class=" text-center text-accent">
        سبد خرید <i class="fa fa-shopping-cart"></i>
    </h2>
    <hr/>
    <div class="row half-gutter">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body text-default-light small-padding">
                    <div class="alert alert-warning rtl text-justify hardfade  up-xs" id="noProd" ng-class="{in:!items.length && !spinner}">
                        <i class="fa fa-warning"></i> سبد خرید شما خالی است
                    </div>
                    <div class=' text-right hardfade' ng-class="{in:orderItems.length}">
                        <p>
                            <span style="direction: rtl; display: inline-block;">{{basket.code}}</span>
                            : کد سفارش
                        </p>
                    </div>
                    <div class='row text-center hardfade' ng-class="{in:spinner}">
                        <div class='spinner'>
                            <div class='ring1'>
                                <div class='ring2'>
                                    <div class='ring3'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="az-table fade" ng-class="{in:!spinner && items.length }">
                    <table class="table table-hover rtl text-center table-bordered " id="items" style="margin-bottom: 0;">
                        <thead>
                        <tr>
                            <th class="">#</th>
                            <th>تصویر</th>
                            <th>نام کالا</th>
                            <th>تعداد</th>
                            <th>قیمت واحد</th>
                            <th>جمع</th>
                            <th>توضیحات</th>
                        </tr>
                        </thead>
                        <tbody ng-form="itemsForm">
                        <tr class="" ng-repeat="(index,item) in items">
                            <td>
								<span class="btn-remove" title="حذف محصول" ng-click="removeItem(item)">
									<i class="fa fa-times"></i>
								</span>
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
                                <div class="form-group ">
                                    <label>تعداد</label>
                                    <select class="form-control" ng-model="item.qty" ng-change="update_qty(item)" ng-class="{loading:item.loadingQty}" ng-options="q for q in range(1,10)"></select>
                                </div>
                            </td>
                            <td class="" data-title="قیمت:">{{item.unit_price| currency:'':0}}</td>
                            <td class="" data-title="جمع:">{{item.total_price| currency:'':0}}</td>
                            <td class="" data-title="توضیحات:">
                                <button class="btn btn-info btn-xs" ng-class="{loading:item.loadingInfo}" ng-hide="item.cus_info" ng-click="addInfo(item)">
                                    <i class="fa fa-pencil"></i> افزودن توضیحات
                                </button>
                                <button class="btn btn-info btn-xs" ng-class="{loading:item.loadingInfo}" ng-show="item.cus_info" ng-click="addInfo(item)">
                                    <i class="fa fa-pencil"></i> ویرایش توضیحات
                                </button>
                                <p>
                                    {{item.cus_info}} </p>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">بسته بندی</td>
                            <td colspan="2" class="text-right">{{basket.pkg_price | currency:'':0}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="no-gutter">
                                <div class="col-sm-6 col-xs-12">هزینه پست</div>
                                <div class="col-sm-5 col-sm-pull-1  col-xs-12 up-xs">
                                    <select class="form-control input-sm rtl" ng-model="basket.splan" ng-change="updatePlan()" ng-class="{loading:updatingPlan}" ng-options="plan.id as plan.name for plan in splans"></select>
                                </div>
                            </td>
                            <td id="pkg_price" colspan="2" class="text-right">{{basket.shipment_price | currency:'':0}}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5">جمع کل</th>
                            <th id="total_order_price" colspan="2">{{basket.final_price | currency:'':0}} &nbsp;&nbsp;تومان</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row hardfade" id="submitOrder" ng-class="{in:!spinner && items.length }">
        <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3" ng-hide="submit">
            <button class="btn btn-success btn-lg btn-block" ng-click="submitOrder()">
                تایید و ادامه خرید <i class="fa fa-check fa-lg pull-right"></i>
            </button>
        </div>
    </div>
    <div class="row hardfade" ng-class="{in:submit}">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-head card-head-xs rtl">
                    <header>
                        آدرس پستی <i class="fa fa-truck"></i>
                    </header>
                </div>
                <div class="card-body small-padding">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-sm pull-right" type="button" ng-click="editAddress()">
                                ایجاد آدرس جدید <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row half-gutter rtl up-2 " ng-repeat="a in addresses">
                        <div class="col-xs-4 col-sm-2">
                            <div class=" btn-group btn-group-xs">
                                <button class="btn btn-xs btn-info"  ng-click="editAddress(a)" >ویرایش</button>
                                <button class="btn btn-xs btn-danger"  ng-click="removeAddress(a)">حذف</button>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-9">
                            {{a.name}} : {{a.province}} - {{a.city}} - {{a.detail}}
                        </div>
                        <div class="col-xs-2 col-sm-1"><label class="radio-inline radio-styled">
                                <input type="radio" name="basketAddress" value="{{a.id}}" ng-model="$parent.selectedAdrs">
                                <span>{{a.title}}</span>
                            </label></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hardfade" ng-class="{in:submit}">
        <div class="alert alert-success up-2 rtl" ng-class="{'alert-success':agreement,'alert-danger':!agreement}">
            <div class="checkbox checkbox-styled checkbox-success">
                <label> <input type="checkbox" value="" required ng-model="agreement" checked="checked">
                    <span>
  									موافقت خود را با
  									<a href="/شرایط-قوانین"  target="_blank" class="text-accent">شرایط و قوانین</a>
  									مربوط به ثبت و رویه‌های پردازش سفارشات boilerplate، اعلام می کنم.
  								</span>
                </label>
            </div>
        </div>
        <div class="row up-2">
            <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <button class="btn btn-success btn-lg btn-block" ng-disabled="!agreement" ng-class="{loading:paying}" ng-click="pay()">
                    تایید و پرداخت <i class="fa fa-check fa-lg pull-right"></i>
                </button>
            </div>
        </div>

        <div class="row up-2">
            <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3 text-center">
                <button class="btn  btn-default " ng-disabled="!agreement" ng-class="{loading:paying}" type="button" ng-click="submitWithoutPayment()">
                    ثبت سفارش بدون پرداخت
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade " id="itemInfo" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">توضیحات</h4>
                </div>
                <div class="modal-body rtl clearfix">

                <textarea class="form-control" rows="4" ng-model="itemCusInfo">


                </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" ng-click="saveInfo()">ذخیره
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="addressModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">آدرس</h4>
                </div>
                <div class="modal-body rtl clearfix">
                    <div class="col-xs-12">
                        <div class="panel-body rtl row">
                            <form ng-submit="saveAddress(address)" novalidate name="addressForm">
                                <div class="row rtl">
                                    <div class="col-sm-4 pull-right">
                                        <div class="form-group">
                                            <label>عنوان</label>
                                            <input type="text" name="postalcode" class="form-control" placeholder="برای مثال (خانه، محل کار)" ng-model="address.title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>کدپستی</label>
                                        <input type="text" name="postalcode" class="form-control" placeholder="لطفا کدپستی خود را وارد کنید" ng-model="address.postalcode">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" ng-class="{ 'has-error' : addressForm.number.$invalid && !addressForm.number.$pristine }">
                                        <label> شماره تماس
                                            <small>(دریافت پیامک و ارتباط در تلگرام)</small>
                                        </label>
                                        <input type="tel" ng-pattern="/^0[0-9]{10}$/" class="form-control" placeholder="لطفا شماره موبایل خود را وارد کنید" name="number" ng-model="address.number" required/>
                                        <p ng-show="addressForm.number.$invalid && !addressForm.number.$pristine" class="help-block">
                                            شماره تماس وارد شده صحیح نیست</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" ng-class="{ 'has-error' : addressForm.name.$invalid && !addressForm.name.$pristine }">
                                        <label>نام گیرنده
                                            <small>(لطفا از حروف فارسی استفاده کنید)</small>
                                        </label>
                                        <input type="text" name="name" class="form-control" placeholder="نام گیرنده را وارد کنید" ng-model="address.name" ng-minlength="5" required>
                                        <p ng-show="addressForm.name.$invalid  && !addressForm.name.$pristine" class="help-block">
                                            لطفا نام کامل را وارد کنید</p>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sm-push-9">
                                    <div class="form-group " ng-class="{ 'has-error' : addressForm.province.$invalid && !addressForm.province.$pristine }">
                                        <label>استان</label>
                                        <select name="province" class="form-control" ng-model="address.province_id" ng-change="loadCities()" ng-options="province.id as province.name for province in provinces" required>
                                            <option class="hidden" value="">استان را انتخاب کنید</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sm-push-3">
                                    <div class="form-group" ng-class="{ 'has-error' : addressForm.city.$invalid && !addressForm.city.$pristine }">
                                        <label>شهر</label>
                                        <select class="form-control" ng-class="{'loading':loadingCities}" name="city" ng-model="address.city_id" ng-options="city.id as city.name for city in cities" required>
                                            <option class="hidden" value=""> شهر را انتخاب کنید</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-sm-pull-6">
                                    <div class="form-group" ng-class="{ 'has-error' : addressForm.detail.$invalid && !addressForm.detail.$pristine }">
                                        <label>آدرس پستی</label>
                                        <textarea type="address" class="form-control" name="detail" ng-model="address.detail" placeholder="آدرس  دقیق ارسال محصولات را وارد کنید بدون نام استان و شهرستان" ng-minlength="5" required></textarea>
                                        <p ng-show="addressForm.detail.$invalid  && !addressForm.detail.$pristine" class="help-block">
                                            لطفا آدرس کامل خود را وارد کنید</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" ng-click="saveAddress(address)" ng-disabled="addressForm.$invalid">ذخیره</button>
                </div>
            </div>
        </div>
    </div>
</div>