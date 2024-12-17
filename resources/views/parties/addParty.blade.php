@extends('layouts.carcasa')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="backgroundColor: '#e3342f', color: '#fff', '&:hover': { backgroundColor: '#cc1f1a'},">
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
                    <div class="card-header">Añadir nuevo partido</div>

                    <div class="card-body">
                        <form action="{{ route('party.new') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-start row ">
                                <div class="mb-3 col-6 ">
                                    <label for="name" class="form-label">Nombre del partido</label>
                                    <input type="text" name="name" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp" required>
                                    <div id="nameHelp" class="form-text">Nombre completo del nuevo partido.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-4 ">
                                    <label for="name" class="form-label">Acrónimo del partido</label>
                                    <input type="text" name="acronym" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp" placeholder="PAN" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-4 ">
                                    <label for="name" class="form-label">Color del partido</label>
                                    <input type="text" name="colour" class="form-control text-uppercase" maxlength="7" aria-describedby="nameHelp" placeholder="#9E3451" required>
                                    <div id="nameHelp" class="form-text">Código en hexadecimal.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6 ">
                                    <label for="name" class="form-label">Icono del partido</label>
                                    <input type="file" name="iFile" class="form-control text-uppercase" aria-describedby="nameHelp" required>
                                    <div id="nameHelp" class="form-text">Formatos aceptados: jpg, jpeg, png.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <br>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="checkBox" required>
                                        <label class="form-check-label" for="checkBox">He verificado los datos y son correctos.</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Registar partido</button>
                                </div>
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
