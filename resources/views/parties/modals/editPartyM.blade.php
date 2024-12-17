<div class="modal fade" id="editPartyM{{ $party->party_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Actualizar datos del partido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('party.updateParty', $party->party_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-start row ">
                        <div class="mb-3 col-12 border">
                            <label for="name" class="form-label">Nombre del partido</label>
                            <input type="text" name="name" class="form-control text-uppercase" value="{{ $party->party_name }}" maxlength="255" aria-describedby="nameHelp" >
                            <div id="nameHelp" class="form-text">Nombre completo del nuevo partido.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-4 border">
                            <label for="name" class="form-label">Acrónimo del partido</label>
                            <input type="text" name="acronym" class="form-control text-uppercase" value="{{ $party->party_acronym }}" maxlength="255" aria-describedby="nameHelp" placeholder="PAN" >
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-8 border">
                            <label for="name" class="form-label">Color del partido</label>
                            <input type="text" name="colour" class="form-control text-uppercase" value="{{ $party->party_colour }}" maxlength="7" aria-describedby="nameHelp" placeholder="#9E3451" >
                            <div id="nameHelp" class="form-text">Código en hexadecimal.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 border">
                            <label for="oldFile" class="form-label">Nombre del anterior archivo</label>
                            <input type="text" class="form-control text-uppercase" value="{{ $party->party_icon }}" aria-describedby="oldFileHelp" readonly>
                            <div id="oldFileHelp" class="form-text">Nombre completo del nuevo partido.</div>
                            @error('oldFile')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 border">
                            <label for="name" class="form-label">Icono nuevo del partido</label>
                            <input type="file" name="iFile" class="form-control text-uppercase" aria-describedby="nameHelp" >
                            <div id="nameHelp" class="form-text">Formatos aceptados: jpg, jpeg, png.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkBox{{ $party->party_id }}" required>
                                <label class="form-check-label" for="checkBox{{ $party->party_id }}">He verificado los datos y son correctos.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar datos</button>
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