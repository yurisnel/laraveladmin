<h3 class="title my-5">Datos de la empresa</h3>

<div class="row">

    <div class="col-lg-6 mb-5">
        <x-text-input name="business_name" label="Razón social" placeholder="Ingresar Razón social" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="dni" label="DNI" placeholder="Ingresar DNI" required="true" class="dni" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input type="email" name="email" label="Correo Electrónico" placeholder="Ingresar Correo Electrónico" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="telephone" label="Teléfono" placeholder="Ingresar teléfono" required="true" minlength="9" maxlength="12"/>
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="address" label="Dirección" placeholder="Ingresar Dirección" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="giro" label="Giro" placeholder="Ingresar giro" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="contact_name" label="Nombre de contacto" placeholder="Ingresar nombre de contacto" required="true" />
    </div>
    <div class="col-lg-6 mb-5">
        <x-text-input name="contact_telephone" label="Teléfono de contacto" placeholder="Ingresar teléfono de contacto" required="true" minlength="9" maxlength="12"/>
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input type="textarea" name="description" label="Observaciones" placeholder="Ingresar observaciones" />
    </div>

    @if(isset($item->id))
    <div class="col-lg-6 mb-5">
        <x-select-input name="state" label="Estado" :values="Config::get('constants.state')" placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
    </div>
    @else
    <x-isKeep-input />
    @endif
</div>



<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>

<x-slot name="scripts">
    <script>
        $(document).ready(function() {
            $("#business_nameFormField,#emailFormField, #dniFormField").change(function(e) {
                Api.validateFieldOnServer(e.currentTarget, "{{route('clients.validateForm')}}");
            });
        });
    </script>
</x-slot>