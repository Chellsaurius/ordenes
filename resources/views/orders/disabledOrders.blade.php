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
                    <div class="card-header">Lista de órdenes dadas de baja</div>
    
                    <div class="card-body">
                        
                        <table id="partidos" class="table table-striped table-bordered nowrap dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Asunto
                                    </th>
                                    <th>
                                        Pertenece
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                        <th>
                                            Acciones
                                        </th>
                                    @endif
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <th class="text-uppercase">{{ $order->order_subject }}</th>
                                    <th class="text-uppercase">{{ $order->comision_name }}</th>
                                    <th>{{ date_format(date_create($order->order_date), 'd-m-Y') }}</th>
                                    @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                        <th>
                                            <a href="{{ route('content.index', $order->order_id) }}" class="btn btn-outline-success">Ir a detalles</a> 
                                            <a href="{{ route('order.enable', $order->order_id) }}" class="btn btn-outline-success" onclick="return confirm('¿Seguro que desea dar de alta esta órden?')">Dar de alta</a>
                                        </th>
                                    @endif
                                </tr>
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
                    columnDefs: [
                        {
                            type: 'html-num',
                            targets: 0, // Replace 0 with the index of your column
                        },
                    ],
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