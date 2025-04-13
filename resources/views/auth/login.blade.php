@extends('layouts.guest')

@section('content')
<div class="card rounded-3 w-md-550px">
	<div class="card-body p-10 p-lg-20">
		<form method="POST" action="{{ route('login') }}" novalidate="novalidate" id="kt_sign_in_form" class="form w-100 jsValidate" data-kt-redirect-url="{{route('dashboard')}}">
			@csrf
			<div class="text-center mb-11">
				<h1 class="text-dark fw-bolder mb-3">Iniciar sesión</h1>
			</div>

			<div class="separator separator-content my-14">
				<span class="w-125px text-gray-500 fw-semibold fs-7">Bienvenido</span>
			</div>
			<div class="fv-row mb-8">
				<input id="email" type="email" class="form-control bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingresar correo">

				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="fv-row mb-8">
				<input id="password" type="password" class="form-control bg-transparent @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Ingresar password">

				@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			@if(env('H_CAPTCHA_ENABLE', true))
			<div class="fv-row mb-8">
				<div class="h-captcha" data-sitekey="{{ env('H_CAPTCHA_SITEKEY') }}"></div>
			</div>
			@endif
			<div class="fv-row mb-3">
				<div class="float-left">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

						<label class="form-check-label" for="remember">
							{{ __('Recordarme') }}
						</label>
					</div>
				</div>
			</div>
			<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
				<div></div>
				<a href="{{ route('password.request') }}" class="link-primary">¿ Olvidó su contraseña ?</a>
			</div>
			<div class="d-grid mb-10">
				<button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
					<span class="indicator-label">Iniciar Sesión</span>
					<span class="indicator-progress">Por favor, espere...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scriptsForm')
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>

<script>
	$(document).ready(function() {
		$("form.jsValidate").validate({
			invalidHandler: function(event, validator) {
				$("button", this).removeAttr("data-kt-indicator");
			}
		});

		$("form.jsValidate button").click(function() {
			$(this).attr("data-kt-indicator", "on");
		})
	});
</script>

@endsection