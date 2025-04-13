<x-app-layout pageTitle="Crear nuevo usuario" :breadcrumb="['Home' => route('dashboard'), 'Listado usuarios' => route('users.index')]">
    <x-slot name="actions">
        <a href="{{ route('users.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>

    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::open(['route' => 'users.store', 'method'=>'POST', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.users.form')
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>