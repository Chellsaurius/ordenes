<div class="modal fade" id="editUserM{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Actualizar datos del partido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form action=" {{ route('user.update') }}" method="post" >
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="mb-3 col-12">
                        <label for="name" class="form-label">Nombre y apellidos</label>
                        <input type="text" name="name" class="form-control text-uppercase" value="{{ $user->name }}" maxlength="255" placeholder="Ingrese aquí el nombre completo" >
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12">
                        <label for="email" class="form-label">Dirección de correo electrónico</label>
                        <input type="email" name="email" class="form-control text-uppercase" value="{{ $user->email }}" maxlength="255" placeholder="MARIO.LOPEZ@SALAMANCA.GOB.MX" >
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div> 
                    <div class="mb-3 col-5">
                        <label for="party" class="form-label">Partido</label>
                        <select name="party" class="form-control text-uppercase" >
                            <option value="{{ $user->RPartyUsers->party_name ?? ''}}" selected disabled>{{ $user->RPartyUsers->party_name ?? ''}}</option>
                            @foreach ($parties as $party)
                                @if ($party->party_id != $user->RPartyUsers->party_id)
                                    <option value="{{ $party->party_id}}">{{ $party->party_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('party')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>  
                    
                    <div class="mb-3 col-5">
                        <label for="rol" class="form-label">Cargo</label>
                        <select name="rol" class="form-control" >
                            <option value="{{ $user->RRolUsers->rol }}" selected disabled>{{ $user->RRolUsers->rol }}</option>
                            @foreach ($rols as $rol)
                                @if ($rol->rol_id != $user->RRolUsers->rol_id)
                                    <option value="{{ $rol->rol_id}}">{{ $rol->rol }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('rol')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div> 
                    
                    <div class="mb-3 col-12">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="checkBox{{ $user->id }}" required>
                            <label class="form-check-label" for="checkBox{{ $user->id }}">He verificado y quiero ingresar un nuevo usuario.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Registar usuario</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>