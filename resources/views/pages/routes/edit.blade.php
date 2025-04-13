<x-app-layout pageTitle="Editar ruta" :breadcrumb="['Home' => route('dashboard'), 'Listado de rutas' => route('routes.index')]">
    <x-slot name="actions">
        <a href="{{ route('routes.index') }}" class="btn btn-sm fw-bold btn-info hover-elevate-down">
            <i class="fa fa-arrow-left"></i> Volver al listado
        </a>
    </x-slot>


    <div class="card card-flush shadow-sm mt-6 px-6">
        <div class="card-body">
            {!! Form::model($item, ['route' => ['routes.update', $item->id], 'method' => 'PATCH', 'autocomplete' => 'off', 'class'=>'jsValidate']) !!}
            @include('pages.routes.form')
            <input name="id" type="hidden" value="{{$item->id}}">
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>