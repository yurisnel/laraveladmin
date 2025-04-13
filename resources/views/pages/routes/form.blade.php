<h3 class="title my-5">Datos del la ruta</h3>

<div class="row">

    <div class="col-lg-12 mb-5">
        <x-text-input name="route" label="Nombre de ruta" placeholder="Ingresar nombre de ruta" required="true" />
    </div>
    <div class="col-lg-12 mb-5">
        <x-text-input name="description" label="Descripción" placeholder="Ingresar descripción" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-select-input name="permission_id" label="Permiso" :values="$permissions" placeholder="Seleccione el permiso" required="true" :selected="isset($item)?$item->permission_id:0" />
        @error("permission_id")
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-lg-6 mb-5 d-flex align-items-end">
        <label class="form-label">
            {!!Form::checkbox('linkable', 1, isset($item)?$item->linkable:0)!!}
            Navegable desde el menú
        </label>

    </div>
    @isset($item->id)
    <div class="col-lg-6 mb-5">
        <x-select-input name="state" label="Estado" :values="Config::get('constants.state')" placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
    </div>
    @endisset
</div>

<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>