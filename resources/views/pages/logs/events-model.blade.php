    <x-data-table tableId="tableLogs" title="" :columns="['ID', 'Descripción','Evento', 'Usuario', 'Fecha']" :filters="[]">

    </x-data-table>

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
                    data: 'creator_full_name',
                }, {
                    data: 'created_at',
                }],
                ajaxUrl: '{{ $urlLog }}'
            });
        })
    </script>