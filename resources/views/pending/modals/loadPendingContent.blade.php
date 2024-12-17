<div class="modal fade" id="loadPending{{ $pending->pending_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">Datos del punto: {{ $pending->pending_description }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pending.loadPending') }}" method="post" >
                    @csrf
                    <div class="mb-3 col-12 ">
                        <input type="hidden" name="id" value="{{ $pending->pending_id }}">

                        <div class="mb-3 col-12 ">
                            <label for="order" class="form-label">Órdenes del día en estado de preparación.</label>
                            <select name="order" id="order{{ $pending->pending_id }}" class="form-control text-uppercase" 
                                aria-describedby="typesHelp" onchange="content({{ $pending->pending_id }})" required>
                                <option value="" id="order_id{{ $pending->pending_id }}" 
                                    disabled selected>Seleccione una orden</option>
                                
                            </select>
                            <div id="orderHelp" class="form-text">Elija la orden del día.</div>
                            @error('order')
                                <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 " id="contents{{ $pending->pending_id }}" style="display:none">
                            <label for="content" class="form-label">Especifique el punto previo a añadir de la orden del día. </label>
                            <select name="contents" id="content{{ $pending->pending_id }}" class="form-control text-uppercase" 
                                aria-describedby="typesHelp" required>
                                <option value="" id="content_id{{ $pending->pending_id }}" 
                                    disabled selected>Seleccione una orden</option>
                                
                            </select>
                            <div id="contentHelp" class="form-text">Seleccione un punto (se renumerará la numeración después del punto seleccionado).</div>
                            {{-- <div id="contentHelp" class="form-text">Seleccione el contenido previo al punto que se va a añadir.</div>
                            <div id="contentHelp" class="form-text">Seleccione el contenido previo al punto a añadir.</div>
                            <div id="contentHelp" class="form-text">Seleccione el contenido previo al punto a agregar.</div> --}}
                            @error('content')
                                <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        @include('pending.js.loadContent')
                        <div class="mb-3 col-12">
                            <br>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="contentCheckBox{{ $pending->pending_id }}"
                                    required>
                                <label class="form-check-label" for="contentCheckBox{{ $pending->pending_id }}">Los datos son correctos.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Cargar punto</button>
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
