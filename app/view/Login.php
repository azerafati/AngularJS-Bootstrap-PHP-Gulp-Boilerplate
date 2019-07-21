<div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3" id="loginTabs" >
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active">
            <a href="#signin" data-toggle="tab" class="fa-lg">
                ورود <i class="fa fa-user"></i>
            </a>
        </li>
        <li role="presentation">
            <a href="#signup" data-toggle="tab" class="fa-lg">
                ثبت نام <i class="fa fa-user-plus "></i>
            </a>
        </li>
    </ul>
    <div class="tab-content ">
        <div role="tabpanel" class="tab-pane active fade in" id="signin">
            <div class="card ">
                <div class="card-body ">
                    <form ng-submit="submit($event)" name="loginForm" method="post" action="api/user/login">
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-phone fa-fw"></i>
										</span>
                                <input name="tel" type="tel" ng-model="user.tel" ng-pattern="/^09[0-9]{9}$/" class="form-control rtl" placeholder="شماره موبایل خود را وارد کنید" ng-class="{rtl: !loginForm.tel.$viewValue.length}" required oninvalid="this.setCustomValidity('شماره موبایل باید  وارد شود')" oninput="this.setCustomValidity('')"/>
                            </div>
                            <p ng-class="{in:loginForm.tel.$invalid && !loginForm.tel.$pristine}" class="help-block help-block-fade">
                                شماره موبایل وارد شده صحیح نیست</p>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key fa-fw"></i>
										</span>
                                <input name="pass" type="password" ng-model="user.pass" class="form-control" placeholder=" کلمه عبور " ng-class="{rtl: !loginForm.pass.$viewValue.length}" required ng-minlength="5" oninvalid="this.setCustomValidity('لطفا کلمه عبور را وارد کنید')" oninput="this.setCustomValidity('')"/>
                            </div>
                            <p ng-class="{in:loginForm.pass.$invalid && !loginForm.pass.$pristine}" class="help-block help-block-fade">
                                کلمه عبور نمی تواند کمتر از پنج کاراکتر باشد</p>
                        </div>
                        <button class="btn btn-primary btn-block " type="submit" id="addProd" ng-class="{loading:loading}">
                            ورود <i class="fa fa-check fa-lg"></i>
                        </button>
                        <div class="form-group up-2">
                            <a href="#forgotpass" data-toggle="tab" ng-click="turnofftab()">
                                <small>کلمه عبور را فراموش کرده ام</small>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="signup">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <form ng-submit="signup()" name="signupForm">
                        <input type="text" name="tel" style="display: none;"/>
                        <input type="password" name="pass" style="display: none;"/>
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-phone fa-fw"></i>
										</span>
                                <input name="tel" type="tel" ng-model="newuser.tel" class="form-control rtl" placeholder="شماره موبایل تان را وارد کنید" ng-pattern="/^09[0-9]{9}$/" ng-class="{rtl: !signupForm.tel.$viewValue.length}" oninvalid="this.setCustomValidity('شماره موبایل باید  وارد شود')" oninput="this.setCustomValidity('')" autocomplete="new-password" value=""/>
                            </div>
                            <p ng-class="{in:signupForm.tel.$invalid && !signupForm.tel.$pristine}" class="help-block help-block-fade">
                                شماره موبایل وارد شده صحیح نیست</p>
                        </div>
                        <div class="form-group ">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key fa-fw"></i>
										</span>
                                <input name="pass" type="password" ng-model="newuser.pass" class="form-control rtl" placeholder="یک کلمه عبور دلخواه" ng-class="{rtl: !signupForm.pass.$viewValue.length}" required ng-minlength="5" oninvalid="this.setCustomValidity('لطفا کلمه عبور را وارد کنید')" oninput="this.setCustomValidity('')" autocomplete="new-password" value=""/>
                            </div>
                            <p ng-class="{in:signupForm.pass.$invalid && !signupForm.pass.$pristine}" class="help-block help-block-fade">
                                کلمه عبور نمی تواند کمتر از پنج کاراکتر باشد</p>
                        </div>
                        <div class="form-group ">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key fa-fw"></i>
										</span>
                                <input name="passver" type="password" ng-model="newuser.passver" class="form-control rtl" placeholder="تکرار کلمه عبور " ng-class="{rtl: !signupForm.passver.$viewValue.length}" required ng-pattern="{{newuser.pass}}" oninvalid="this.setCustomValidity('لطفا دوباره  کلمه عبور را وارد کنید')" oninput="this.setCustomValidity('')" autocomplete="off"/>
                            </div>
                            <p ng-class="{in:signupForm.passver.$invalid && !signupForm.passver.$pristine}" class="help-block help-block-fade">
                                تکرار کلمه عبور برابر نیست</p>
                        </div>
                        <button class="btn btn-primary btn-block " id="addProd" ng-class="{loading:loading}" ng-disabled="!signupForm.$valid">
                            تایید و ثبت نام <i class="fa fa-check fa-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="forgotpass">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form ng-submit="forgot()" name="forgotForm">
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-phone fa-fw"></i>
										</span>
                                <input name="tel" type="tel" ng-model="user.tel" ng-pattern="/^09[0-9]{9}$/" class="form-control" placeholder="شماره موبایل خود را وارد کنید" ng-class="{rtl: !forgotForm.tel.$viewValue.length}" required="required"/>
                            </div>
                            <p ng-class="{in:forgotForm.tel.$invalid && !forgotForm.tel.$pristine}" class="help-block help-block-fade">
                                شماره موبایل وارد شده صحیح نیست</p>
                        </div>
                        <button class="btn btn-primary btn-block" ng-class="{loading:loading}" ng-disabled="!forgotForm.$valid">
                            ارسال کد بازیابی رمز <i class="fa fa-check fa-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="changepass">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form ng-submit="changepass()" name="changepassForm">
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-envelope fa-fw"></i>
										</span>
                                <input name="pin" type="tel" ng-model="pin" ng-pattern="/^[0-9]{5}$/" class="form-control" placeholder="کد را وارد کنید" ng-class="{rtl: !changepassForm.pin.$viewValue.length}" required="required"/>
                            </div>
                            <p ng-class="{in:changepassForm.pin.$invalid && !changepassForm.pin.$pristine}" class="help-block help-block-fade">
                                کد وارد شده صحیح نیست</p>
                        </div>
                        <div class="form-group ">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key fa-fw"></i>
										</span>
                                <input name="pass1" type="password" ng-model="pass1" class="form-control rtl" placeholder="کلمه عبور جدید" ng-class="{rtl: !changepassForm.pass1.$viewValue.length}" required ng-minlength="5" oninvalid="this.setCustomValidity('لطفا کلمه عبور را وارد کنید')" oninput="this.setCustomValidity('')" value=""/>
                            </div>
                            <p ng-class="{in:changepassForm.pass1.$invalid && !changepassForm.pass1.$pristine}" class="help-block help-block-fade">
                                کلمه عبور نمی تواند کمتر از پنج کاراکتر باشد</p>
                        </div>
                        <div class="form-group ">
                            <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key fa-fw"></i>
										</span>
                                <input name="pass2" type="password" ng-model="pass2" class="form-control rtl" placeholder="تکرار کلمه عبور " ng-class="{rtl: !changepassForm.pass2.$viewValue.length}" required ng-pattern="{{user.pass1}}" oninvalid="this.setCustomValidity('لطفا دوباره  کلمه عبور را وارد کنید')" oninput="this.setCustomValidity('')"/>
                            </div>
                            <p ng-class="{in:changepassForm.passver.$invalid && !changepassForm.passver.$pristine}" class="help-block help-block-fade">
                                تکرار کلمه عبور برابر نیست</p>
                        </div>
                        <button class="btn btn-primary btn-block" ng-class="{loading:loading}" ng-disabled="!changepassForm.$valid">
                            تایید و تغییر رمز <i class="fa fa-check fa-lg"></i>
                        </button>
                    </form>
                    <div class="alert alert-info up rtl">
                        <i class="fa fa-info-circle fa-2x"></i>
                        <small> در صورتی که پیامکی دریافت نکردید برای فعال کردن دریافت پیامک به صورت زیر عمل کنید <br/>
                                همراه اول: عدد 2 را به 8999 ارسال کنید ایرانسل: عدد 1 را به 5005 ارسال کنید
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row text-center hardfade' ng-class="{in:loading}">
        <div class='spinner'>
            <div class='ring1'>
                <div class='ring2'>
                    <div class='ring3'></div>
                </div>
            </div>
        </div>
    </div>
</div>




