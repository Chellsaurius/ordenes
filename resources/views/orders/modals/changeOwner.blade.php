<div class="modal fade" id="changeOwner{{ $order->order_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambio de encargado de la orden</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order.changeOwner') }}" method="post">
                    @csrf
                    <input type="hidden" name="order" value="{{ $order->order_id }}">
                    <label for="belongsTo" class="form-label">Nuevo encargado </label>
                    <select name="belongsTo" id="belongsTo" class="form-control text-uppercase" aria-describedby="belongsToHelp" onchange="showComisions()" required>
                        <option value="{{ $order->RUserOrders->id }}" disabled selected>{{ $order->RUserOrders->name }} (actual)</option>
                        @foreach ($admins as $admin)
                            @if ($order->order_createdBy != $admin->id)
                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                            @endif
                        @endforeach
                        
                    </select>
                    @error('belongsTo')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <div class="mb-3 col-12">
                        <br>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="checkBox" required>
                            <label class="form-check-label" for="checkBox">He verificado el dato y es correcto.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Cambiar encargado</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>