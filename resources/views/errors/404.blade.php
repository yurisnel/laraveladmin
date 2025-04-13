<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
	<title>Administración | LaravelAdmin</title>
	<meta charset="utf-8" />
	<meta name="description" content="Aplicación de control interno" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta property="og:url" content="https://newfrontier.cl/" />
	<meta property="og:site_name" content="LaravelAdmin | Adminitración" />

	<link rel="shortcut icon" href="{{ url('/') }}/img/logo/favicon.png" />

	<!--begin::Fonts(usado en la mayoria de las páginas)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->

	<!--end::Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(usado en la mayoria de las páginas)-->
	<link href="{{ url('/') }}/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{{ url('/') }}/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	<script src="{{ url('/') }}/js/setup.js"></script>
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Page bg image-->
		<style>
			body {
				background-image: url("{{ url('/') }}/metronic/media/auth/bg1.jpg");
			}

			[data-theme="dark"] body {
				background-image: url("{{ url('/') }}/metronic/media/auth/bg1-dark.jpg");
			}
		</style>
		<!--end::Page bg image-->
		<!--begin:: Message -->
		<div class="d-flex flex-column flex-center flex-column-fluid">
			<!--begin::Content-->
			<div class="d-flex flex-column flex-center text-center p-10">
				<!--begin::Wrapper-->
				<div class="card card-flush w-lg-650px py-5">
					<div class="card-body py-15 py-lg-20">
						<!--begin::Title-->
						<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Oops!</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="fw-semibold fs-6 text-gray-500 mb-7">We can't find that page.</div>
						<!--end::Text-->
						<!--begin::Illustration-->
						<div class="mb-3">
							<img src="{{ url('/') }}/metronic/media/auth/404-error.png" class="mw-100 mh-300px theme-light-show" alt="" />
							<img src="{{ url('/') }}/metronic/media/auth/404-error-dark.png" class="mw-100 mh-300px theme-dark-show" alt="" />
						</div>
						<!--end::Illustration-->
						<!--begin::Link-->
						<div class="mb-0">
							<a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Volver</a>
						</div>
						<!--end::Link-->
					</div>
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Message-->
	</div>
</body>
<!--end::Body-->

</html>