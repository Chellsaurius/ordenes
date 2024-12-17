<div class="modal fade" id="GPcontentDocument{{ $content->content_number }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>
