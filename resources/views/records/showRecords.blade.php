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
                    <div class="card-header text-uppercase">Historial de la comisión: {{ $records->first()->RComRecords->comision_name }} </div>

                    <div class="card-body">
                        holiwis
                        <table id="comisionRecords" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Estado original
                                    </th>
                                    <th>
                                        Nuevo estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($OComisions as $OComision)
                                    <tr >
                                        <td class="text-uppercase">
                                            @if ($OComision->observed_original)
                                                {{ $OComision->observed_original }}, el: {{ $OComision->updated_at}}
                                            @endif
                                            
                                        </td>
                                        <td class="text-uppercase">
                                            {{ $OComision->observed_movement }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if (!$ORecords->isEmpty())
                            <hr>
                            <table id="comisionRecords" class="table table-striped table-bordered nowrap dt-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            Usuario
                                        </th>
                                        <th>
                                            Estado original
                                        </th>
                                        <th>
                                            Cambios
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ORecords as $ORecord)
                                        <tr >
                                            <td class="text-uppercase">
                                                {{ $ORecord->name ?? ''}}
                                            </td>
                                            <td class="text-uppercase " >
                                                @if ($ORecord->recordO_original)
                                                    {{ $ORecord->recordO_original ?? '' }}
                                                @else
                                                    {{ $ORecord->recordO_disenable ?? '' }}
                                                @endif
                                            </td>
                                            <td class="text-uppercase">
                                                {{ $ORecord->recordO_movement ?? '' }} 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <hr>
                            No tiene historial.
                        @endif
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
                $('#comisionRecords').DataTable({
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
        <script>
            $(document).ready(function() {
                $('#actualRecords').DataTable({
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
