<div class="modal fade" id="orderDocument{{ $order->order_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Asunto: {{ $order->order_subject }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($order->order_document != null)
                <div class="text-uppercase">Abrir documento: </div>
                    
                    <br>
                    <a target="_blank" href="{{ asset('storage/orders/'.$order->order_document) }}">{{ $order->order_document }}</a> <br><br>
                    <br>
                    @if ((Auth::user()->rol_id == 5 && $order->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                        <a href="{{ route('order.deleteDocument', $order->order_id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea deshabilitar este documento?')">Deshabilitar</a>
                    @endif
                @else
                    @if ((Auth::user()->rol_id == 5 && $order->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                        <form action="{{ route('order.uploadDocument') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 col-12 ">
                                <input type="hidden" name="id" value="{{ $order->order_id }}">
                                <label for="file" class="form-label text-uppercase">Documento: </label>
                                <input type="file" name="contentFile" id="contentFile" class="form-control" aria-describedby="fileHelp">
                                <div id="fileHelp" class="form-text">Documentación de la orden.</div>
                                @error('file')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <div class="mb-3 col-12">
                                    <br>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="checkBox{{ $order->order_id }}" required>
                                        <label class="form-check-label" for="checkBox{{ $order->order_id }}">El documento es correcto.</label>
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
