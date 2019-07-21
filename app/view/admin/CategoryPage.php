<section ng-app="app" ng-controller="mainCtrl">
    <div class="section-header">
        <ol class="breadcrumb">
            <li class="active">دسته بندی ها</li>
        </ol>
    </div>
    <div class="section-body contain-lg">
        <div class="card tabs-below style-primary card-outlined card-underline"
             ng-class="{'style-danger':user.balance<0}">
            <!-- BEGIN SEARCH BAR -->
            <div class="card-head small-padding">
               <button class="btn btn-success" type="button" ng-click="save()">ذخیره</button>

            </div>
            <div class="card-body tab-content style-default-bright">
                <div class="col-sm-7">
                    <div ui-tree id="tree-root">
                        <ol ui-tree-nodes ng-model="categories">
                            <li ng-repeat="node in categories" ui-tree-node ng-include="'nodes_renderer.html'"></li>
                        </ol>
                    </div>
                    <div>
                        <button class="btn btn-default" type="button" ng-click="addMainCat()">دسته جدید</button>
                    </div>
                </div>
                <div class="col-sm-5" ></div>


            </div>
            <!--end .card-body -->
        </div>
        <!--end .card -->
    </div>
    <!--end .section-body -->
    <script type="text/ng-template" id="nodes_renderer.html">
        <div ui-tree-handle class="tree-node tree-node-content" title="{{node.id}}">
            <a class="btn btn-success btn-xs" ng-if="node.nodes && node.nodes.length > 0" data-nodrag
               ng-click="toggle(this)"><span class="fa" ng-class="{
'fa-chevron-right': collapsed,
	'fa-chevron-down': !collapsed
}"></span>
            </a>
            <input type="text" data-nodrag ng-model="node.title" class="rtl no-border"/>
            <a class="pull-right btn btn-danger btn-xs" data-nodrag ng-click="removeCat(this)"><span
                    class="fa fa-times"></span>
            </a>
            <a class="pull-right btn btn-primary btn-xs" data-nodrag ng-click="newSubItem(this)"
               style="margin-right: 8px;"><span class="fa fa-plus"></span>
            </a>
            <a class="pull-right btn btn-primary btn-xs" data-nodrag ng-click="edit(this)"
               style="margin-right: 8px;"><span class="fa fa-bars"></span>
            </a>
            <a class="pull-right btn btn-primary btn-xs" data-nodrag href="page-edit?url={{node.url}}" target="_blank"
               style="margin-right: 8px;" ng-if="node.url"><span class="fa fa-pencil"></span>
            </a>
            <a class="pull-right btn btn-primary btn-xs" data-nodrag href="/{{node.url}}" target="_blank"
               style="margin-right: 8px;" ng-if="node.url"><span class="fa fa-eye"></span>
            </a>
        </div>
        <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}">
            <li ng-repeat="node in node.nodes" ui-tree-node ng-include="'nodes_renderer.html'"></li>
        </ol>
    </script>


    <div class="modal fade " id="catDetail" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">دسته بندی</h4>
                </div>
                <div class="modal-body col-xs-12 rtl">
                    <div class="">

                        <div class="form-group">
                            <label>نام دسته</label>
                            <input class="form-control input-sm" ng-model="cat.title"/>
                        </div>
                        <div class="form-group">
                            <label>لینک</label>
                            <input class="form-control input-sm" ng-model="cat.url"/>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-styled">
                                <label>
                                    <input type="checkbox" ng-model="cat.hidden">
                                    <span>مخفی</span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>


    <div class="loadingPage hardfade" ng-class="{in:!load}" >
        <div class='row text-center'>
            <div class='spinner '>
                <div class='ring1'>
                    <div class='ring2'>
                        <div class='ring3'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




