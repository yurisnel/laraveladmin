<!DOCTYPE html>

<html lang="es">

<head>
	<base href="../../" />
	<title>Administración | LaravelAdmin</title>
	<meta charset="utf-8" />
	<meta name="description" content="Aplicación de control interno" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta property="og:url" content="https://newfrontier.cl/" />
	<meta property="og:site_name" content="LaravelAdmin | Adminitración" />

	<link rel="shortcut icon" href="{{ url('/') }}/img/logo/favicon.png" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="{{ url('/') }}/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{{ url('/') }}/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<link href="{{ url('/') }}/css/my-styles.css" rel="stylesheet" type="text/css" />
	<script>
		window.themeUrl = "{{ url('/') }}/metronic/";
	</script>

</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default scroll">
	<script src="{{ url('/') }}/js/setup.js"></script>
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<style>
			body {
				background-image: url("{{ url('/') }}/img/auth/bg4-dark.jpg");
			}
		</style>
		<div class="d-flex flex-column flex-column-fluid flex-lg-row">
			<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
				<div class="d-flex flex-center flex-lg-start flex-column">
					<a href="#" class="mb-7">
						<img alt="Logo" src="{{ url('/') }}/img/logo/logo-light.png">
					</a>
					<h2 class="text-white fw-normal m-0">Aplicación de administración interna</h2>
				</div>
			</div>
			<div class="d-flex flex-center flex-column w-lg-50 p-10">
				@include('modules.alerts')

				@yield('content')

			</div>
		</div>
	</div>

	<script src="{{ url('/') }}/metronic/plugins/global/plugins.bundle.js"></script>
	<script src="{{ url('/') }}/metronic/js/scripts.bundle.js"></script>
	<script src="{{ url('/') }}/js/jquery.validate.js"></script>
	<script src="{{ url('/') }}/js/localization/messages_es.js"></script>

	@yield('scriptsForm')
</body>

</html>