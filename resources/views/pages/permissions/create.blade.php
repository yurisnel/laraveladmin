<x-app-layout pageTitle="Crear nuevo permiso " :breadcrumb="['Home' => route('dashboard'), 'Listado de permisos' => route('permissions.index')]">
    <x-slot name="actions">
        <a href="{{ route('permissions.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>

    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::open(['route' => 'permissions.store', 'method'=>'POST', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.permissions.form')            
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>