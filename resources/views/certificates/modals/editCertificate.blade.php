<div class="modal fade" id="editCertificate{{ $certificate->certificate_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar el acta con fecha: {{ date_format(date_create($certificate->certificate_date), 'd-m-Y') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action=" {{ route('certificate.edit') }}" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="certificate" value="{{ $certificate->certificate_id }}">
                    <div class="mb-3 col-12 ">
                        <label for="administration" class="form-label">Administración</label>
                        <input type="text" name="administration" value="{{ $certificate->certificate_administration }}" class="form-control text-uppercase" 
                            maxlength="255" placeholder="En la que se dio la sesión" required>
                        <div id="administrationHelp" class="form-text">Periodo de la administración que levantó el acta.</div>
                        @error('administration')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <label for="date" class="form-label">Fecha del acta</label>
                        <input type="date" name="date" class="form-control text-uppercase" value="{{ $certificate->certificate_date }}" aria-describedby="dateHelp" required>
                        <div id="dateHelp" class="form-text">Fecha oficial del acta.</div>
                        @error('date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 ">
                        <label for="order" class="form-label">Pertenece a la orden</label>
                        <select name="order" id="order{{ $certificate->certificate_id }}" class="form-control text-uppercase" 
                            aria-describedby="typesHelp" required>
                            <option value="{{ $certificate->order_id }}" id="order_id{{ $certificate->certificate_id }}" disabled selected>{{ $certificate->order_subject }}</option>
                            
                        </select>
                        <div id="orderHelp" class="form-text">Lista de órdenes disponibles.</div>
                        @error('order')
                            <span class="invalid-feedback"
                                role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    
                    <div class="mb-3 col-12 ">
                        <label for="file" class="form-label text-uppercase">(Opcional) Documento: </label>
                        <input type="file" name="file" class="form-control" aria-describedby="fileHelp">
                        <div id="fileHelp" class="form-text">Acta oficial de la orden.</div>
                        @error('file')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        
                    </div>
                    <div class="mb-3 col-12">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="checkBox" required>
                            <label class="form-check-label" for="checkBox">He verificado y quiero ingresar una nueva acta.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Registar acta</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
