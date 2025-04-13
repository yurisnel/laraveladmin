<!DOCTYPE html>

<html lang="es">
	<!--begin::Head-->
	<head>
        <base href="../../"/>
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
		
		@yield('css')

		<!--begin::Vendor Stylesheets(usado en la mayoria de las páginas)-->
		<link href="{{ url('/') }}/metronic/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(usado en la mayoria de las páginas)-->
		<link href="{{ url('/') }}/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ url('/') }}/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ url('/') }}/css/my-styles.css" rel="stylesheet" type="text/css" />

		<!--end::Global Stylesheets Bundle-->
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		{{-- <style>
			.error {
				color: #f1416c;
			}
		</style> --}}
		<script> 
		      window.rootUrl = "{{ url('/') }}/";
			window.datatableLanguageUrl = "{{ url('/js/datatable_es_es.json') }}";
			window.themeUrl = "{{ url('/') }}/metronic/";			
		</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-theme="dark"  data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default scroll">

		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header">
					<!--begin::Header container-->
					<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
						<!--begin::sidebar mobile toggle-->
						<div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
							<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
								<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
								<span class="svg-icon svg-icon-1">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
										<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
						</div>
						<!--end::sidebar mobile toggle-->
						<!--begin::Mobile logo-->
						<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
							<a href="../../demo1/dist/index.html" class="d-lg-none">
								<img alt="Logo" src="{{ url('/') }}/img/logo/logo-light.png" class="h-30px" />
							</a>
						</div>
						<!--end::Mobile logo-->
						<!--begin::Header wrapper-->
						@include('modules.header')
						<!--end::Header wrapper-->
					</div>
					<!--end::Header container-->
				</div>
				<!--end::Header-->
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Sidebar-->
					@include('modules.menu')
					<!--end::Sidebar-->
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						@include('modules.alerts')
						
                        @yield('content')
                
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						@include('modules.footer')
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->

		<!--begin::Javascript-->
		
		<!--begin::Global Javascript Bundle(usado en la mayoria de las páginas)-->
		<script src="{{ url('/') }}/metronic/plugins/global/plugins.bundle.js"></script>
		<script src="{{ url('/') }}/metronic/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->

        <!--begin::Javascript(usado en la mayoria de las páginas)-->
        <script src="{{ url('/') }}/js/jquery.validate.js"></script>
        <script src="{{ url('/') }}/js/additional-methods.js"></script>
        <script src="{{ url('/') }}/js/jquery.validate.spanish.js"></script>
        <script src="{{ url('/') }}/js/jquery.rut.js"></script>
		<!--end::Javascript-->
		

		<!--begin::Vendors Javascript(usado en la mayoria de las páginas)-->
		<script src="{{ url('/') }}/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->

        <script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			//Persistencia del menu cliceado por el usuario
			$(document).ready(function() {

				//// Muestra el menú según la informacion guardada en el localStorage
				var activeLink = localStorage.getItem('activeLink');
				var fatherLink = localStorage.getItem('activeLinkFather');
				if (activeLink === 'undefined' && fatherLink === 'undefined') {
					activeLink = 'menu-link-home';
					$('#' + activeLink).addClass('active');
					localStorage.setItem('activeLink', activeLink);
				} else {
					$('#' + activeLink).addClass('active');
					$('#father-' + fatherLink).addClass('show');
				}

				//// Verifica el menú clickeado y activa el necesario además de guardarlo en el localStorage para cuando se actualice la pantalla, se mantenga la información
				$('.menu-link').on('click', function() {
					$('.menu-link').removeClass('active');
					$(this).addClass('active');
					var activeLinkId = $(this).attr('id');

					if (typeof activeLinkId !== 'undefined') {
						let lastIndex = activeLinkId.lastIndexOf('-');
						let father = activeLinkId.slice(0, lastIndex);
						localStorage.setItem('activeLinkFather', father);
					}

					localStorage.setItem('activeLink', activeLinkId);
				});
			});


            $(document).ready(function() {

				// Detener el comportamiento predeterminado de anclas con #
				$('a[href="#"]').click(function(event) {
					event.preventDefault(); 
				});

				if ($('.alert-session').is(':visible')) {
					$('.alert-session').delay(5000).queue(function(){
						$('.alert-session').parent().hide().dequeue();
						// $('.alert-session').parent().hide(1000).dequeue();
					});
				}

                $.validator.addMethod("rut", function(value, element) {
					return this.optional(element) || $.Rut.validar(value);
				}, "Este campo debe ser un rut valido.");

				$(".rut").Rut();
            });
			function tooltipRefresh(){
				$('[data-bs-toggle="tooltip"]').tooltip({
					trigger : 'hover',
					customClass: 'tooltip-inverse'
				})
			}

			let target = document.querySelector("#kt_app_body");
			let blockUI = new KTBlockUI(target, {
				message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Trabajando...</div>',
			});

			function verifyDataExistInDB(type, url, data, callback) {
				$.ajax({
					type: type,
					url: url,
					data: data,
					dataType: 'json',
					beforeSend: function () {
						blockUI.block();
					},
					success: function (respuesta) {
						callback(respuesta);
					},
					error: function (e) {
						console.log("🚀 ~ file: layout.blade.php:187 ~ verifyDataExistInDB ~ error:", e)
					},
					complete: function (respuesta) {
						blockUI.release();
						blockUI.destroy();
					}
				});
			}
			function cargarInfoTab(url, tab) {
				$(tab).empty();
				$(tab).load(url);
			};

			$(".select").select2();
            $(".datepicker").flatpickr({
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
                    }, 
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        longhand: ['Enero', 'Febreo', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    },
                }
            });

			function showGenericMessage(title, content, type) {
				Swal.fire({
                    title: title,
                    html: content,
                    icon: type,
                    buttonsStyling: false,
                    confirmButtonText: "Continuar",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
			}

        </script>
		
		@yield('scriptsForm')
        @yield('scripts')
	</body>
	<!--end::Body-->
</html>