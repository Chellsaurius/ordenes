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
                    @if ($comision->comision_status == 2)
                        <div class="card-header text-uppercase">Error</div>
                        <div class="card-body">
                            Error
                        </div>
                        
                    @else
                        <div class="card-header text-uppercase">Detalles de la comisión: {{ $comision->comision_name }}</div>

                        <div class="card-body">
                            @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewPartyM">
                                        Añadir nuevo integrante
                                    </a>
                                    @include('comisions.modals.addParticipant')
                                </div>
                            @endif
                            <br>
                            <table class="table table-striped dt-responsive table-bordered nowrap" id="comisiones"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            Integrantes
                                        </th>
                                        <th>
                                            Partido
                                        </th>
                                        <th>
                                            Cargo
                                        </th>
                                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                            <th>
                                                Acciones
                                            </th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- @foreach ($comision->RCU as $user)
                                        <tr class="whitespace-nowrap">
                                            <th class="text-uppercase">
                                                {{ $user->name }}
                                            </th>
                                            <th class="text-uppercase">
                                                {{ $user->RPartyUsers->party_name }}
                                            </th>
                                            <th class="text-uppercase">
                                                {{ $user->RUrecordsR }}
                                                {{-- {{ $user->RUrecords->RPosRecords->position }} 
                                            </th>
                                            <th>
                                                <a href="#" class="btn btn-outline-success">Cambiar puesto</a>
                                                <a href="#" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea dar de baja esta comisión?')">Eliminar</a>
                                            </th>
                                        </tr>
                                    @endforeach --}}
                                    @foreach ($comision->RComRecords as $relationship)
                                        <tr class="whitespace-nowrap">
                                            <th class="text-uppercase"> 
                                                {{-- {{ $relationship }} --}}
                                                {{ $relationship->RUserRecords->name }}
                                            </th>
                                            <th class="text-uppercase">
                                                {{ $relationship->RUserRecords->RPartyUsers->party_name }}
                                            </th>
                                            <th class="text-uppercase">
                                                {{ $relationship->RPosRecords->position }}
                                                {{-- {{ $user->RUrecords->RPosRecords->position }} --}}
                                            </th>
                                            @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                                <th>
                                                    <a class="btn btn-outline-success" data-bs-toggle="modal"
                                                        data-bs-target="#changeUserPositionM{{ $relationship->RUserRecords->id }}">Cambiar
                                                        puesto</a>
                                                    <a href="{{ route('comision.disableMember', $relationship->record_id) }}" class="btn btn-outline-danger"
                                                        onclick="return confirm('¿Seguro que desea dar de baja a este integrante?')">Deshabilitar</a>
                                                </th>
                                            @endif
                                        </tr>
                                        @include('comisions.modals.changeUserPositionM')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
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
