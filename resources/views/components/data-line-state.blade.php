<div class="row detail-line">
    <div class="col-lg-4">
        <span class="detail-label">{{$label}}</span>
    </div>
    <div class="col-lg-8">
        <span @class([ "badge py-3 px-4 fs-7" , "badge-light-success"=> $value,
            "badge-light-danger" => !$value
            ])>@if($value) Activo @else Inactivo @endif</span>
    </div>
</div>