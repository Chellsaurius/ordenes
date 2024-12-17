<div class="modal fade" id="editContent{{ $content->content_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Punto: {{ $content->content_number }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('content.updateDescription') }}" method="post" >
                    @csrf
                    <div class="mb-3 col-12 ">
                        <input type="hidden" name="id" value="{{ $content->content_id }}">
                        <label for="description" class="form-label text-uppercase">
                            Contenido del punto: </label>
                        
                        <textarea rows="4"  name="description" class="form-control text-uppercase" 
                        aria-describedby="descriptionHelp" autofocus required>{{ $content->content_description }}</textarea>
                        <div id="descriptionHelp" class="form-text">Contenido del punto.</div>
                        @error('description')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="contentCheckBox{{ $content->content_id }}" required>
                                <label class="form-check-label" for="contentCheckBox{{ $content->content_id }}">La descripción es correcta.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar descripción</button>
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
