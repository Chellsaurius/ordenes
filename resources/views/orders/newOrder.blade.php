@extends('layouts.carcasa')
    
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="backgroundColor: '#e3342f',color: '#fff','&:hover': {backgroundColor: '#cc1f1a'}">
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
                    <div class="card-header">Nueva de orden</div>
    
                    <div class="card-body">
                        <form action="{{ route('order.save') }}" method="post" enctype="multipart/form-data" class="row">
                            @csrf
                            <div class="mb-3 col-9 ">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="subject" class="form-control text-uppercase" placeholder="Ingrese aquí el asunto de la órden" aria-describedby="subjectHelp" required>
                                <div id="subjectHelp" class="form-text">Asunto oficial de la orden.</div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-3">
                                <label for="date" class="form-label">Fecha de la orden</label>
                                <input type="datetime-local" name="date" class="form-control text-uppercase" aria-describedby="dateHelp" 
                                    max="{{ now()->format('Y') }}-12-31T23:59" required>
                                <div id="dateHelp" class="form-text">Fecha oficial de la orden.</div>
                                @error('date')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-6 ">
                                <label for="archivo" class="form-label">Documento de la orden</label>
                                <input type="file" name="orderFile" class="form-control text-uppercase" aria-describedby="fileHelp" >
                                <div id="oFileHelp" class="form-text">Documento oficial de la orden.</div>
                                @error('file')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-4 ">
                                <label for="belongsTo" class="form-label">Pertenece a</label>
                                <select name="belongsTo" id="belongsTo" class="form-control" aria-describedby="belongsToHelp" onchange="showComisions()" required>
                                    <option value="" disabled selected>Seleccione a quién pertenece</option>
                                    <option value="1" class="text-uppercase">Comisión</option>
                                    <option value="2" class="text-uppercase">H Ayuntamiento</option>
                                </select>
                                @error('belongsTo')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                
                            </div>
                            <div class="mb-3 col-8 " id="divComisions" style="display: none;">
                                <label for="comision" class="form-label">Comisión a la que pertenece la orden</label>
                                <select name="comision" id="comision" class="form-control text-uppercase" aria-describedby="comisionHelp" disabled required>
                                    <option  disabled selected>Seleccione una comisión</option>
                                    @foreach ($comisions as $comision)
                                        <option value="{{ $comision->comision_id }}" class="text-uppercase">{{ $comision->comision_name }}</option>
                                    @endforeach
                                </select>
                                @error('comision')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-8 " id="divTypes" style="display: none;">
                                <label for="types" class="form-label">Tipo de orden</label>
                                <select name="types" id="types" class="form-control text-uppercase" aria-describedby="typesHelp" disabled required>
                                    <option  disabled selected>Seleccione un tipo</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->type_id }}" class="text-uppercase">{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                                @error('types')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <!-- <script src="{{ asset('js/orders/showdiv.js') }}"></script> -->
                            @include('orders.showdiv')

                            <br>
                            <br>

                            <div class="mb-3 col-12 pt-3">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBox" required>
                                    <label class="form-check-label" for="checkBox">He verificado y quiero ingresar un nueva orden.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar orden</button>
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