<div class="modal fade" id="editOrder{{ $order->order_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar datos de la orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="order" value="{{ $order->order_id }}">
                    <div class="mb-3 col-12">
                        <label for="name" class="form-label">Asunto de la orden</label>
                        <input type="text" name="name" class="form-control text-uppercase" value="{{ $order->order_subject }}"
                            aria-describedby="nameHelp" required>
                        <div id="nameHelp" class="form-text">Fecha y hora oficial de la orden.</div>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    @if ($order->order_belongsTo == 1)
                        <div class="mb-3 col-12" >
                            <label for="comisions" class="form-label">Comisiones a cambiar</label>
                            <select name="comision" id="comisions{{ $order->order_id }}" class="form-control" value="{{ old('comisions') }}" 
                                    aria-placeholder="comisions" required>
                                    <option disabled selected>Seleccione una comisión</option>
                            </select>
                            @error('comisions')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    @endif
                    
                    <div class="mb-3 col-12">
                        <label for="date" class="form-label">Fecha de la orden</label>
                        <input type="datetime-local" name="date" class="form-control text-uppercase" value="{{ $order->order_date }}"
                            {{-- min="{{ \Carbon\Carbon::now("America/Mexico_city")->format('d-m-Y H:i:s') }}"  --}}
                            max="{{ now()->format('Y') }}-12-31T23:59" aria-describedby="dateHelp" required>
                        <div id="dateHelp" class="form-text">Fecha y hora oficial de la orden.</div>
                        @error('date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <br>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="checkBox{{ $order->order_id }}" required>
                            <label class="form-check-label" for="checkBox{{ $order->order_id }}">He verificado los datos son correctos.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Cambiar fecha y hora</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>