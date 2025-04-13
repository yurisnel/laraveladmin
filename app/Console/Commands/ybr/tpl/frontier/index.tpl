<x-app-layout pageTitle="Gestionar NAME_TABLE" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('NAME_TABLE.create'))
        <a href="{{ route('NAME_TABLE.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar NAME_MODEL</a>
        @endif
    </x-slot>

    <x-data-table title="Listado de NAME_TABLE" :columns="[TABLE_TH, 'Estado', 'Opciones']" :filters="['state']">
    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#table0", {
                    columns: [
                        TABLE_TD,
                        Api.getColumnState(),
                        Api.getColumnOptions("NAME_TABLE"),
                    ],
                    ajaxUrl: '{{ route("NAME_TABLE.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>