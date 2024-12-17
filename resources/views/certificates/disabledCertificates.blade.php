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
                    <div class="card-header">Lista de actas dadas de baja</div>
    
                    <div class="card-body">
                        
                        <br>
                        <table class="table table-striped table-bordered nowrap table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Orden del acta
                                    </th>
                                    
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Administración
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($certificates as $certificate)
                                    <tr class="whitespace-nowrap">
                                        <td class="text-uppercase ">
                                            {{ date_format(date_create($certificate->certificate_date), 'd-m-Y') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('content.IRIndex', $certificate->RCerOrder->order_id) }}" class="btn btn-outline-primary ">Ir a la orden</a>
                                            
                                            
                                        </td>
                                        <td class=" text-center" >
                                            
                                            <a href="{{ route('certificates.enable', $certificate->certificate_id) }}" class="btn btn-outline-success" onclick="return confirm('¿Seguro que desea dar de alta esta acta?')">Desactivar</a>
                                            
                                        </td>
                                        <td >
                                            {{ $certificate->certificate_administration }}
                                        </td>
                                    </tr>
                                    @include('certificates.modals.editCertificate')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
        <script>
            $(document).ready(function() {
                $('#usuarios').DataTable({
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
            
        </script> --}}
    @endsection
@endsection