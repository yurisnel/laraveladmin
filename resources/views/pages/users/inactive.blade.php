@extends('layouts.guest')

@section('content')
<div class="d-flex flex-column flex-root" id="kt_app_root">

	<!--begin::Authentication - Signup Welcome Message -->
	<div class="d-flex flex-column flex-center flex-column-fluid">
		<!--begin::Content-->
		<div class="d-flex flex-column flex-center text-center p-10">
			<!--begin::Wrapper-->
			<div class="card card-flush w-lg-650px py-5">
				<div class="card-body py-15 py-lg-16">
					<!--begin::Logo-->
					<div class="mb-14">
						<img alt="Logo" src="/metronic/media/auth/membership-dark.png" height="130" />
					</div>
					<!--end::Logo-->
					<!--begin::Title-->
					<h1 class="fw-bolder text-gray-900 mb-5">{{$titleError}}</h1>
					<!--end::Title-->
					<!--begin::Text-->
					<div class="fw-semibold fs-6 text-gray-500 mb-8">
						@if(isset($urlActivate))
						@lang('messages.request_activation')
						@else
						@lang('messages.request_activation_ok')
						@endif
					</div>
					<!--end::Text-->
					<!--begin::Link-->
					<div class="mb-11">
						@if(isset($urlActivate))
						<a href="{{$urlActivate}}" class="btn btn-sm btn-primary">Realizar solicitud de activación</a>
						@endif
					</div>
					<!--end::Link-->
					<!--begin::Illustration-->
					<div class="mb-0">
						<img src="assets/media/auth/membership.png" class="mw-100 mh-300px theme-light-show" alt="" />
						<img src="assets/media/auth/membership-dark.png" class="mw-100 mh-300px theme-dark-show" alt="" />
					</div>
					<!--end::Illustration-->
				</div>
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Content-->
	</div>
	<!--end::Authentication - Signup Welcome Message-->
</div>
@endsection