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
                    <div class="card-header">Registro de una nueva acta</div>

                    <div class="card-body">
                        <form action=" {{ route('certificates.saveNew') }}" method="post" class="row" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 col-3 ">
                                <label for="administration" class="form-label">Administración</label>
                                <input type="text" name="administration" class="form-control text-uppercase" maxlength="255" placeholder="Administración en la que se dio la sesión" required>
                                @error('administration')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-6 ">
                                <label for="order" class="form-label">Pertenece a la orden</label>
                                <select name="order" id="order" class="form-control text-uppercase" aria-describedby="typesHelp" required>
                                    <option  disabled selected>Seleccione un tipo</option>
                                    @foreach ($orders as $order)
                                        <option value="{{ $order->order_id }}" class="text-uppercase">{{ $order->order_subject }}</option>
                                    @endforeach
                                </select>
                                @error('types')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-3">
                                <label for="date" class="form-label">Fecha del acta</label>
                                <input type="date" name="date" class="form-control text-uppercase" aria-describedby="dateHelp" required>
                                <div id="dateHelp" class="form-text">Fecha oficial del acta.</div>
                                @error('date')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-6 ">
                                <label for="file" class="form-label text-uppercase">Documento: </label>
                                <input type="file" name="file" class="form-control" aria-describedby="fileHelp">
                                <div id="fileHelp" class="form-text">Acta oficial de la orden.</div>
                                @error('file')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                
                            </div>
                            <div class="mb-3 col-12">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBox" required>
                                    <label class="form-check-label" for="checkBox">He verificado y quiero ingresar una nueva acta.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar acta</button>
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

