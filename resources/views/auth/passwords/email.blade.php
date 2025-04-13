@extends('layouts.guest')

@section('content')
<div class="card rounded-3 w-md-550px">
	<div class="card-body p-10 p-lg-20">
		<form method="POST" class="form w-100" action="{{ route('password.email') }}">
			@csrf
			{{-- <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="../../demo1/dist/authentication/layouts/creative/new-password.html" action="#"> --}}
			<div class="text-center mb-10">
				<h1 class="text-dark fw-bolder mb-3">¿ Olvidó su contraseña ?</h1>
				<div class="text-gray-500 fw-semibold fs-6">Ingrese su correo para poder crear su nueva contraseña.</div>
			</div>
			<div class="fv-row mb-8">
				<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
				<input id="email" type="email" placeholder="Ingrese su correo" class="form-control bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="d-flex flex-wrap justify-content-center pb-lg-0">
				<button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
					<span class="indicator-label">Solicitar cambio de contraseña</span>
					<span class="indicator-progress">Espere por favor...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
				<a href="{{ route('login') }}" class="btn btn-light">Cancelar</a>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scriptsForm')
<script src="{{ url('/') }}/metronic/js/custom/authentication/reset-password/reset-password.js"></script>

@endsection