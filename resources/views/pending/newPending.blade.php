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
                    <div class="card-header">Añadir nuevo pendiente</div>

                    <div class="card-body">
                        <form action="{{ route('pending.saveNew') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3 col-12 ">
                                <label for="description" class="form-label">Contenido</label>
                                <input type="text" name="description" class="form-control text-uppercase" 
                                {{-- autocomplete="off" --}}
                                    aria-describedby="descriptionHelp" required>
                                <div id="descriptionHelp" class="form-text">Descripción precisa del asunto.</div>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div> 
                            
                            <div class="col-6 mb-3 p-3  border-start-1">
                                <label for="archivo" class="form-label">Documento del punto</label>
                                <input type="file" name="file" class="form-control text-uppercase" aria-describedby="fileHelp">
                                <div id="fileHelp" class="form-text">Documento oficial del punto.</div>
                                @error('file')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div id="subcontent" class="col-12"></div>
                            <div class="mb-3 col-12">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBoxContent" required>
                                    <label class="form-check-label" for="checkBoxContent">He verificado y quiero ingresar un nuevo punto principal.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar punto</button>
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

