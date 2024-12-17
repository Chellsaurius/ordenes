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
                    <div class="card-header">Lista de órdenes</div>
    
                    <div class="card-body">
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('order.new') }}" class="btn btn-primary">
                                    Añadir orden
                                </a>

                            </div>
                        @endif
                        <br>
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
                                        Fecha y hora
                                    </th>
                                    
                                    <th>
                                        Acciones
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                        
                                    <tr>
                                        <th class="text-uppercase">{{ $order->order_subject }}</th>
                                        <th class="text-uppercase" id="comision_name{{ $order->order_id }}" >
                                            @if ($order->comision_id == 1)
                                                {{ $order->RComOrders->comision_name  }} ({{ $order->RTypesOrders->type_name }})
                                            @else
                                                {{ $order->RComOrders->comision_name  }} 
                                            @endif
                                            
                                        </th>
                                        <th>{{ date_format(date_create($order->order_date), 'd-m-Y, H:i' ) }} </th>
                                        
                                        <th>
                                            <a href="{{ route('content.IRIndex', $order->order_id) }}" class="btn btn-outline-success">Ir a detalles</a> 
                                            
                                        </th>
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
                    order: [[2, 'desc'], [ 0, 'asc' ]],
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