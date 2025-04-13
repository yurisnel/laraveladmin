<x-app-layout pageTitle="Gestionar menú" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('menus.create'))
        <a href="{{ route('menus.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar menú</a>
        @endif
    </x-slot>

    <x-data-table title="Listado de menú" :columns="['ID', 'Nombre','Href', 'Icono', 'Estado', 'Opciones']" :filters="['state']">
    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#table0", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'full_name'
                        }, {
                            data: 'href'
                        }, {
                            data: 'icon',
                        },
                        Api.getColumnState(),
                        Api.getColumnOptions("menus"),
                    ],
                    ajaxUrl: '{{ route("menus.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>