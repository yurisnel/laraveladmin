<x-item-details modelName="menu" :urlLog="accessibleRoute('NAME_TABLE.logs', ['id'=>$item->id])">
    <div class="card">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0 js-modal-title">NAME_MODEL</h3>
            </div>
        </div>
        <div class="card-body">
            DATA_FIELDS

            <x-data-line-state :label="__('validation.attributes.state')" :value="$item->state" />
            @if(isset($item->updated_at))
            <x-data-line :label="__('validation.attributes.updated_at')" :value="$item->updated_at" />
            @endif
            <x-data-line :label="__('validation.attributes.created_at')" :value="$item->created_at" />
            <x-data-line :label="__('validation.attributes.creator_full_name')" :value="$item->creator_full_name" />
        </div>
        <div class="card-footer">
            @if(auth()->user()->hasPermission('NAME_TABLE.update'))
            <a href="{{ route('NAME_TABLE.edit', ['NAMEs_TABLE' => $item->id]) }}"
                class="btn btn-primary align-self-center">Editar</a>
            @endif
        </div>
    </div>
</x-item-details>