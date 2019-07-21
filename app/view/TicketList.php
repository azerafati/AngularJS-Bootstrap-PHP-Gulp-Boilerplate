<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1" ng-app="list" ng-controller="listCtrl">
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
					تیکت های شما
					<i class="fa fa-th-list"></i>
				</h3>
			</div>
			<div class="panel-body ">
				<div class="rtl">
					<button class="btn btn-primary" data-target="#newTicket" data-toggle="modal">
						<i class="fa fa-ticket"></i>
						تیکت جدید
					</button>
				</div>
				<div class="alert alert-info hardfade rtl up-2" ng-class="{in:tickets.length==0 }">
					<i class="fa fa-lg fa-commenting"></i>
					با ایجاد تیکت جدید در سریع ترین زمان ممکن به درخواست شما رسیدگی می شود!
				</div>
				<div class='row text-center hardfade' style="position: relative;" ng-class="{in:!loaded || addingItem}">
					<div class='spinner '>
						<div class='ring1'>
							<div class='ring2'>
								<div class='ring3'></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="az-table rtl fade" ng-class="{in:loaded && tickets.length }">
				<table class="table table-bordered text-right table-hover table-pointer table-condensed">
					<thead>
						<tr class="active">
							<th>شماره</th>
							<th>عنوان</th>
							<th>دسته</th>
							<th>تاریخ</th>
							<th>وضعیت</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="ticket in tickets" ng-click="showTicket(ticket)">
							<td class="hidden-xs">{{ticket.id}}</td>
							<td data-title="عنوان:">{{ticket.title}}</td>
							<td data-title="دسته:">{{ticket_types[ticket.type].name}}</td>
							<td data-title="تاریخ:">{{ticket.created | jdate}}</td>
							<td data-title="وضعیت:">
								<span class="label label-fa label-default" ng-hide="ticket.answered">پاسخ داده نشده</span>
								<span class="label label-fa label-success" ng-show="ticket.answered">پاسخ داده شده</span>
							</td>
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

	<div class="modal fade " id="newTicket" tabindex="-1" role="dialog" aria-labelledby="invoice">
		<div class="modal-dialog " role="document">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">تیکت جدید</h4>
				</div>
				<div class="modal-body" style="background-color: #fff">
					<div>
						<form class="form rtl">
							<div class="form-group">
								<label>دسته</label>
								<select class="form-control" ng-model="newTicket.type" place-holder="موضوع درخواست" ng-options="type.id as type.name for type in ticket_types">
								</select>
							</div>
							<div class="form-group">
								<label>عنوان</label>
								<input class="form-control" ng-model="newTicket.title" place-holder="موضوع درخواست" />
							</div>
							<div class="form-group">
								<label>متن درخواست</label>
								<textarea class="form-control" ng-model="newTicket.msg" place-holder="موضوع درخواست" rows="6"></textarea>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal" ng-click="saveNewTicket()">
						تایید
						<i class="fa fa-check"></i>
					</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
				</div>
			</div>
		</div>
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
							<li ng-class="{'chat-left':!reply.own}" ng-repeat="reply in ticket.replies">
								<div class="chat">
									<div class="chat-avatar"></div>
									<div class="chat-body">
										<p ng-bind-html="reply.msg | url"></p>
										<small class="rtl">{{reply.created | jdate}}</small>
									</div>
								</div>
								<!--end .chat -->
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
					<div class="row rtl">
						<table class="col-xs-12">
							<tbody>
								<tr class="half-gutter">
									<td class="col-xs-1">
										<button class="btn btn-default btn-block">
											<i class="fa fa-chevron-circle-right fa-lg"></i>
										</button>
									</td>
									<td class="col-xs-11">
										<textarea class="form-control" tabindex="1" ng-keyup="sendReply($event)" ng-model="newReply.msg" place-holder="موضوع درخواست" rows="2"
											style="overflow: hidden; word-wrap: break-word; resize: horizontal;"></textarea>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>


</div>


