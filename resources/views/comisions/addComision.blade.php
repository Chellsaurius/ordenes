@extends('layouts.carcasa')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div
            style="backgroundColor: '#e3342f',
    color: '#fff',
    '&:hover': {
        backgroundColor: '#cc1f1a'
    },">
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
                    <div class="card-header">Nueva comisión</div>

                    <div class="card-body">
                        <form action="{{ route('comision.new') }}">
                            @csrf
                            <div class="d-flex justify-content-start row ">
                                <div class="mb-3 col-12 border">
                                    <label for="name" class="form-label">Nombre de la comisión</label>
                                    <input type="text" name="name" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp">
                                    <div id="nameHelp" class="form-text">Nombre completo de la nueva comisión.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-4 border">
                                    <label for="name" class="form-label">Acrónimo del partido</label>
                                    <input type="text" name="acronym" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp" placeholder="PAN">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-8 border">
                                    <label for="name" class="form-label">Color del partido</label>
                                    <input type="text" name="colour" class="form-control text-uppercase" maxlength="7" aria-describedby="nameHelp" placeholder="#9E3451">
                                    <div id="nameHelp" class="form-text">Código en hexadecimal.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12 border">
                                    <label for="name" class="form-label">Icono del partido</label>
                                    <input type="file" name="Ifile" class="form-control text-uppercase" aria-describedby="nameHelp">
                                    <div id="nameHelp" class="form-text">Nombre completo del nuevo partido.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

                
        