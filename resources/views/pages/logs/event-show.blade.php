<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0 js-modal-title">Log de evento</h3>
        </div>
    </div>
    <div class="card-body p-9">
            <x-data-line label="Descripción" :value="$item->description" first="true" />
            <x-data-line label="Evento" :value="$item->event_name" />
            <x-data-line label="Nombre Modelo" :value="$item->table_name" />
            <x-data-line label="Id Modelo" :value="$item->loggable_id" />            
            <x-data-line label="Datos" :value="$item->data" />
            @if($item->original)
            <x-data-line label="Datos anteriores" :value="$item->original" />
            @endif
            <x-data-line label="Ip" :value="$item->ip" />
            <x-data-line label="Navegador" :value="$item->browser" />
            <x-data-line label="Sistema operativo" :value="$item->so" />
            <x-data-line label="Fecha de creación" :value="$item->created_at" />
            <x-data-line label="Usuario de creación" :value="$item->creator_full_name" />

    </div>
    <div class="card-footer p-9">

    </div>
</div>