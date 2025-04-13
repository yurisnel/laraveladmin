<div class="app-container container-fluid mt-5">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    @if(Session::has('success'))
    <!--begin::Alert-->
    <div class="alert alert-success d-flex align-items-center p-5 mb-10 alert-session">
        <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
        <div class="d-flex flex-center">
            <i class="fas fa-check-circle text-success fs-1 me-4"></i>
        </div>
        <!--end::Svg Icon-->
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-success"><?= nl2br(Session::get('title')) ?></h4>
            <span><?= nl2br(Session::get('success')) ?></span>
        </div>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="bi bi-x fs-1 text-success"></i>
        </button>
    </div>
    <!--end::Alert-->
    @endif
    @if(Session::has('error'))
    <!--begin::Alert-->
    <div class="alert alert-danger d-flex align-items-center p-5 mb-10 alert-session">
        <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
        <div class="d-flex flex-center">
            <i class="fas fa-exclamation-triangle text-danger fs-1 me-4"></i>
        </div>
        <!--end::Svg Icon-->
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-danger"><?= nl2br(Session::get('title')) ?></h4>
            <span><?= nl2br(Session::get('error')) ?></span>
        </div>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="bi bi-x fs-1 text-danger"></i>
        </button>
    </div>
    <!--end::Alert-->
    @endif

    @if ($errors->any())

    <div class="alert alert-danger d-flex align-items-center p-5 mb-10 alert-session">
        <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
        <div class="d-flex flex-center">
            <i class="fas fa-exclamation-triangle text-danger fs-1 me-4"></i>
        </div>
        <!--end::Svg Icon-->
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-danger">{{ __('messages.error_title') }}</h4>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="bi bi-x fs-1 text-danger"></i>
        </button>
    </div>
    <!--end::Alert-->
    @endif

</div>