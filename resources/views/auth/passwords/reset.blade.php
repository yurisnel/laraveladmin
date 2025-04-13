@extends('layouts.guest')

@section('content')
<div class="card rounded-3 w-md-550px">
	<div class="card-body p-10 p-lg-20">
		<form method="POST" class="form w-100" novalidate="novalidate" id="kt_new_password_form" action="{{ route('password.store') }}">
			@csrf

			<!-- Password Reset Token -->
			<input type="hidden" name="token" value="{{ $request->route('token') }}">

			<div class="text-center mb-10">
				<h1 class="text-dark fw-bolder mb-3">Restablecer contraseña</h1>
				<div class="text-gray-500 fw-semibold fs-6">¿Ya restableciste la contraseña?
					<a href="{{ route('login') }}" class="link-primary fw-bold">Login</a>
				</div>
			</div>

			<div class="position-relative mb-3">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email" value="{{ $email ?? old('email', $request->email) }}" required autocomplete="email" autofocus>
				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			<div class="fv-row mb-8" data-kt-password-meter="true">
				<div class="mb-1">
					<div class="position-relative mb-3">
						<input id="password" type="password" class="form-control bg-transparent @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="new-password">
						<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
							<i class="bi bi-eye-slash fs-2"></i>
							<i class="bi bi-eye fs-2 d-none"></i>
						</span>
						@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
						<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
						<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
						<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
						<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
					</div>
				</div>
				<div class="text-muted">Utilice 8 o más caracteres en combinación de letras (minúsculas y mayúsculas), números y al menos un caracter especial.</div>
			</div>
			<div class="fv-row mb-8">
				<input id="password_confirmation" type="password" class="form-control bg-transparent" name="password_confirmation" placeholder="Confirmar contraseña" required autocomplete="new-password">
			</div>
			<div class="d-grid mb-10">
				<button type="submit" id="kt_new_password_submit" class="btn btn-primary">
					<span class="indicator-label">Restablecer contraseña</span>
					<span class="indicator-progress">Espere por favor...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
					</span>
				</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scriptsForm')

<script>
	"use strict";
	$(document).ready(function() {
		
		const form = document.querySelector("#kt_new_password_form");
		const btn = document.querySelector("#kt_new_password_submit");
		const meter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

		jQuery.validator.addMethod("checkMeter", function(value, element) {
			return this.optional(element) || (100 === meter.getScore());
		}, 'La contraseña no es segura');

		$(form).validate({
			rules: {
				password: {
					required: true,
					minlength: 8,
					checkMeter: true
				},
				password_confirmation: {
					equalTo: "#password"
				}
			},
			submitHandler: function(form) {
				btn.setAttribute("data-kt-indicator", "on");
				btn.disabled = true;
				form.submit();
			}
		});
	});

</script>
@endsection