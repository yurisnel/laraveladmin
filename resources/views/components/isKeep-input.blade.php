<div id="dv-isKeep" class="my-6">
      <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
            <input class="form-check-input" id="isKeep" name="isKeep" type="checkbox" value="{{ Session::has('isKeep') ? 'true' : 'false' }}" {{ Session::has('isKeep') ? 'checked' : '' }} />
            <span class="fw-semibold ps-2 fs-6">Permanecer en el formulario para seguir creando registros</span>
      </label>
</div>