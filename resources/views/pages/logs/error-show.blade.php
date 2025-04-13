    <div class="card mb-5 mb-xl-10">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0 js-modal-title">Log de error</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <x-data-line label="Mensaje" :value="$item->message" first="true" />
                <x-data-line label="Solicitud" :value="$item->request" />               
                <x-data-line label="Cuerpo" :value="$item->body" />
                <x-data-line label="Código de respuesta" :value="$item->status" />
                <x-data-line label="Ip" :value="$item->ip" />
                <x-data-line label="Navegador" :value="$item->browser" />
                <x-data-line label="Sistema operativo" :value="$item->so" />
                <x-data-line label="Fecha de creación" :value="$item->created_at" />
                <x-data-line label="Usuario de creación" :value="$item->creator_full_name" />
            </div>
        </div>
        <div class="card-footer p-9">

        </div>
    </div>