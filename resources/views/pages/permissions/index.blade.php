<x-app-layout pageTitle="Gestionar permisos" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('permissions.create'))
        <a href="{{ route('permissions.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar ruta</a>
        @endif
    </x-slot>

    <x-data-table title="Listado de permisos" :columns="['ID', 'Nombre', 'Descripción', 'Estado', 'Opciones']" :filters="['state']">
    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#table0", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'name'
                        }, {
                            data: 'description',
                        },
                        Api.getColumnState(),
                        Api.getColumnOptions("permissions", {
                            destroy: {
                                active: function(row) {
                                    return row.is_system ? false : true;
                                }
                            }
                        }),
                    ],
                    ajaxUrl: '{{ route("permissions.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>