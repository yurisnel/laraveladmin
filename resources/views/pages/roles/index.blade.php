<x-app-layout pageTitle="Gestionar roles" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('roles.create'))
        <a href="{{ route('roles.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar role</a>
        @endif
    </x-slot>

    <x-data-table title="Listado de roles" :columns="['ID', 'Nombre', 'Descripción', 'Estado', 'Opciones']" :filters="['state']">
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
                        {
                            data: 'options',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                if (row.id != 1) { // si no es superAdmin
                                    let html = Api.getOptionsHtml(row, "roles");
                                    return html;
                                }
                                return "";
                            }
                        }
                    ],
                    ajaxUrl: '{{ route("roles.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>