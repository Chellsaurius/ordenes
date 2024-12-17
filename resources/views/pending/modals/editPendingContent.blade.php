<div class="modal fade" id="editPending{{ $pending->pending_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Datos del punto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pending.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 col-12 ">
                        <input type="hidden" name="id" value="{{ $pending->pending_id }}">
                        <label for="description" class="form-label">
                            Contenido del punto: </label>
                        
                        <textarea rows="4"  name="description" class="form-control text-uppercase" style="resize: none"
                            aria-describedby="descriptionHelp" autofocus required>{{ $pending->pending_description }}</textarea>
                        <div id="descriptionHelp" class="form-text">Contenido del punto.</div>
                        @error('description')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <div class="col-8 mb-3 p-3  border-start-1">
                            <label for="archivo" class="form-label">Documento del punto</label>
                            <input type="file" name="file" class="form-control text-uppercase" aria-describedby="fileHelp">
                            <div id="fileHelp" class="form-text">Documento oficial del punto.</div>
                            @error('file')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        @if ($pending->standing_id == 2)
                            <hr>
                            <div class="mb-3 col-12" >
                                <label for="status" class="form-label">Estatus</label>
                                <select name="status" class="form-control" value="{{ $pending->standing_id }}" 
                                        aria-placeholder="status" required>
                                        <option value="" disabled selected>Seleccione un estatus</option>
                                        @foreach ($standings as $standing)
                                            <option value="{{ $standing->standing_id }}">{{ $standing->standing_name }}</option>
                                            
                                        @endforeach
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-12" >
                                <label for="standing" class="form-label">Detalles del estatus</label>
                                <input type="text" name="standing" class="form-control text-uppercase" aria-describedby="standingHelp">
                                <div id="standingHelp" class="form-text">Ejemplo: 10 votos a favor y 5 en contra.</div>
                            </div>
                            <hr>
                        @endif
                        
                        <div id="subcontent" class="col-12"></div>
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="pendingCheckBox{{ $pending->pending_id }}" required>
                                <label class="form-check-label" for="pendingCheckBox{{ $pending->pending_id }}">Los datos son correctos.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualziar punto</button>
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
