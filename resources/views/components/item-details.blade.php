<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" id="details-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link text-active-primary active" id="details-model-tab" data-bs-toggle="pill" data-bs-target="#details-model" type="button" role="tab" aria-controls="details-model" aria-selected="true">Detalles</a>
    </li>
    @if($urlLog && $urlLog!="#")
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link text-active-primary" id="logs-model-tab" data-bs-toggle="pill" data-bs-target="#logs-model" type="button" role="tab" aria-controls="logs-model" aria-selected="false">Logs</a>
    </li>
    @endif
</ul>
<div class="tab-content" id="details-tab-content">
    <div class="tab-pane fade show active" id="details-model" role="tabpanel" aria-labelledby="details-model-tab">
        <div class="tab-pane fade show active" id="details_view">
            {{ $slot }}
        </div>
    </div>
    @if($urlLog && $urlLog!="#")
    <div class="tab-pane fade" id="logs-model" role="tabpanel" aria-labelledby="logs-model-tab">
        @include('pages.logs.events-model', ['urlLog'=> $urlLog])
    </div>
    @endif
</div>