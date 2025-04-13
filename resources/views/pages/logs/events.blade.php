<x-app-layout pageTitle="Logs de eventos" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
    </x-slot>

    <x-data-table tableId="tableLogs" title="Listado logs " :columns="['ID', 'Descripción','Evento', 'Tabla',  'Usuario', 'Fecha']" :filters="$filters">

    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#tableLogs", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'description'
                        }, {
                            data: 'event_name'
                        }, {
                            data: 'table_name'
                        }, {
                            data: 'creator_full_name',
                        }, {
                            data: 'created_at',
                        },
                        Api.getColumnOptions("logs.events", {
                            edit: false,
                            enable: false,
                            width: '120px'
                        })
                    ],
                    ajaxUrl: '{{ route("logs.events.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>