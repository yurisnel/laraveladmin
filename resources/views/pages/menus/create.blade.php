<x-app-layout pageTitle="Crear nuevo menú" :breadcrumb="['Home' => route('dashboard'), 'Listado de menús' => route('menus.index')]">
    <x-slot name="actions">
        <a href="{{ route('menus.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>

    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::open(['route' => 'menus.store', 'method'=>'POST', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.menus.form')
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>