<!DOCTYPE html>

<html lang="es">
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

<body id="kt_app_body" data-theme="dark" style="background-image: url('{{ url('/') }}/metronic/media/auth/bg1-dark.jpg');" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

	<div class="d-flex flex-column flex-root" id="kt_app_root">

		<div class="d-flex flex-column flex-center flex-column-fluid">
			<div class="d-flex flex-column flex-center text-center p-10">
				<div class="card card-flush w-lg-650px py-5">
					<div class="card-body py-15 py-lg-20">
						<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">419</h1>
						<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Oops!</h1>
						<div class="fw-semibold fs-2 text-gray-500 mb-7">Página expirada.</div>
						<div class="mb-3">
							<img src="{{ url('/') }}/metronic/media/auth/404-error-dark.png" class="mw-100 mh-300px" alt="" />
						</div>
						<div class="mb-0">
							<a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Volver</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	</div>

</body>
<!--end::Body-->

</html>