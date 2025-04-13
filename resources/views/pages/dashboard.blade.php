<x-app-layout pageTitle="Dashboard" :breadcrumb="['Home' => route('dashboard')]">

    <x-slot name="actions">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Acción 1</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Acción 2</a>
    </x-slot>

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-xxl-12">
            <div class="card card-flush h-md-100">
                <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" style="background-position: 100% 50%; background-image:url('{{ url('/') }}/metronic/media/stock/900x600/42.png')">
                    <div class="mb-10">
                        <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                            @php
                            $months = __('locale.months.longhand');
                            if(!empty($months[date("n")-1])){
                            $monthCurrent = $months[date("n")-1];
                            }else{
                            $monthCurrent = 'Desconocido';
                            }
                            @endphp

                            <span class="me-2">Mes actual: {{ $monthCurrent }}
                                <br>
                                <span class="position-relative d-inline-block text-danger">
                                    <a href="/clientes" class="text-danger opacity-75-hover">Empresas</a>
                                    <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                </span></span>por verificar
                        </div>
                        <div class="text-center">
                            <a href="/centroscultivo" class="btn btn-sm btn-dark fw-bold">Centros de cultivo</a>
                        </div>
                    </div>
                    <img class="mx-auto h-150px h-lg-200px theme-light-show" src="{{ url('/') }}/metronic/media/illustrations/misc/upgrade.svg" alt="">
                    <img class="mx-auto h-150px h-lg-200px theme-dark-show" src="{{ url('/') }}/metronic/media/illustrations/misc/upgrade-dark.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>