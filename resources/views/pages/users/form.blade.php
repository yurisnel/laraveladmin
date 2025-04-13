<h3 class="title my-5">Datos personales</h3>

<div class="row">

    <div class="col-lg-6 mb-5">
        <x-text-input name="dni" label="DNI" placeholder="Ingresar DNI" required="true" class="dni" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="name" label="Nombres" placeholder="Ingresar Nombres" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="fathername" label="Apellido Paterno" placeholder="Ingresar Apellido Paterno" required="true" />
    </div>

    <div class="col-lg-6 mb-5">
        <x-text-input name="mothername" label="Apellido Materno" placeholder="Ingresar Apellido Materno" required="true" />
    </div>

    <div class="col-lg-12 mb-5">
        <x-text-input type="email" name="email" label="Correo Electrónico" placeholder="Ingresar Correo Electrónico" required="true" />
    </div>


    <!--

    <div class="col-lg-6 mb-5">
        <x-text-input name="birthday" label="Fecha de Nacimiento" placeholder="Fecha de Nacimiento" required="true" class="datepicker" />
    </div>

-->
    @if(!isset($item) || auth()->user()->id != $item->id)
    <div class="col-lg-6 mb-5">
        <x-select-input name="role_id" label="Rol" :values="$roles" placeholder="Seleccione rol" required="true" :selected="isset($item)?$item->role_id:0" />
        @error("role_id")
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endif

    @if(isset($item) && auth()->user()->id != $item->id)
    <div class="col-lg-6 mb-5">
        <x-select-input name="state" label="Estado" :values="Config::get('constants.state')" placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
    </div>
    @endif
</div>
<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>


<x-slot name="scripts">
    <script>
        $(document).ready(function() {
            /*var metodo = $('input[name="_method"]').val();
            if (metodo === "PATCH") {
                if($("#rutFormField").val() != '')
                    $("#rutFormField").attr("readonly", true);
            }*/

            $("#dniFormField, #emailFormField").change(function(e) {
                Api.validateFieldOnServer(e.currentTarget, "{{route('users.validateForm')}}");
            });
        });
    </script>
</x-slot>
