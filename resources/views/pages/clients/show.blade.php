<x-item-details modelName="menu" :urlLog="accessibleRoute('clients.logs', ['id'=>$item->id])">
    <div class="card">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0 js-modal-title">Empresa</h3>
            </div>
        </div>
        <div class="card-body">
            <x-data-line label="DNI" :value="$item->dni" first="true" />
            <x-data-line label="Razón Social" :value="$item->business_name" />
            <x-data-line label="Correo" :value="$item->email" />
            <x-data-line label="Teléfono" :value="$item->telephone" />
            <x-data-line label="Dirección" :value="$item->address" />
            <x-data-line label="Giro" :value="$item->giro" />
            <x-data-line label="Nombre de contacto" :value="$item->contact_name" />
            <x-data-line label="Teléfono de contacto" :value="$item->contact_telephone" />
            <x-data-line label="Observaciones" :value="$item->description" />

            <x-data-line-state :label="__('validation.attributes.state')" :value="$item->state" />
            @if(isset($item->updated_at))
            <x-data-line :label="__('validation.attributes.updated_at')" :value="$item->updated_at" />
            @endif
            <x-data-line :label="__('validation.attributes.created_at')" :value="$item->created_at" />
            <x-data-line :label="__('validation.attributes.creator_full_name')" :value="$item->creator_full_name" />

        </div>
        <div class="card-footer">
            @if(auth()->user()->hasPermission('clients.update'))
            <a href="{{ route('clients.edit', ['client' => $item->id]) }}" class="btn btn-primary align-self-center">Editar</a>
            @endif
        </div>
    </div>
</x-item-details>