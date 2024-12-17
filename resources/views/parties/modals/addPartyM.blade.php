<div class="modal fade" id="addNewPartyM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Datos del nuevo partido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('party.new') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-start row ">
                        <div class="mb-3 col-12 border">
                            <label for="name" class="form-label">Nombre del partido</label>
                            <input type="text" name="name" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp" required>
                            <div id="nameHelp" class="form-text">Nombre completo del nuevo partido.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-4 border">
                            <label for="name" class="form-label">Acrónimo del partido</label>
                            <input type="text" name="acronym" class="form-control text-uppercase"maxlength="255" aria-describedby="nameHelp" placeholder="PAN" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-8 border">
                            <label for="name" class="form-label">Color del partido</label>
                            <input type="text" name="colour" class="form-control text-uppercase" maxlength="7" aria-describedby="nameHelp" placeholder="#9E3451" required>
                            <div id="nameHelp" class="form-text">Código en hexadecimal.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 border">
                            <label for="name" class="form-label">Icono del partido</label>
                            <input type="file" name="iFile" class="form-control text-uppercase" aria-describedby="nameHelp" required>
                            <div id="nameHelp" class="form-text">Formatos aceptados: jpg, jpeg, png.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkBox" required>
                                <label class="form-check-label" for="checkBox">He verificado los datos y son correctos.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Registar partido</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>