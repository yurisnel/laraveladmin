<x-app-layout pageTitle="Editar empresa" :breadcrumb="['Home' => route('dashboard'), 'Listado de empresas' => route('clients.index')]">
    <x-slot name="actions">
        <a href="{{ route('clients.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>


    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::model($item, ['route' => ['clients.update', $item->id], 'method' => 'PATCH', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.clients.form')
            <input name="id" type="hidden" value="{{$item->id}}">
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>