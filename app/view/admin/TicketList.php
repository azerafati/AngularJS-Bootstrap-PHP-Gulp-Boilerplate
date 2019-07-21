<section ng-app="list" ng-controller="listCtrl">
	<div class="section-header">
		<ol class="breadcrumb">
			<li class="active">ارسال ها</li>
		</ol>
	</div>
	<div class="section-body contain-lg">
		<div class="card tabs-left ">

			<!-- BEGIN SEARCH BAR -->
			<div class="card-body style-primary no-y-padding">
				<form class="form form-inverse" ng-submit="filterSubmit()">
					<div class="form-group">
						<div class="input-group input-group-lg">
							<div class="input-group-content">
								<input type="text" class="form-control" id="searchInput" placeholder="جستجو" ng-model="mainSearch">
								<div class="form-control-line"></div>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-floating-action btn-default-bright" type="submit">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</div>
					<!--end .form-group -->
				</form>
			</div>
			<!--end .card-body -->
			<!-- END SEARCH BAR -->

			<!-- BEGIN TAB CONTENT -->
			<div class="card-body style-default-bright">
				<div class="row">
					<div class="col-xs-12">

						<!-- BEGIN PAGE HEADER -->
						<div class="margin-bottom-xxl">
							<span class="text-light text-right">
								مورد یافت شد
								<span class="badge">{{page.total}}</span>
							</span>
							<div class="btn-group btn-group-sm pull-right">
								<button type="button" class="btn btn-default-light dropdown-toggle" data-toggle="dropdown">
									<span class="fa fa-arrow-down"></span>
									مرتب کردن
								</button>
								<ul class="dropdown-menu dropdown-menu-right animation-dock" role="menu">
									<li ng-class="{active:sort_id==null}" ng-click="sort(1)"><a href="#">وضعیت</a></li>
									<li ng-class="{active:sort_id==2}"><a href="#" ng-click="sort(2)">تاریخ</a></li>
									<li ng-class="{active:sort_id==3}"><a href="#" ng-click="sort(3)">مبلغ</a></li>
									<li ng-class="{active:sort_id==4}"><a href="#" ng-click="sort(4)">اسم محصول</a></li>
								</ul>
							</div>
						</div>
						<!--end .margin-bottom-xxl -->
						<!-- END PAGE HEADER -->

						<!-- BEGIN RESULT LIST -->
						<div class="">
							<div class='row text-center hardfade' ng-class="{in:!load}">
								<div class='spinner '>
									<div class='ring1'>
										<div class='ring2'>
											<div class='ring3'></div>
										</div>
									</div>
								</div>
							</div>
							<div class="alert alert-warning fade rtl" ng-class="{in:tickets.length==0 }">هیچ سفارشی پیدا نشد!</div>
							<div class="az-table rtl fade" ng-class="{in:load && tickets.length }">
								<table class="table table-bordered text-right table-hover table-pointer table-condensed">
									<thead>
										<tr class="active">
											<th>شماره</th>
											<th>مشتری</th>
											<th>عنوان</th>
											<th>دسته</th>
											<th>تاریخ</th>
											<th>وضعیت</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="ticket in tickets" ng-click="showTicket(ticket)">
											<td class="hidden-xs">{{ticket.id}}</td>
											<td class="مشتری:">{{ticket.user_name}}</td>
											<td data-title="عنوان:">{{ticket.title}}</td>
											<td data-title="دسته:">{{ticket_types[ticket.type].name}}</td>
											<td data-title="تاریخ:">{{ticket.created | jdate}}</td>
											<td data-title="وضعیت:">
												<span class="label label-fa label-default" ng-hide="ticket.answered">پاسخ داده نشده</span>
												<span class="label label-fa label-success" ng-show="ticket.answered">پاسخ داده شده</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<paging page="page.number" page-size="page.size" total="page.total" adjacent="false" show-prev-next="true"
					paging-action="DoCtrlPagingAct('Paging Clicked', page, pageSize, total)"> </paging>

			</div>
			<!--end .card-body -->
			<!-- END TAB CONTENT -->

		</div>
		<!--end .card -->
	</div>


	<div class="modal fade " id="ticketReply" tabindex="-1" role="dialog" aria-labelledby="invoice">
		<div class="modal-dialog " role="document">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">{{ticket.title}}</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
						<ul class="list-chats" style="height: 100%; overflow-y: scroll;">
							<li ng-class="{'chat-left':reply.own}" ng-repeat="reply in ticket.replies">
								<div class="chat">
									<div class="chat-avatar"></div>
									<div class="chat-body">
										<p ng-bind-html="reply.msg | url"></p>
										<small class="rtl">{{reply.created | jdate}}</small>
									</div>
								</div> <!--end .chat -->
							</li>
						</ul>


					</div>
					<div class='row text-center hardfade' style="position: relative;" ng-class="{in:!loadingReplies}">
						<div class='spinner '>
							<div class='ring1'>
								<div class='ring2'>
									<div class='ring3'></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer ">
					<form class="form" ng-submit="sendReply($event)">
						<div class="row rtl">
							<table class="col-xs-12">
								<tbody>
									<tr class="half-gutter">
										<td class="col-xs-1">
											<button class="btn btn-default btn-block" type="submit">
												<i class="fa fa-chevron-circle-right fa-lg"></i>
											</button>
										</td>
										<td class="col-xs-11">
											<textarea class="form-control" tabindex="1" ng-model="newReply.msg" place-holder="موضوع درخواست" rows="2"
												style="overflow: hidden; word-wrap: break-word; resize: horizontal;"></textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</section>