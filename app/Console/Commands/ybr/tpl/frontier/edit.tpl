<x-app-layout pageTitle="Editar NAME_MODEL" :breadcrumb="['Home' => route('dashboard'), 'Listado de NAME_TABLE' => route('NAME_TABLE.index')]">
    <x-slot name="actions">
        <a href="{{ route('NAME_TABLE.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>


    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::model($item, ['route' => ['NAME_TABLE.update', $item->id], 'method' => 'PATCH', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.NAME_TABLE.form')
            <input name="id" type="hidden" value="{{$item->id}}">
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>