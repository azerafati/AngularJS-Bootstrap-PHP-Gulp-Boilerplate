<?php
if (isset($_REQUEST['id'])) {
    $address = AddressRepository::loadById($_REQUEST['id']);
} else {
    /* @var $shipment  Shipment */
    $shipment = ShipmentRepository::loadById($_REQUEST['s']);
    $address = AddressRepository::loadById($shipment->address_id);
    $post = PostPlanRepository::loadById($shipment->post_plan_id);
}
$address = AddressService::prepareForJson($address);
?>
<section ng-controller="printController" ng-app="app">
    <div class="section-header hidden-print">
        <ol class="breadcrumb">
            <li>چاپ آدرس</li>
        </ol>
    </div>
    <div class="section-body contain-lg">
        <div class="card">
            <div class="card-head hidden-print">
                <header>پیش نمایش</header>
                <div class="tools">
                    <div class="btn-group">
                        <button class="btn btn-primary btn-block" onclick="print()"><i class="fa fa-print"></i> چاپ
                        </button>
                    </div>
                </div>
            </div><!--end .card-head -->
            <div class="card-body">
                <div class="row printable" style="top:0;position:relative;font-size:13px">
                    <div class="text-center">
                        <img src="/res/admin/img/logo-square.png"  width="200" alt="">
                    </div>
                    <div class="table-responsive">
                        <table class="table rtl text-center table-bordered" id="table_address">
                            <tbody>
                            <tr>
                                <td>فرستنده</td>
                                <td> همدان - لالجین - خیابان مهدیه انتهای خیابان شهید پور مختار - کارگاه سفال و سرامیک نصیری</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>علیرضا نصیری</td>
                            </tr>
                            <tr>
                                <td>کد پستی</td>
                                <td>6533187738</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>09188134185</td>

                            </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <td>گیرنده</td>
                                <td>{{address.detail}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{address.name}}</td>
                            </tr>
                            <tr>
                                <td>کد پستی</td>
                                <td>{{address.postalcode}}</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>{{address.number}}</td>
                            </tr>
                            </tbody>
                        </table>
                            <span ng-show="post.label == 'پیشتاز'" style="left: 50px;position: absolute;display: block;background-color: #eee !important;padding: 2px 15px;top: 80px;opacity: 1;-webkit-print-color-adjust: exact;border-radius: 50%;font-size: 20px;">{{post.label}}</span>
                            <span ng-hide="post.label == 'پیشتاز'"  style="  margin-left: 30px;position: absolute;transform: rotate(-30deg); display: block;background-color: #eee !important;padding: 2px 15px;top: 120px;opacity: 0.7;border-radius: 5px;-webkit-print-color-adjust: exact; font-size: 15px">{{post.label}}</span>

                    </div>
                </div>
                <div class="row not-printable hidden-print" style="top:0;position:relative;font-size:13px">
                    <div class="table-responsive">
                        <table class="table rtl text-center table-bordered" id="table_address">
                            <tbody>
                            <tr>
                                <td>فرستنده</td>
                                <td> همدان - لالجین - خیابان مهدیه انتهای خیابان شهید پور مختار - کارگاه سفال و سرامیک نصیری

                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>علیرضا نصیری</td>
                            </tr>
                            <tr>
                                <td>کد پستی</td>
                                <td>6533187738</td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>09188134185</td>
                            </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <td>گیرنده</td>
                                <td>
                                    <input type="text" class="form-control text-center" ng-model="address.detail" ng-init="address.detail='<?= $address['province'] ?> - <?= $address['city'] ?> - <?= $address['detail'] ?>'"/>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="text" class="form-control text-center" ng-model="address.name" ng-init="address.name='<?= $address['name'] ?>'"/>
                                </td>
                            </tr>
                            <tr>
                                <td>کد پستی</td>
                                <td>
                                    <input type="text" class="form-control text-center" ng-model="address.postalcode" ng-init="address.postalcode='<?= $address['postalcode'] ?>'"/>
                                </td>
                            </tr>
                            <tr>
                                <td>شماره تماس</td>
                                <td>
                                    <input type="text" class="form-control text-center" ng-model="address.number" ng-init="address.number='<?= $address['number'] ?>'"/>
                                </td>
                            </tr>
                            </tbody>
                            <tr>
                                <td>نوع پست</td>
                                <td>
                                    <select ng-model="post.label" ng-init="post.label='<?= $post->label?>'" class="form-control text-center">
                                        <option value="سفارشی" >سفارشی</option>
                                        <option value="پیشتاز">پیشتاز</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <span ng-show="post.label == 'پیشتاز'" style="left: 50px;position: absolute;display: block;background-color: #eee !important;padding: 2px 15px;top: 80px;opacity: 1;-webkit-print-color-adjust: exact;border-radius: 50%;font-size: 20px;">{{post.label}}</span>
                        <span ng-hide="post.label == 'پیشتاز'"  style="  margin-left: 30px;position: absolute;transform: rotate(-30deg); display: block;background-color: #eee !important;padding: 2px 15px;top: 120px;opacity: 0.7;border-radius: 5px;-webkit-print-color-adjust: exact; font-size: 15px">{{post.label}}</span>
                    </div>
                </div>
            </div><!--end .card-body -->
        </div>
    </div>
</section>

