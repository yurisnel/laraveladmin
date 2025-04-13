
    <div class="container" >

        <div class="row">
             <div class="col-sm-6">
             <ul  class="nav nav-pills listBtn">
            <li><a href="#" class="btnAdd" ng-click="add($event)" title="Agregar NAME_MODEL">agregar </a> </li>
            <li><a href="#" class="btnEdit"  ng-click="edit($event)" title="Editar NAME_MODEL">editar </a> </li>
            <li><a href="#" class="btnElim sendForm" ng-click="delete($event)" title="Eliminar NAME_MODEL">eliminar </a></li>
             </ul>
             </div>
             <div class="col-sm-6">
            <form class="form-inline"  ng-submit="filter($event)">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Texto" name="filter"  ng-model="filterText">
                </div>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Buscar</button>
            </form>
             </div>
            </div>

     <table class="table table-striped table-hover" table-adm="store" >
        <thead>
        <tr>
            <th><input type='checkbox' name='checkall' value='' id='checkall' >   </th>
            TABLE_TH
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="item in store.data">
            <td >
                <input type='checkbox' name='check[]' value='{{item.id}}' ng-model="selected[item.id]"/>
            </td>
            TABLE_TD
        </tr>
        </tbody>
    </table>

        <div ng-include="'views/pager.html'"></div>

     </div>