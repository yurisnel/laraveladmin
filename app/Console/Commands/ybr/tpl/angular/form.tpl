<form action="{{param.action}}" method="{{param.method}}"  class="form-horizontal formAjax" data-load="{{param.load}}" >
   
	FORM_FIELDS
	
    <div class="message-error col-md-offset-3">Los campos con (*) son obligatorios</div>
    <hr>
    <div style="text-align: center;">

        <button class="btn btn-primary" type="submit"> <i class="fa fa-save"></i> Guardar</button>
        <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-close"></i> Cancelar</button>


    </div>
</form>