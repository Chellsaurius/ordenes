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
                                    @if (Auth::user()->rol_id == 6)
                                        <th>
                                            Encargado
                                        </th>
                                    @endif
                                    <th>
                                        Acciones
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                        
                                    <tr @if (($order->order_createdBy == Auth::user()->id || Auth::user()->rol_id == 6) && $order->order_status == 4)
                                        class="table-danger"
                                    @endif >
                                        <th class="text-uppercase">{{ $order->order_subject }}</th>
                                        <th class="text-uppercase" id="comision_name{{ $order->order_id }}" >
                                            @if ($order->comision_id == 1)
                                                {{ $order->RComOrders->comision_name  }} ({{ $order->RTypesOrders->type_name }})
                                            @else
                                                {{ $order->RComOrders->comision_name  }} 
                                            @endif
                                            
                                        </th>
                                        <th>{{ date_format(date_create($order->order_date), 'd-m-Y, H:i' ) }} </th>
                                        @if (Auth::user()->rol_id == 6)
                                            <th>
                                                <u class="text-uppercase">
                                                    <i>
                                                        {{ $order->RUserOrders->name }}
                                                    </i>
                                                </u>
                                            </th>
                                        @endif
                                        <th>
                                            <a href="{{ route('content.index', $order->order_id) }}" class="btn btn-outline-success">Ir a detalles</a> 
                                            @if((Auth::user()->rol_id == 5 && $order->order_belongsTo == Auth::user()->id) || Auth::user()->rol_id == 6) 
                                                @if ($order->order_status != 4)
                                                    <a href="{{ route('order.disable', $order->order_id) }}" class="btn btn-outline-danger" 
                                                        onclick="return confirm('¿Seguro que desea dar de baja este partido?')">Deshabilitar</a>
                                                @else
                                                    <a href="{{ route('order.enable', $order->order_id) }}" class="btn btn-outline-success" 
                                                        onclick="return confirm('¿Seguro que desea dar de alta esta órden?')">Dar de alta</a>
                                                @endif
                                            @endif
                                            @if ($order->order_belongsTo == Auth::user()->id || Auth::user()->rol_id == 6)
                                                <button type="button" class="btn btn-outline-success" onclick="comisiones({{ $order->order_id }})" 
                                                    data-bs-toggle="modal" data-bs-target="#editOrder{{ $order->order_id }}">
                                                    Editar
                                                </button>
                                                
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changeOwner{{ $order->order_id }}">
                                                    Cambiar encargado
                                                </button>
                                                <script>
                                                    function comisiones(id){
                                                        var id = id;
                                                        var url = 'AJAX/listaDeComisiones';
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax({
                                                            url: url,
                                                            method: 'POST',
                                                            dataType: 'json',
                                                            data:{
                                                                id: id
                                                            }
                                                        }).done(function(data){
                                                            //console.log(data)
                                                            //console.log(id)
                                                            var name = document.getElementById("comision_name" + id).innerText;
                                                            console.log(name)
                                                            name = name.toLowerCase();
                                                            console.log(name)
                                                            var comisions = "";
                                                            for (let index = 0; index < data.length; index++) {
                                                                if (name != data[index].comision_name) {
                                                                    comisions += "<option name='newComision' value='" + data[index].comision_id + "' class='text-uppercase'> " + data[index].comision_name + "</option>";
                                                                } else {
                                                                    comisions += "<option name='newComision' value='' class='text-uppercase' disabled selected> " + data[index].comision_name.toUpperCase() + "</option>";
                                                                }
                                                                
                                                            }
                                                            document.getElementById("comisions" + id).innerHTML = comisions;
                                                        });
                                                    }
                                                </script>
                                                
                                                
                                            @endif
                                            
                                        </th>
                                    </tr>
                                        @include('orders.modals.editOrder')
                                        @include('orders.modals.changeOwner')
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
                    columnDefs: [
                        {
                            type: 'html-num',
                            targets: 0, // Replace 0 with the index of your column
                        },
                    ],
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