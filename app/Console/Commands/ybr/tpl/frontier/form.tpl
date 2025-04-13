<h3 class="title my-5">Datos del NAME_MODEL</h3>

<div class="row">

    FORM_FIELDS

    @if(isset($item->id))
    <div class="col-lg-6 mb-5">
        <x-select-input name="state" label="Estado" :values="Config::get('constants.state')"
            placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
    </div>
    @else
    <x-isKeep-input />
    @endif
</div>

<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>