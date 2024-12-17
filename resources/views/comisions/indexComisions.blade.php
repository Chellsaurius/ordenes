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
                    <div class="card-header">Lista de comisiones</div>

                    <div class="card-body">
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="{{ route('comision.new') }}">
                                    Nueva comisión
                                </a>
                                
                            </div>
                        @endif
                        <br>
                        <table class="table table-striped dt-responsive table-bordered" id="comisiones" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre de la comisión
                                    </th>
                                    
                                    <th>
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($comisions as $comision)
                                    <tr class="whitespace-nowrap">
                                        <th class="text-uppercase">
                                            {{ $comision->comision_name }}
                                        </th>
                                        <th>
                                            <a href="{{ route('comision.details', $comision->comision_id) }}" class="btn btn-outline-success">Participantes</a>
                                            @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                                <a data-bs-toggle="modal" data-bs-target="#editComision{{ $comision->comision_id }}" class="btn btn-outline-success">Editar</a>
                                                <a href="{{ route('comision.disableComision', $comision->comision_id) }}" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea dar de baja esta comisión?')">Deshabilitar</a>
                                            @endif
                                        </th>
                                    </tr>
                                    @include('comisions.modals.editComision')
                                @endforeach
                                
                            </tbody>
                            <div class="d-flex justify-content-center">
                            </div>
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
                $('#comisiones').DataTable({
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
