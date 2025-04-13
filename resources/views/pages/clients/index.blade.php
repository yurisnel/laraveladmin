<x-app-layout pageTitle="Gestionar empresas" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('clients.create'))
        <a href="{{ route('clients.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar empresa</a>
        @endif
    </x-slot>

    <x-data-table title="Listado de empresas" :columns="['ID', 'DNI', 'Razón Social', 'Correo', 'Teléfono', 'Estado', 'Opciones']" :filters="['state']">
    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#table0", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'dni',
                        }, {
                            data: 'business_name',
                            className: 'text-dark text-hover-primary'
                        }, {
                            data: 'email'
                        }, {
                            data: 'telephone'
                        },
                        Api.getColumnState(),
                        Api.getColumnOptions("clients", {
                            myUsers: {
                                url: function(row) {
                                    return App.rootUrl + 'client_users/' + row.id + '/index'
                                },
                                class: 'btn-info',
                                title: 'Listar usuarios',
                                html: '<i class="fa fa-users"></i>',
                                active: function(row) {
                                    return Api.userHasPermission('client_users.index', row);
                                },
                            }
                        })
                    ],
                    ajaxUrl: '{{ route("clients.dataTable") }}'
                });
            })
        </script>
    </x-slot>
</x-app-layout>