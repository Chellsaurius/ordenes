<div class="modal fade" id="addContent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Añadir punto principal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('content.newContent') }}" method="post">
                    @csrf
                    <div class="mb-3 col-12 ">
                        <label for="place" class="form-label">Posición relativa</label>
                        <select name="place" class="form-control text-uppercase" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Antes</option>
                            <option value="2">Después</option>
                        </select>
                        @error('place')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>  
                    <div class="mb-3 col-12 ">
                        <label for="id" class="form-label">Punto de pivote</label>
                        <select name="id" class="form-control text-uppercase" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($contents as $content)
                                <option value="{{ $content->content_id}}">{{ $content->content_number }}.- {{ Str::limit($content->content_description, 40 ) }}</option>
                            @endforeach
                        </select>
                        @error('id')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>  
                    
                    <div class="mb-3 col-12">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="checkBoxContent" required>
                            <label class="form-check-label" for="checkBoxContent">He verificado y quiero ingresar un nuevo punto principal.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Registar punto</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
    
</div>
