<div class="card" ng-controller="appointmentQueCtrl">
    <div class="card-header d-sm-block d-none">
        <header>جدول نوبت دهی</header>
    </div>
    <div class="card-body table-responsive p-0">
        <spinner></spinner>
        <table class="table table-bordered rtl text-center m-0 fade" ng-class="{show:!loadingQue && loaded}" ng-cloak>
            <thead class="text-center">
            <tr class="">
                <th class="table-active text-center">نوبت</th>
                <th class="text-center" ng-repeat="dayIndex in nextTwoWeeks" ng-class="{'table-warning text-sm':isFriday(dayIndex),'table-active':!isFriday(dayIndex)}">
                    {{dayIndex|jdate:'dddd'}} <br>
                    <span class="text-nowrap">{{dayIndex|jdate:'jD jMMMM'}}</span>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="hourIndex in range(1,8)" ng-init="queDay = $index">
                <th class="align-middle text-center">
                    {{$index+1}}
                </th>
                <td ng-repeat="dayIndex in nextTwoWeeks" ng-class="{'table-warning':isFriday(dayIndex)}"  class="text-sm">
                    <div class="text-nowrap text-center" ng-if="ques[$index][queDay]">
                        <h5 class="m-0 "><span class="badge badge-secondary" ng-style="{'background-color': statuses[ques[$index][queDay].status].color}">{{statuses[ques[$index][queDay].status].title}}</span></h5>
                        <span>{{ques[$index][queDay].user_name}}</span><br>
                        <span> دکتر {{ques[$index][queDay].director_name}}</span><br>
                        <b>ساعت: {{ques[$index][queDay].start_at|jdate:'HH:mm'}} </b>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>