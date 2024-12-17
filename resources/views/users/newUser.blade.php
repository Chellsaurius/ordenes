@extends('layouts.carcasa')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registro de un nuevo usuario</div>

                    <div class="card-body">
                        <form action=" {{ route('user.save') }}" method="post" class="row">
                            @csrf
                            <div class="mb-3 col-6 ">
                                <label for="name" class="form-label">Nombre y apellidos</label>
                                <input type="text" name="name" class="form-control text-uppercase" maxlength="255" placeholder="Ingrese aquí el nombre completo" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="email" class="form-label">Dirección de correo electrónico</label>
                                <input type="email" name="email" class="form-control text-uppercase" maxlength="255" placeholder="MARIO.LOPEZ@SALAMANCA.GOB.MX" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div> 
                            <div class="mb-3 col-4 ">
                                <label for="party" class="form-label">Partido</label>
                                <select name="party" class="form-control text-uppercase" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    @foreach ($parties as $party)
                                        <option value="{{ $party->party_id}}" class="text-uppercase">{{ $party->party_name }}</option>
                                    @endforeach
                                </select>
                                @error('party')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>  
                            
                            <div class="mb-3 col-4 ">
                                <label for="rol" class="form-label">Cargo</label>
                                <select name="rol" class="form-control" required>
                                    <option selected disabled>Seleccione una opción</option>
                                    @foreach ($rols as $rol)
                                        <option value="{{ $rol->rol_id}}">{{ $rol->rol }}</option>
                                    @endforeach
                                </select>
                                @error('rol')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div> 
                            
                            
                            <div class="mb-3 col-12">
                                <div class="mb-3 col-4">
                                    <label for="password" class="form-label">Contraseña (mínimo seis caracteres)</label>
                                    <input type="password" name="password" class="form-control" placeholder="•••••••••" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div> 
                                <div class="mb-3 col-4">
                                    <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="•••••••••" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div> 
                            </div>
                            <div class="mb-3 col-12">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBox" required>
                                    <label class="form-check-label" for="checkBox">He verificado y quiero ingresar un nuevo usuario.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    @endsection
@endsection

