<div class="modal fade" id="changeUserPositionM{{ $relationship->RUserRecords->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Cambiar puesto de: {{ $relationship->RUserRecords->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comision.changePosition') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-start row ">
                        <input type="hidden" name="comision" value="{{ $comision->comision_id }}">
                        <input type="hidden" name="record" value="{{ $relationship->record_id }}">
                        <div class="mb-3 col-12 border">
                            <label for="position" class="form-label">Puesto del integrante</label>
                            <select name="position" id="position" class="form-control text-uppercase" aria-describedby="positionHelp" required>
                                <option value="" selected disabled> {{ $relationship->RPosRecords->position }}</option>
                                @foreach ($positions as $position)
                                    @if ($position->position_id != $relationship->RPosRecords->position_id)
                                        <option value="{{ $position->position_id }}">{{ $position->position }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="positionHelp" class="form-text">Nombre completo del nuevo integrante.</div>
                            @error('position')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkBox{{ $relationship->RUserRecords->id }}" required>
                                <label class="form-check-label" for="checkBox{{ $relationship->RUserRecords->id }}">He verificado los datos y son correctos.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar el puesto del integrante</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>