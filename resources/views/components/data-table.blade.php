@props(['tableId' => 'table0', 'filters' =>['state']])

<!--begin::Table-->
<div class="card card-flush mt-6 mt-xl-9">
    <!--begin::Card header-->
    <div class="card-header mt-5">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h3 class="fw-bold mb-1">{{$title}}</h3>
            <div class="fs-6 text-gray-400">Cantidad <span id="{{$tableId}}_count">0</span></div>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar my-1">
            @foreach ($configFilters as $name=>$filter)
            <div class="me-4 d-flex align-items-center fw-bold">
                <div class="text-gray-700 me-2">{{$filter['label']}} </div>
                @if(is_array($filter['options']))
                <select name="filter_{{$name}}" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm tableFilter" data-table="#{{$tableId}}">
                    @foreach ($filter['options'] as $value=>$label)
                    <option value="{{$value}}">{{$label}}</option>
                    @endforeach
                </select>
                @endif
            </div>
            @endforeach

            <div class="d-flex align-items-center position-relative my-1">
                <span class="svg-icon  position-absolute ms-3"> <span class="fa fa-search"></span> </span>
                <input type="text" name="filter_text" class="form-control form-control-solid form-select-sm w-150px ps-9 tableFilter" placeholder="Buscar..." data-table="#{{$tableId}}"/>
            </div>
            <!--end::Search-->
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table id="{{$tableId}}" class="table table-row-bordered table-row-dashed table-hover gy-4 fw-bold">
                <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr class="text-center text-dark">
                        @foreach ($columns as $name)
                        <th class="text-hover-primary">{{$name}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">

                </tbody>

            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->