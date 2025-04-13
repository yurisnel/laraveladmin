<x-item-details modelName="user" :urlLog="accessibleRoute('users.logs', ['id'=>$item->id])">
    <div class="card">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0 js-modal-title">Usuario</h3>
            </div>
        </div>
        <div class="card-body">

            <x-data-line label="Nombre" :value="$item->full_name" first="true" />
            <x-data-line label="DNI" :value="$item->dni" />
            <x-data-line label="Correo" :value="$item->email" />
            <x-data-line label="Rol" :value="$item->role->name" />

            <x-data-line-state :label="__('validation.attributes.state')" :value="$item->state" />
            @if(isset($item->updated_at))
            <x-data-line :label="__('validation.attributes.updated_at')" :value="$item->updated_at" />
            @endif
            <x-data-line :label="__('validation.attributes.created_at')" :value="$item->created_at" />
            <x-data-line :label="__('validation.attributes.creator_full_name')" :value="$item->creator_full_name" />


            <!--begin::Notice
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                        
                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                    </svg>
                </span>               
                <div class="d-flex flex-stack flex-grow-1">
               
                    <div class="fw-semibold">
                        <h4 class="text-gray-900 fw-bold">We need your attention!</h4>
                        <div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please
                            <a class="fw-bold" href="../../demo1/dist/account/billing.html">Add Payment Method</a>.
                        </div>
                    </div>
               
                </div>
            </div>
           Notice-->
        </div>
        <div class="card-footer">
            @if(auth()->user()->hasPermission('users.update'))
            <a href="{{ route('users.edit', ['user' => $item->id]) }}" class="btn btn-primary align-self-center">Editar</a>
            @endif
        </div>
    </div>

</x-item-details>