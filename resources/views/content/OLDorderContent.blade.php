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
                    <div class="card-header text-uppercase">Contenido de la orden: "{{ $order->order_subject }}" </div>

                    <div id="description" class="col-12"></div>

                    <div class="card-body">
                        Fecha de la orden: {{ date_format(date_create($order->order_date), 'd-m-Y') }} <br>
                        Documento original: <a target="_blank" href="{{ asset('storage/orders/'.$order->order_document) }}">Descargar</a> <br>
                        Pertenece a: @if ($order->order_belongsTo == 2) 
                                H Ayuntamiento
                            @else
                                {{ $order->RComOrders->comision_name }}
                            @endif
                        <br>
                        <button onclick="location.reload()">Reload Page</button>
                        <br>
                        <br>
                        <table class="table table-striped dt-responsive table-bordered nowrap text-uppercase" id="content" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        # del punto
                                    </th>
                                    <th>
                                        Contenido
                                    </th>
                                    <th>
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contents as $content)
                                    <tr>
                                        <td>
                                            # {{ $content->content_number }}
                                            <input type="hidden" id="number{{ $content->content_id }}" value="{{ $content->content_number }}">
                                        </td>
                                        <td class="text-break word-wrap break-word">
                                            {{ $content->content_description }} 
                                        </td>
                                        {{-- Subpunto: {{ $content->RConSubcontent->content_id }} <br> --}}
                                        <td>
                                            <a href="#" onclick="CUp({{ $content->content_id }})"> <i class="fa-solid fa-arrow-up"></i> </a> &nbsp;&nbsp;
                                            <a href="#" onclick="CDown({{ $content->content_id }})"> <i class="fa-solid fa-arrow-down"></i> </a>
                                            <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#contentDocument{{ $content->content_number }}">Documentos</a>
                                            <a href="#" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea dar de baja este punto?')">Deshabilitar</a>
                                        </td>
                                    </tr>
                                    @foreach ($content->RConSubcontent as $subcontent)
                                        <tr>
                                            <td class="text-end">
                                                # {{ $content->content_number.'.'.$subcontent->subcontent_number }}
                                                <input type="hidden" id="subnumber{{ $content->content_number.'.'.$subcontent->subcontent_number }}" value="{{ $content->content_number.'.'.$subcontent->subcontent_number }}">
                                            </td>
                                            <td>
                                                {{ $subcontent->subcontent_description }} <br>
                                            </td>
                                            <td>
                                                <a href="#" onclick="SCUp({{ $subcontent->subcontent_id }})"> <i class="fa-solid fa-arrow-up"></i> </a> &nbsp;&nbsp;
                                                <a href="#" onclick="SCDown({{ $subcontent->subcontent_id }})"> <i class="fa-solid fa-arrow-down"></i> </a>
                                                
                                                <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#subContentDocument{{ $content->content_number }}_{{ $subcontent->subcontent_number }}">Documentos</a>

                                                <a href="#" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea dar de baja este punto?')">Deshabilitar</a>
                                            </td>
                                        </tr>
                                        
                                        @include('content.modals.subContentDocuments')
                                    @endforeach
                                    @include('content.modals.contentDocuments')
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
                $('#content').DataTable({
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
        <script>
            function CUp(id) {
                var table;
                var number = document.getElementById('number' + id).value;
                console.log("el número es: " + number);
                if (number != '1') {
                    const confirmed = confirm("¿Deseas subir el número del punto?");
                    if (confirmed) {
                        console.log("User confirmed" + id);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/subirPrioridadContenido',
                            method: 'POST',
                            dataType: 'json',
                            data:{
                                "_token": "{{ csrf_token() }}",
                                content_id: id,
                            }
                        }).done(function(contents){
                            console.log(contents)
                            $("#content").DataTable().clear().destroy();
                            table = $("#content").DataTable({
                                language: {
                                    "decimal": "",
                                    "emptyTable": "No hay información",
                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                    "infoPostFix": "",
                                    "thousands": ",",
                                    "lengthMenu": "Mostrar _MENU_ Registros",
                                    "loadingRecords": "Cargando...",
                                    "processing": "Procesando...",
                                    "search": "Buscar:",
                                    "zeroRecords": "Sin resultados encontrados",
                                    "paginate": {
                                        "first": "Primero",
                                        "last": "Ultimo",
                                        "next": "Siguiente",
                                        "previous": "Anterior"
                                    }
                                },
                                data: contents,
                                "columns": [
                                    { data: 'content_number' },
                                    { data: 'content_description'},
                                    { data: 'content_id',
                                        render: function (data, type, row) { 
                                            return '<td> <a href="#" onclick="SCUp(' + row.content_id + ')"> <i class="fa-solid fa-arrow-up"></i> </a> &nbsp;&nbsp; ' + 
                                                '<a href="#" onclick="SCDown(' + row.content_id + ')"> <i class="fa-solid fa-arrow-down"></i> </a>' + 
                                                '<a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#subContentDocument' + row.content_id + '">Documentos</a>' + 
                                                '<a href="#" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea dar de baja este punto?')">Deshabilitar</a>' + 
                                                '</td>' }
                                    }
                                ]
                            })
                        })
                    } else {
                        // Do something if user cancels
                        console.log("User cancelled" + id);
                    }
                } else {
                    alert("El punto no puede subir ya que es el número uno.");
                }
                
            }
        </script>
        <script>
            function CDown(id) {
                var number = document.getElementById('number' + id).value;
                number = parseInt(number);
                var nextNumber = id + 1;
                console.log(id);
                console.log(number);
                console.log(nextNumber);
                console.log($('#number' + id).val());
                console.log($('#number' + nextNumber).val());
                if ($('#number' + nextNumber).val()) {
                    const confirmed = confirm("¿Deseas bajar el número del punto?");
                    if (confirmed) {
                        // Do something if user confirms
                        console.log("User confirmed" + id);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/bajarPrioridadContenido',
                            method: 'POST',
                            dataType: 'json',
                            data:{
                                "_token": "{{ csrf_token() }}",
                                content_id: id,
                            }
                        }).done(function(content){
                            console.log(content)
                            
                        })
                    } else {
                        // Do something if user cancels
                        console.log("User cancelled" + id);
                    }
                    console.log(nextNumber);
                } else {
                    alert("El punto no puede bajar ya que es el último número.")
                }
            }
        </script>
        <script>
            function SCUp(id) {
                const confirmed = confirm("¿Deseas subir el número del punto?");
                if (confirmed) {
                    // Do something if user confirms
                    console.log("User confirmed" + id);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/subirPrioridadSubcontenido',
                        method: 'POST',
                        dataType: 'json',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            subcontent_id: id,
                        }
                    }).done(function(subcontent){
                        console.log(subcontent)
                        
                    })
                } else {
                    // Do something if user cancels
                    console.log("User cancelled" + id);
                }
            }
        </script>
        <script>
            function SCDown(id) {
                const confirmed = confirm("¿Deseas subir el número del punto?");
                if (confirmed) {
                    // Do something if user confirms
                    console.log("User confirmed" + id);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/bajarPrioridadSubcontenido',
                        method: 'POST',
                        dataType: 'json',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            subcontent_id: id,
                        }
                    }).done(function(subcontent){
                        console.log(subcontent)
                        
                    })
                } else {
                    // Do something if user cancels
                    console.log("User cancelled" + id);
                }
            }
        </script>
    @endsection
@endsection
