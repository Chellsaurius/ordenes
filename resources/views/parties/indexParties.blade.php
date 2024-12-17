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
        <div style="backgroundColor: '#e3342f',
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
                    <div class="card-header">Lista de partidos</div>
    
                    <div class="card-body">
                        <div class="d-flex justify-content-end" >
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewPartyM">
                                Añadir partido
                            </button>
                            @include('parties.modals.addPartyM')

                        </div>
                        <br>
                        <table id="partidos" class="table table-striped table-bordered nowrap dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>Acrónimo</th>
                                    <th>
                                        Color
                                    </th>
                                    <th>
                                        Icono
                                    </th>
                                    <th>
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parties as $party)
                                    <tr >
                                        <td class="text-uppercase " >
                                            {{ $party->party_name }}
                                        </td>
                                        <td class="text-uppercase">{{ $party->party_acronim }}</td>
                                        <td class="text-uppercase" >
                                            <div class="btn btn-lg" style="background-color: {{ $party->party_colour }}; --bs-btn-padding-y: 1rem; --bs-btn-padding-x: 2.5rem; --bs-btn-font-size: .75rem;">
                                                
                                            </div>
                                        </td>
                                        <td class="" >
                                            <img src="{{ asset('storage/icons/'.$party->party_icon) }}" alt="" title="" style="heigh:50px;width:50px"/>
                                        </td>
                                        <td class="" >
                                            <a class="btn btn-outline-success"data-bs-toggle="modal" data-bs-target="#editPartyM{{ $party->party_id }}">Editar</a>
                                            <a href="{{ route('party.disableParty', $party->party_id) }}" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea dar de baja este partido?')">Deshabilitar</a>
                                        </td>
                                    </tr>
                                    @include('parties.modals.editPartyM')
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
        <script>
            $(document).ready(function() {
                $('#partidos').DataTable({
                    responsive:true,
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