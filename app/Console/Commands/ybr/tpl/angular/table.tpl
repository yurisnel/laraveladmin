
<div class="container" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <a role="button " class="btn btn-primary" ng-click="add()" title="Adicionar NAME_MODEL"  data-toggle="tooltip" data-placement="top"><span class="fa fa-plus"></span> </a>
            <span class="title_page col-md-offset-1">NAME_LB </span>


            <ng-include src="'views/filter.html'" class="pull-right"></ng-include>
            <div class="clearfix" ></div>

        </div>


     <table class="table table-striped table-hover" table-adm="store" >
        <thead>
        <tr>
            <th>#</th>
            TABLE_TH
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="item in store.data track by $index">
            <td >{{$index+1}}</td>
            TABLE_TD
            <td>
                <div class="tools">
                <i class="fa fa-edit"  ng-click="edit(item.id)"></i>
                <i class="fa fa-trash-o"  ng-click="delete(item.id)"></i>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

     <div class="panel-footer" ng-include="'views/pager.html'"></div>

  </div>
 </div>