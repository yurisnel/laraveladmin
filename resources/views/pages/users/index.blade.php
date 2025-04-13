<x-app-layout pageTitle="Gestionar usuarios" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        @if(auth()->user()->hasPermission('users.create'))
        <a href="{{ route('users.create') }}" class="btn btn-sm fw-bold btn-primary hover-scale btn-index">
            <span class="fa fa-plus"></span> Agregar usuario</a>
        @endif
    </x-slot>

    <x-data-table title="Listado usuarios" :columns="['ID', 'DNI', 'Nombre', 'Correo', 'Rol', 'Estado', 'Opciones']" :filters="['state']">
    </x-data-table>

    <x-slot name="scripts">
        <script>
            "use strict";

            $(document).ready(function() {
                Api.createDataTable("#table0", {
                    columns: [{
                            data: 'id'
                        }, {
                            data: 'dni'
                        }, {
                            data: 'full_name',
                            className: 'text-dark text-hover-primary'
                        }, {
                            data: 'email',
                        }, {
                            name: 'role_id',
                            data: 'role_name',
                        },
                        Api.getColumnState(),
                        Api.getColumnOptions("users", {
                            enable: {
                                active: function(row) {
                                    return App.user.id != row.id
                                }
                            },
                            resetPassword: {
                                active: function(row) {
                                    return row.state == 1 && Api.userHasPermission('users.resetPassword', row);
                                },
                                url: function(row) {
                                    return App.rootUrl + "users/" + row.id + '/reset-password';
                                },
                                title: function(row) {
                                    return 'Restablecer contraseña d' + row.to_string;
                                },
                                class: 'btn-info jsConfirm jsLinkAjax',
                                html: '<i class="fa fa-key"></i>'
                            }
                        })
                    ],
                    ajaxUrl: '{{ route("users.dataTable") }}',
                    objectName: 'Usuario'
                });
            })
        </script>
    </x-slot>
</x-app-layout>