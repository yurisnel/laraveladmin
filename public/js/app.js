var Api = (function () {

    function createDataTable(tableSelector, options) {

        $table = $(tableSelector);
        if ($table.length == 0) return;
        var defaults = {
            order: [],
            language: {
                url: App.rootUrl + "/js/datatable_es_es.json",
            },
            processing: true,
            serverSide: true,
            autoWidth: false,
            columns: [],
            bInfo: false,
            ajax: {},
            fnDrawCallback: function (oSettings) {
                $(tableSelector + "_count").html(oSettings["_iRecordsTotal"]);
                tooltipRefresh();
            }
        };

        var options = $.extend({}, defaults, options);

        options.ajax = {
            //type: "GET" or "POST"
            url: options.ajaxUrl,
            data: function (data) {
                $('.tableFilter').each(function (pos, el) {
                    data[el.name] = $(el).val();
                });
            }, error: function (xhr, error, thrown) {
                alert("An error occurred while attempting to retrieve data via ajax.\n" + thrown);
            }
        };

        $table.DataTable(options);

        var o, n;
        $.fn.dataTable.ext.search.push(function (table_0, data_table, a) {
            var r = o,
                s = n,
                i = parseFloat(moment(e[1]).format()) || 0;
            return !!(
                (isNaN(r) && isNaN(s)) ||
                (isNaN(r) && i <= s) ||
                (r <= i && isNaN(s)) ||
                (r <= i && i <= s)
            );
        });

        $('input.tableFilter').on("keyup", function (event) {
            let tableSelector = $(event.currentTarget).data('table');
            $(tableSelector).DataTable();
            $(tableSelector).DataTable().draw();
        });

        $('select.tableFilter').on("select2:select", function (event) {
            let tableSelector = $(event.currentTarget).data('table');
            $(tableSelector).DataTable().draw();
        });
    }

    function getColumnState() {
        return {
            data: "state",
            searchable: false,
            render: function (data, type, row, meta) {
                return type === "display"
                    ? '<span class="badge py-3 px-4 fs-7 badge-light-' +
                    (row.state ? "success" : "danger") +
                    '">' +
                    (row.state ? "Activo" : "Inactivo") +
                    "</span>"
                    : data;
            },
        };
    }

    function getColumnOptions(resourceName, options = {}) {
        return {
            data: "options",
            orderable: false,
            searchable: false,
            width: options.width ? options.width : 0,
            render: function (data, type, row, meta) {
                return getOptionsHtml(row, resourceName, options);
            },
        };
    }
    function getOptionsHtml(row, resourceName, options = {}) {
        let html = '';
        let toString = row.to_string;
        let addtx = toString.startsWith("el") ? 'd' : 'de ';
        let urlElement = App.rootUrl + resourceName.replace(".", "/") + "/" + row.id;
        let def = {
            details: {
                url: urlElement,
                class: 'btn-primary jsShowModal',
                title: 'Ver detalles ' + addtx + toString,
                html: '<i class="fa fa-search"></i>',
                active: userHasPermission(getRoutePermission(resourceName + ".show"), row)
            },
            edit: {
                url: urlElement + '/edit',
                class: 'btn-warning',
                title: 'Editar ' + toString,
                html: '<i class="fa fa-edit"></i>',
                active: userHasPermission(getRoutePermission(resourceName + ".update"), row)
            },
            enable: {
                url: urlElement + (row.state ? '/disable' : '/enable'),
                class: 'jsLinkAjax jsConfirm ' + (row.state ? 'btn-danger' : 'btn-success'),
                title: (row.state ? 'Deshabilitar ' : 'Habilitar ') + toString,
                html: '<i class="fa ' + (row.state ? 'fa-ban' : 'fa-check') + '"></i>',
                active: userHasPermission(getRoutePermission(resourceName + ".enable"), row)
            },
            destroy: {
                url: urlElement,
                class: 'btn-danger jsRemoveAjax jsConfirm',
                title: 'Eliminar ' + toString,
                html: '<i class="fa fa-trash"></i>',
                active: userHasPermission(getRoutePermission(resourceName + ".destroy"), row)
            }
        };
        //var options = $.extend({}, def, options);        
        options = overrideOptions(def, options);

        for (let key in options) {
            let btn = options[key];
            if (typeof btn === "function") {
                html += btn(row);
            } else if (typeof btn === "object") {
                if (getValue(btn.active, row)) {
                    html += '<a href="' + getValue(btn.url, row) + '" class="btn btn-sm btn-icon me-2 ' + getValue(btn.class, row) + '" title="' + getValue(btn.title, row) + '" data-bs-toggle="tooltip" ' + (btn.attrs ? getValue(btn.attrs, row) : '') + '>' + getValue(btn.html, row) + '</a>';
                }
            }
        }

        return html;
    }
    function overrideOptions(def, options) {
        for (let key in options) {
            let btn = options[key];
            if (options[key] === false) {
                delete def[key];
            }
            else if (def[key]) {
                for (let attr in btn) {
                    def[key][attr] = options[key][attr];
                }
            } else {
                def[key] = options[key];
            }
        }
        return def;
    }

    function getValue(option, row) {
        if (typeof option === "function") {
            return option(row);
        } else {
            return option;
        }
    }

    function getRoutePermission(routeName) {
        return App.routesPermission
        [routeName] ? App.routesPermission[routeName] : false;
    }

    function userHasPermission(permission, row) {

        if (!permission) return false;

        // a un superAdmin solo puede modificarlo otro super admin
        if (permission == 'users.update') {
            if (row.role_name == 'SuperAdmin' && App.user.role_name != 'SuperAdmin') {
                return false;
            }
        }

        let list = App.user.permissions;
        for (let i = 0; i < list.length; i++) {
            if (list[i].name == permission) {
                return true;
            }
        }
        return false;
    }

    //Persistencia del menu cliceado por el usuario
    function initMenu() {
        //// Muestra el menú según la informacion guardada en el localStorage
        var activeLink = localStorage.getItem("activeLink");
        var fatherLink = localStorage.getItem("activeLinkFather");
        if (activeLink === "undefined" && fatherLink === "undefined") {
            activeLink = "menu-link-home";
            $("#" + activeLink).addClass("active");
            localStorage.setItem("activeLink", activeLink);
        } else {
            $("#" + activeLink).addClass("active");
            $("#" + fatherLink).addClass("show");
        }

        //// Verifica el menú clickeado y activa el necesario además de guardarlo en el localStorage para cuando se actualice la pantalla, se mantenga la información
        $(".menu-link").on("click", function () {
            let href = $(this).attr("href");
            if (!href || href == '#') return;

            $(".menu-link").removeClass("active");
            $(this).addClass("active");
            let activeLinkId = $(this).attr("id");

            if (typeof activeLinkId !== "undefined") {
                let father = $(this).closest(".menu-accordion").attr("id");
                localStorage.setItem("activeLinkFather", father);
            }

            localStorage.setItem("activeLink", activeLinkId);
        });
    }

    function initJsTree() {
        $jstree = $('.jstree');
        var $jstree_inputs = $('<div id="jstree_inputs"></div>');
        $jstree.after($jstree_inputs);

        $jstree.closest('form').submit(function (e) {
            jsTreeInstance = $jstree.jstree(true);
            selectedNodes = jsTreeInstance.get_selected();
            parents = {};
            // Make sure the inputs placeholder is empty
            $jstree_inputs.empty();
            // Add input elements for all selected nodes
            selectedNodes.forEach(function (id) {
                node = jsTreeInstance.get_node(id);
                nodeName = node.data.name;
                nodeValue = node.data.value;
                parents[node.parent] = node.parent;
                $jstree_inputs.append($('<input>', {
                    type: 'hidden',
                    name: nodeName,
                    value: nodeValue
                }));
            });

            // marcar los padres tambien
            for (var id in parents) {
                node = jsTreeInstance.get_node(id);
                nodeName = node.data.name;
                nodeValue = node.data.value;
                $jstree_inputs.append($('<input>', {
                    type: 'hidden',
                    name: nodeName,
                    value: nodeValue
                }));
            };
        });

    }

    function tooltipRefresh() {
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: "hover",
            customClass: "tooltip-inverse",
        });
    }

    function executeAjaxPost(ajaxUrl, data, callback) {
        return executeAjax({
            type: "POST",
            dataType: "json",
            url: ajaxUrl,
            data: data,
            callback: callback,
        });
    }
    function executeAjaxGet(ajaxUrl, callback) {
        return executeAjax({
            type: "GET",
            dataType: "json",
            url: ajaxUrl,
            callback: callback,
        });
    }
    function executeAjaxDelete(ajaxUrl, callback) {
        return executeAjax({
            type: "DELETE",
            dataType: "json",
            url: ajaxUrl,
            callback: callback,
        });
    }

    function executeAjax(options) {
        let target = document.querySelector("#kt_app_body");
        let blockUI = new KTBlockUI(target, {
            message:
                '<div class="blockui-message"><span class="spinner-border text-primary"></span> Trabajando...</div>',
        });

        let defaults = {
            type: "GET",
            // url: url,
            //dataType: "json",
            beforeSend: function () {
                blockUI.block();
            },
            success: function (response) {
                if (options.callback) options.callback(response);
            },
            error: function (e) {
                console.log(e);
                if (e.responseJSON) {
                    let resp = e.responseJSON;
                    if (resp.errors) {
                        $('form.jsFormAjax').validate().showErrors(resp.errors);
                    } else {
                        showMessageSwal("error", resp.error || resp.message, resp.title ? resp.title : "");
                    }
                    activeIndicator($("button", "form.jsValidate"), false);

                }

            },
            complete: function (response) {
                blockUI.release();
                blockUI.destroy();
            },
        };

        var options = $.extend({}, defaults, options);
        $.ajax(options);
    }

    function getDataForm($form) {
        let dataParam = $form.serializeArray();
        let data = {};
        $.each(dataParam, function (index, field) {
            data[field.name] = field.value;
        });
        delete data._method;
        return data;
    }

    function validateFieldOnServer(field, ajaxUrl) {
        var $field = $(field);
        var $form = $field.closest("form");
        var fieldName = field.name;
        var $form = $(field).closest("form");
        let data = getDataForm($form);

        executeAjaxPost(ajaxUrl, data, function (response) {

            if (response != 0 && response.errors && response.errors[fieldName]) {
                let errors = {};
                let messages = response.errors[fieldName];
                for (let i = 0; Array.isArray(messages) && i < messages.length; i++) {
                    messages[i] = messages[i].replace(":input", $field.val());
                }
                errors[fieldName] = messages;
                $form.validate().showErrors(errors);
                $field.val('');
            } else {
                $field.valid();
            }
        });
    }

    function searchFieldOnServer(field, ajaxUrl) {
        var $field = $(field);
        var $form = $field.closest("form");
        var fieldName = field.name;
        let data = {};
        data[fieldName] = field.value;
        executeAjaxPost(ajaxUrl, data, function (response) {
            $('input, select', $form).prop("disabled", false);
            if (response.success == false) {
                let errors = {};
                let messages = response.errors[fieldName];

                for (let i = 0; Array.isArray(messages) && i < messages.length; i++) {
                    messages[i] = messages[i].replace(":input", $field.val());
                }
                errors[fieldName] = messages;
                $form.validate().showErrors(errors);
                $field.val('');
            } else {
                $field.valid();
                if (response.data) {
                    $.each(response.data, function (name, value) {
                        let $formField = $('[name="' + name + '"]');
                        if (fieldName != name && $formField.length) {
                            if ($formField.is('select')) {
                                $formField.val(value).trigger('change');
                            } else {
                                $formField.val(value);
                            }
                            $formField.prop("disabled", true);
                        }
                    });
                }
            }
        });
    }

    function showMessageSwal(type, content, title = "") {
        if (!content && type == 'success') {
            content = "Operación realizada correctamente";
        }
        if (!title && type == "error") {
            //title = "Hay errores";
        }

        Swal.fire({
            title: title,
            //html: content,
            text: content,
            icon: type, //"success", error, warnig
            buttonsStyling: false,
            confirmButtonText: "Continuar",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
            }
        });
    }


    function iformat(icon) {
        var originalOption = icon.element;
        if (originalOption && originalOption.value)
            return $('<span><i class="' + originalOption.value + '"></i> ' + icon.text + "</span>");
        else
            return $("<span>" + icon.text + "</span>");
    }

    function confirmAction(event, callback) {
        event.preventDefault();
        let $link = $(event.currentTarget);
        //$link.data("stopEvent", true);
        var url = $link.attr("href");
        var title = $link.attr("title");
        if (!title) {
            title = $link.attr("aria-label");
        }
        Swal.fire({
            text: "¿Está seguro que desea \"" + title + "\"?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Si, adelante!",
            cancelButtonText: "No, cancelar",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        }).then(function (result) {
            if (result.value) {
                if (callback) callback();
                /*if ($link.hasClass('jsLinkAjax')) {
                    $link.data("stopEvent", false);
                    linkAjax(event);
                } else {
                    window.location.href = url;
                }*/

            } else if (result.dismiss === "cancel") {

            }
        });
    }

    function submitFormAjax(form) {
        var $form = $(form);
        let ajaxUrl = $form.attr("action") + "?ajax";
        let method = $form.attr("method");
        let data = getDataForm($form);

        return executeAjax({
            type: method,
            dataType: "json",
            url: ajaxUrl,
            data: data,
            callback: function (response) {
                if (response.message) {
                    Swal.fire({
                        title: response.message
                    });
                }
                activeIndicator($("button", "form.jsValidate"), false);
                $("#myModal").modal('hide');
            },
        });
    }

    function linkAjax(event) {
        event.preventDefault();
        let $link = $(event.currentTarget);
        let ajaxUrl = $link.attr("href") + "?ajax";
        executeAjaxGet(ajaxUrl, function (response) {

            showMessageSwal("success", response.success);

            let table = event.currentTarget.closest('.dataTable');
            if (table) {
                $(table).DataTable().draw();
            }

        });
    }

    function removeAjax(event) {
        event.preventDefault();
        let $link = $(event.currentTarget);
        let ajaxUrl = $link.attr("href") + "?ajax";
        executeAjaxDelete(ajaxUrl, function (response) {

            showMessageSwal("success", response.success || "Elemento eliminado correctamente");

            let table = event.currentTarget.closest('.dataTable');
            if (table) {
                $(table).DataTable().draw();
            }
        });
    }

    function ajaxShowModal(event) {
        event.preventDefault();
        let $link = $(event.currentTarget);
        let ajaxUrl = $link.attr("href");
        var title = $link.attr("title");
        var modalWidth = $link.data("modal-width");

        $myModal = $("#myModal");
        $myModal.find(".modal-content").css("maxWidth", modalWidth ? modalWidth : "initial");

        let options = {
            type: "GET",
            url: ajaxUrl,
            callback: function (response) {
                if (response) {
                    $myModal.modal("show");
                    $(".modal-body", $myModal).html(response);
                    $modalTitle = $(".js-modal-title", $myModal);
                    if ($modalTitle.length > 0) {
                        title = $modalTitle.text().trim();
                        $modalTitle.closest('.card-header').hide();
                    }
                    if (title) {
                        $(".modal-title", $myModal).html(title);
                    }
                }
            },
        };
        executeAjax(options);
    }

    function initTimerSession() {
        var timeLeft = App.sessionLifetime - 1; // tiempo en espirar la session sin actividad
        var threshold = 1; // Umbral en minutos para mostrar la alerta
        // Función para actualizar el contador y mostrar la alerta si es necesario
        function updateCounter() {
            // Verificar si el tiempo restante es menor o igual que el umbral
            if (timeLeft == threshold) {
                // Mostrar una alerta al usuario

                Swal.fire({
                    title: "¿Sigues por ahí?",
                    text: "Tu sesión está a punto de expirar ¿Quieres mantener activa tu sesión?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    allowOutsideClick: false, // No permitir cerrar la ventana haciendo clic fuera de ella
                    allowEscapeKey: false, // No permitir cerrar la ventana presionando la tecla Escape
                    confirmButtonText: "Si, mantener!",
                    cancelButtonText: "No, cerrar",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        //window.location.reload();
                        clearInterval(counterInterval); // Detener la actualización del contador
                        initTimerSession();
                        executeAjaxPost(App.rootUrl + 'keep-session-active', {}, function (response) {
                            Swal.fire({
                                title: 'Sesión activada',
                                timer: 2 * 1000,
                            });
                        });
                    } else if (result.dismiss === "cancel") {
                        modalCLoseSesion();
                        $("#clickLogout").click();
                    }
                });
            }
            else if (timeLeft == 0) {
                modalCLoseSesion();
                window.location.href = App.rootUrl;
            } else if (timeLeft < threshold) {
                //mostrar tiempo restante
                //document.getElementById('time').innerText = timeLeft + " minutos";
            }

            timeLeft--;
        }
        // Actualizar el contador cada 1 minuto
        var counterInterval = setInterval(updateCounter, 60 * 1000); // 60000 ms = 1 minuto
    }

    function modalCLoseSesion() {
        Swal.fire({
            title: 'Cerrando sesión',
            html: 'Se está cerrando tu sesión. Por favor, espera...',
            allowOutsideClick: false, // No permitir cerrar la ventana haciendo clic fuera de ella
            allowEscapeKey: false, // No permitir cerrar la ventana presionando la tecla Escape
        });

    }
    function activeIndicator($btn, active) {
        if (active) {
            $btn.attr("data-kt-indicator", "on");
        } else {
            $btn.removeAttr("data-kt-indicator");
        }
        //$btn.attr("disabled", active);
    }

    function initRestPassForm() {

        const form = document.querySelector("#kt_new_password_form");
        //const btn = document.querySelector("#kt_new_password_submit");
        let el = form.querySelector('[data-kt-password-meter="true"]');
        //const meter = KTPasswordMeter.getInstance(el);
        const meter = new KTPasswordMeter(el);

        jQuery.validator.addMethod("checkMeter", function (value, element) {
            return this.optional(element) || (100 === meter.getScore());
        }, 'La contraseña no es segura');

        $(form).validate({
            rules: {
                password: {
                    minlength: 8,
                    checkMeter: true
                },
                password_confirmation: {
                    equalTo: "#password"
                }
            },
            submitHandler: function (form) {
                submitFormAjax(form);
            },
            invalidHandler: function (event, validator) {
                activeIndicator($("button", this), false);
            }
        });
    };
    return {
        createDataTable: createDataTable,

        getColumnState: getColumnState,

        getColumnOptions: getColumnOptions,

        getOptionsHtml: getOptionsHtml,

        userHasPermission: userHasPermission,

        validateFieldOnServer: validateFieldOnServer,

        searchFieldOnServer: searchFieldOnServer,

        initRestPassForm: initRestPassForm,

        showMessageSwal: showMessageSwal,

        initApp: function () {
            initTimerSession();
            initMenu();
            initJsTree();

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            // Detener el comportamiento predeterminado de anclas con #
            $(document).on("click", 'a[href="#"]', function (event) {
                event.preventDefault();
            });

            $(document).on("click", "a.jsShowModal", ajaxShowModal);

            $(document).on("click", "a.jsLinkAjax", function (event) {
                let $link = $(event.currentTarget);
                if ($link.hasClass('jsConfirm')) {
                    confirmAction(event, function () { linkAjax(event) });
                } else {
                    linkAjax(event);
                }
            });

            $(document).on("click", "a.jsRemoveAjax", function (event) {
                confirmAction(event, function () { removeAjax(event) });
            });

            $(document).on("submit", ".jsFormAjax", function (event) {
                submitFormAjax(event.currentTarget);
            });

            if ($(".alert-session").is(":visible")) {
                $(".alert-session")
                    .delay(5000)
                    .queue(function () {
                        $(".alert-session").parent().hide().dequeue();
                        // $('.alert-session').parent().hide(1000).dequeue();
                    });
            }

            $("form.jsValidate")
                .on("submit", function () {
                    let btn = $(this).find("button[type='submit']");
                    activeIndicator(btn, true);
                })
                .validate({
                    invalidHandler: function (event, validator) {
                        //$form.addClass('was-validated');
                        activeIndicator($("button", this), false);
                    }
                });

            $btns = $("button[type='submit']");
            $btns.each(function (pos, el) {
                $btn = $(el);
                html = $btn.html();
                $btn.text("");
                $('<span class="indicator-label">' + html + '</span>').appendTo($btn);
                $('<span class="indicator-progress">Por favor, espere...<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>').appendTo($btn);
            });


            /*$.validator.addMethod(
                "rut",
                function (value, element) {
                    return this.optional(element) || $.Rut.validar(value);
                },
                "Este campo debe ser un rut valido."
            );*/
            $(".rut").Rut();

            $(".select").select2();
            $(".select2icon").select2({
                // width: "100%",
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true,
            });
            $(".datepicker").flatpickr({
                locale: App.locale,
            });

        },
    };
})();

$(document).ready(function () {
    Api.initApp();
});
