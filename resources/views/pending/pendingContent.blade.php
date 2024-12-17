@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

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
                    <div class="card-header text-uppercase">Lista de puntos pendientes </div>

                    <div id="description" class="col-12"></div>

                    <div class="card-body">
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('pending.newPending') }}" class="btn btn-primary">
                                    Añadir pendiente
                                </a>

                            </div>
                        @endif
                        <br>
                        <table class="table table-striped dt-responsive table-bordered " id="pending" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Descripción
                                    </th>
                                    <th>
                                        Documento
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                        <th>
                                            Acciones
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendings as $pending)
                                    <tr>
                                        <td class="text-uppercase">
                                            {{ $pending->pending_description }}
                                            
                                        </td>
                                        <td>
                                            @if ($pending->pending_document)
                                                <a target="_blank" class="btn btn-outline-success" 
                                                    href="{{ asset('storage/pending/'.$pending->pending_document) }}">
                                                    Abrir</a>
                                            @else 
                                                Sin documento
                                            @endif
                                            
                                        </td>
                                        <td>
                                            {{ $pending->RStanPending->standing_name }}
                                            
                                        </td>
                                        @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                            <td>
                                                @if ($pending->standing_id == 1)
                                                    <button class="btn btn-outline-success btn-sm text-uppercase" data-bs-toggle="modal" 
                                                    data-bs-target="#loadPending{{ $pending->pending_id }}" onclick="load({{ $pending->pending_id }})">
                                                        Cargar</button>
                                                    @include('pending.js.load')
                                                    @include('pending.modals.loadPendingContent')
                                                @endif
                                                
                                                <button type="button" class="btn btn-outline-success btn-sm text-uppercase" data-bs-toggle="modal" 
                                                    data-bs-target="#editPending{{ $pending->pending_id }}">
                                                    Editar
                                                </button>
                                                <a href="{{ route('pending.disable', $pending->pending_id) }}" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('¿Seguro que desea dar de baja este punto?')">Deshabilitar</a>
                                            </td>
                                        @endif
                                    </tr>

                                    @include('pending.modals.editPendingContent')
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#pending').DataTable({
                    responsive: true,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },

                });
            });
        </script>
    @endsection
@endsection
