<h3 class="title my-5">Datos del Role</h3>

<div class="row">
    <div class="col-md-6 ">
        <div class="col-lg-12 mb-5">
            <x-text-input name="name" label="Nombre" placeholder="Ingresar Nombre" required="true" />
        </div>
        <div class="col-lg-12 mb-5">
            <x-text-input name="description" label="Descripción" placeholder="Ingresar descripción" />
        </div>
        @isset($item->id)
        <div class="col-lg-12 mb-5">
            <x-select-input name="state" label="Estado" :values="Config::get('constants.state')" placeholder="Seleccione estado" required="true" :selected="isset($item)?$item->state:0" />
        </div>
        @endisset
    </div>

    <div class="col-md-6">
        <label class="mb-3">Permisos</label>
        <!--
        <ul class="treeview">
            @foreach ($permisions as $perm)
            <x-item-tree name="permissions[]" :item="$perm" :selected="isset($selected)?$selected:[]" class="parent" />
            @endforeach
        </ul>
        -->
        <div class="jstree">
            <ul>
                @foreach ($permisions as $perm)
                <x-item-list name="permissions[]" :item="$perm" :selected="isset($selected)?$selected:[]" class="parent" />
                @endforeach
            </ul>
        </div>
    </div>
</div>

<hr>
<button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Guardar</button>

<x-slot name="scripts">
    <link rel="stylesheet" href="{{ url('/') }}/js/jstree/themes/default/style.min.css" />
    <script src="{{ url('/') }}/js/jstree/jstree.js"></script>
    <script>
        $(document).ready(function() {

            /*$('.treeview').on('change', '.parent', function() {
                var isChecked = $(this).prop('checked');
                $(this).parent().find('.child').prop('checked', isChecked); // Marcar/desmarcar todos los hijos
            });

            $('.treeview').on('click', '.form-label', function() {
                $(this).parent().find('ul').toggle(this.checked);
            });*/

            $('.jstree').jstree({
                    "plugins": ["checkbox"],
                    "checkbox": {
                        three_state: false
                    },
                }).on("changed.jstree", function(e, data) {
                    if (!data.node) return;
                    jsTreeInstance = $jstree.jstree(true);
                    let event = data.action == "select_node" ? "check_node" : "uncheck_node";

                    // si selecciona/deselecciona el padre => se seleccionan/deseleccionan todos los hijos
                    let childrens = data.node.children;
                    for (i = 0; i < childrens.length; i++) {
                        $jstree.jstree(event, childrens[i]);
                    };

                    // si selecciona un hijo => se selecciona el padre 
                    //error se seleccionan todos los hermanos tambien)
                    /*let parent = data.node.parent;
                    parent = $jstree.jstree().get_node(parent);
                    parent['a_attr'].multiple = false;
                    $jstree.jstree(event, parent);*/

                })
                // si se deseleccionan todos los hijos => se deselecciona el padre  
                .on("deselect_node.jstree", function(e, data) {
                    jsTreeInstance = $jstree.jstree(true);
                    selected = jsTreeInstance.get_checked_descendants(data.node.parent, true);
                    if (selected.length == 0) {
                        $jstree.jstree("uncheck_node", data.node.parent);
                    }
                });
        });
    </script>
</x-slot>