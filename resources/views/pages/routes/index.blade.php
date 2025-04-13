<x-app-layout pageTitle="Gestionar rutas" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('routes.create'))
        <a href="{{ route('routes.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar ruta</a>
        @endif
    </x-slot>

    <x-data-table title="Listado de rutas" :columns="['ID', 'Ruta', 'Descripción', 'Linkable', 'Estado', 'Opciones']" :filters="['state']">
    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#table0", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'route'
                        }, {
                            data: 'description',
                        }, {
                            data: 'linkable',
                            defaultContent: '',
                            render: function(data, type, row, meta) {
                                if (type === 'display') {
                                    return data ? 'Si' : 'No'
                                }
                            }
                        },
                        Api.getColumnState(),
                        Api.getColumnOptions("routes"),
                    ],
                    ajaxUrl: '{{ route("routes.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>