@extends('layouts.GPcarcasa')
    
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
        <div style="backgroundColor: '#e3342f', color: '#fff', '&:hover': {
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
                    <div class="card-header">Lista de actas</div>

                    <div class="card-body">
                        
                        <div class="d-flex justify-content-end ">
                            <div class="col-4">
                                <div class="input-group ">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
                                    <button class="input-group-text" id="basic-addon2" onclick="busqueda()"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                @include('certificates.js.search')
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th >
                                            Fecha
                                        </th>
                                        <th>
                                            Orden del acta
                                        </th>
                                        <th>
                                            Documentos
                                        </th>
                                        <th>
                                            Administración
                                        </th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach ($certificates as $certificate)
                                    <tr>
                                        <td class="v-align-middle text-nowrap">
                                            {{ date_format(date_create($certificate->certificate_date), 'd-m-Y') }}
                                        </td>
                                        <td class="v-align-middle text-uppercase text-nowrap">
                                            <a href="{{ route('content.GPindex', $certificate->order_id) }}" 
                                                class="btn btn-outline-primary text-uppercase">{{ $certificate->order_subject }}</a>
                                            
                                        </td>
                                        <td class="v-align-middle text-nowrap">
                                            <a target="_blank" class="btn btn-outline-success" 
                                                    href="{{ asset('storage/certificates/'.$certificate->certificate_document) }}">
                                                    Descargar</a>
                                                
                                        </td>
                                        <td class="v-align-middle text-nowrap">
                                            {{ $certificate->certificate_administration }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $certificates->links()}}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
    
    @endsection
@endsection