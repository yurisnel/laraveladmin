<x-app-layout pageTitle="Crear nueva ruta " :breadcrumb="['Home' => route('dashboard'), 'Listado rutas' => route('roles.index')]">
    <x-slot name="actions">
        <a href="{{ route('routes.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>

    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::open(['route' => 'routes.store', 'method'=>'POST', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.routes.form')            
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>