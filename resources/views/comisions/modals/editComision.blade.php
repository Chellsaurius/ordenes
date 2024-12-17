<div class="modal fade" id="editComision{{ $comision->comision_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Editar: {{ $comision->comision_name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comision.updateComision') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $comision->comision_id }}">
                    <div class="d-flex justify-content-start row ">
                        <div class="mb-3 col-12 ">
                            <label for="name" class="form-label">Nombre de la comisión</label>
                            <input type="text" name="name" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp"
                                value="{{ $comision->comision_name }}">
                            <div id="nameHelp" class="form-text">Nuevo nombre de la comisión.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div class="mb-3 col-12">
                                <br>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBox{{ $comision->comision_id }}" required>
                                    <label class="form-check-label" for="checkBox{{ $comision->comision_id }}">He verificado los datos y son correctos.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>