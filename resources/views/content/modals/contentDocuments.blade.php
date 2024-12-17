<div class="modal fade" id="contentDocument{{ $content->content_number }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Punto: {{ $content->content_number }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($content->content_document != null )
                <div class="text-uppercase">Abrir documento: {{ $content->content_description }}</div>
                    
                    <br>
                    <a target="_blank" href="{{ asset('storage/content/'.$content->content_document) }}">{{ $content->content_document }}</a> <br><br>
                    <br>
                    @if ((Auth::user()->rol_id == 5 && $content->ROrdContent->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                        <a href="{{ route('content.deleteDocument', $content->content_id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea deshabilitar este documento?')">Deshabilitar</a>
                    @endif
                @else
                    @if ((Auth::user()->rol_id == 5 && $content->ROrdContent->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                        <form action="{{ route('content.saveDocument') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 col-12 ">
                                <input type="hidden" name="id" value="{{ $content->content_id }}">
                                <label for="name" class="form-label text-uppercase">Documento del punto: {{ $content->content_description }}</label>
                                <input type="file" name="file" class="form-control text-uppercase" aria-describedby="nameHelp">
                                <div id="nameHelp" class="form-text">Documentación del punto.</div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <div class="mb-3 col-12">
                                    <br>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="checkBox{{ $content->content_number }}" required>
                                        <label class="form-check-label" for="checkBox{{ $content->content_number }}">El documento es correcto.</label>
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
