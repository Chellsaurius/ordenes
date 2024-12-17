<div class="modal fade" id="addNewPartyM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Datos del nuevo integrante</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comision.addUser') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-start row ">
                        <input type="hidden" name="comision" value="{{ $comision->comision_id }}">
                        <div class="mb-3 col-12 border">
                            <label for="name" class="form-label">Nombre del nuevo integrante</label>
                            <select name="user" id="user" class="form-control text-uppercase" aria-describedby="userHelp" required>
                                <option value="" selected disabled>Seleccione al integrante</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->RPartyUsers->party_name }})</option>
                                @endforeach
                            </select>
                            <div id="userHelp" class="form-text">Nombre completo del nuevo integrante.</div>
                            @error('user')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-4 border">
                            <label for="name" class="form-label">Puesto del nuevo integrante</label>
                            <select name="position" id="position" class="form-control text-uppercase" aria-describedby="positionHelp" required>
                                <option value="" selected disabled>Seleccione el puesto</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->position_id }}">{{ $position->position }}</option>
                                @endforeach
                            </select>
                            <div id="positionHelp" class="form-text">Cargo del nuevo integrante.</div>
                            @error('position')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkBox" required>
                                <label class="form-check-label" for="checkBox">He verificado los datos y son correctos.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Añadir nuevo integrante</button>
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