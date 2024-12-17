<div class="modal fade" id="GPsubContentDocument{{ $content->content_number }}_{{ $subcontent->subcontent_number }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>
