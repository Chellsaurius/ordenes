<div class="modal fade" id="editSubcontent{{ $subcontent->subcontent_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Subpunto: {{ $content->content_number.'.'.$subcontent->subcontent_number }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subcontent.updateDescription') }}" method="post" >
                    @csrf
                    <div class="mb-3 col-12 ">
                        <input type="hidden" name="id" value="{{ $subcontent->subcontent_id }}">
                        <label for="description" class="form-label text-uppercase">
                            Contenido del subpunto: </label>
                        <textarea rows="3"  name="description" class="form-control text-uppercase" 
                            aria-describedby="descriptionHelp" autofocus required>{{ $subcontent->subcontent_description }}</textarea>
                        
                        <div id="descriptionHelp" class="form-text">Contenido del subpunto.</div>
                        @error('description')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="subcontentCheckBox{{ $subcontent->subcontent_id }}" required>
                                <label class="form-check-label" for="subcontentCheckBox{{ $subcontent->subcontent_id }}">La descripción es correcta.</label>
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
