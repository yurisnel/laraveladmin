<h3 class="title my-5">Datos del menú</h3>

<div class="row">

    <div class="col-lg-6 mb-5">
        <x-text-input name="name" label="Nombre" placeholder="Ingresar Nombre" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <label class="mb-3 form-label @error('icon') is-invalid @enderror" for="icon">Icono</label>
        <select class="form-select select2icon select2-hidden-accessible" name="icon">
            <option value="">Seleccione Icono</option>
            @foreach (Config::get('icons') as $iconClass)
            <option value="{{$iconClass}}" @if(isset($item) && $item->icon && $item->icon == $iconClass) selected @endif >{{$iconClass}}</option>
            @endforeach
        </select>

    </div>

    <div class="col-lg-12 mb-5 border p-2">
        <p class="w-auto">Seleccione una ruta o indique el path url que desea asignar al menú</legend>
        <div class="row">
            <div class="col-lg-6 mb-5">
                <x-select-input name="route_id" label="Rutas" :values="$routes" placeholder="Seleccione la ruta" :selected="isset($item)?$item->route_id:0" />
                @error("route_id")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-lg-6 mb-5">
                <x-text-input name="url" label="Path url" placeholder="Indique el path url" />
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-5">
        <x-select-input name="parent_id" label="Menú padre" :values="$parents" placeholder="Seleccione el menú padre" required="true" :selected="isset($item)?$item->parent_id:0" />
    </div>
    @isset($item->id)
    <div class="col-lg-6 mb-5">
        <x-select-input name="state" label="Estado" :values="Config::get('constants.state')" placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
    </div>
    @endisset
</div>

<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>