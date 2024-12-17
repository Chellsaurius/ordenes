<div class="modal fade" id="subContentDocument{{ $content->content_number }}_{{ $subcontent->subcontent_number }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Subpunto: {{ $content->content_number.'.'.$subcontent->subcontent_number }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($subcontent->subcontent_document != null)
                    <div class="text-uppercase">Abrir documento: {{ $subcontent->subcontent_description }}</div> 
                    <br>
                    <a target="_blank" href="{{ asset('storage/subcontent/'.$subcontent->subcontent_document) }}">{{ $subcontent->subcontent_document }}</a> <br><br>
                    <br>
                    @if ((Auth::user()->rol_id == 5 && $content->ROrdContent->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                        <a href="{{ route('subcontent.deleteDocument', $subcontent->subcontent_id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea deshabilitar este documento?')">Deshabilitar</a>
                    @endif
                @else
                    @if ((Auth::user()->rol_id == 5 && $content->ROrdContent->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                        <form action="{{ route('subcontent.saveDocument') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 col-12 ">
                                <input type="hidden" name="id" value="{{ $subcontent->subcontent_id }}">
                                <label for="name" class="form-label text-uppercase">Documento del subpunto: {{ $subcontent->subcontent_description }}</label>
                                <input type="file" name="file" class="form-control text-uppercase" aria-describedby="nameHelp">
                                <div id="nameHelp" class="form-text">Documentación del subpunto.</div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <div class="mb-3 col-12">
                                    <br>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="checkBox{{ $subcontent->subcontent_id }}" required>
                                        <label class="form-check-label" for="checkBox{{ $subcontent->subcontent_id }}">El documento es correcto.</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Subir documento</button>
                                </div>
                            </div>
                        </form>
                    @endif
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>
