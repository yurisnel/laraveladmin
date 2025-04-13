<h3 class="title my-5">Datos del permiso</h3>

<div class="row">

    <div class="col-lg-12 mb-5">
        @if(isset($item) && $item->is_system)
        <label class="mb-3 form-label">Nombre</label>
        <h6>{{$item->name}}</h6>
        @else
        <x-text-input name="name" label="Nombre del permiso" placeholder="Ingresar nombre del permiso" required="true" />
        @endif
    </div>
    <div class="col-lg-12 mb-5">
        <x-text-input name="description" label="Descripción" placeholder="Ingresar descripción" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-select-input name="parent_id" label="Grupo de permisos" :values="$parents" placeholder="Seleccione el grupo de permiso" required="true" :selected="isset($item)?$item->parent_id:0" />
    </div>

    @isset($item->id)
    <div class="col-lg-6 mb-5">
        <x-select-input name="state" label="Estado" :values="Config::get('constants.state')" placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
    </div>
    @endisset
</div>

<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>