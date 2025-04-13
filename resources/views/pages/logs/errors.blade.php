<x-app-layout pageTitle="Logs de errores" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
    </x-slot>

    <x-data-table tableId="tableLogsErrors" title="Listado de logs" :columns="['ID', 'Mensaje','Petición', 'Estado',  'Usuario', 'Fecha', 'Opciones']" :filters="[]">

    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#tableLogsErrors", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'message',
                            width: '300px'
                        }, {
                            data: 'request',
                            width: '250px'
                        }, {
                            data: 'status'
                        }, {
                            data: 'creator_full_name',
                            width: '150px'
                        }, {
                            data: 'created_at',
                            width: '200px'
                        },
                        Api.getColumnOptions("logs.errors", {
                            edit: false,
                            enable: false,
                            width: '120px'
                        })
                    ],
                    ajaxUrl: '{{ route("logs.errors.dataTable") }}',
                    columnDefs: [{
                        'max-width': '20%',
                        'targets': 1
                    }]
                });
            })
        </script>
    </x-slot>
</x-app-layout>