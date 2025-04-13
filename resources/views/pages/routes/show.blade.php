<x-item-details modelName="route" :urlLog="accessibleRoute('routes.logs', ['id'=>$item->id])">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0 js-modal-title">Ruta</h3>
            </div>
        </div>
        <div class="card-body p-9">

            <x-data-line label="Nombre de ruta" :value="$item->route" first="true" />
            <x-data-line label="Descripción" :value="$item->description" />
            <!-- <x-data-line label="Grupo de rutas" :value="$item->parent?$item->parent->description:'Root'" /> -->
            <x-data-line label="Permiso" :value="$item->permission->description" />
            <x-data-line label="Linkable" :value="$item->linkable?'Si':'No'" />

            <x-data-line-state :label="__('validation.attributes.state')" :value="$item->state" />
            @if(isset($item->updated_at))
            <x-data-line :label="__('validation.attributes.updated_at')" :value="$item->updated_at" />
            @endif
            <x-data-line :label="__('validation.attributes.created_at')" :value="$item->created_at" />
            <x-data-line :label="__('validation.attributes.creator_full_name')" :value="$item->creator_full_name" />

        </div>
        <div class="card-footer p-9">
            @if(auth()->user()->hasPermission('routes.update'))
            <a href="{{ route('routes.edit', ['route' => $item->id]) }}" class="btn btn-primary align-self-center">Editar</a>
            @endif
        </div>
    </div>

</x-item-details>