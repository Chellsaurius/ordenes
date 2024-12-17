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
                        <div class="text-uppercase align-middle">
                            Fecha de la orden: {{ date_format(date_create($order->order_date), 'd-m-Y') }} <br>
                            {{-- @if (($order->order_status < 3 && Auth::user()->id == $order->order_createdBy) || Auth::user()->rol_id == 6)
                                @if ($order->order_document)
                                    Documento original: <a target="_blank" class="btn btn-sm btn-secondary"
                                    href="{{ asset('storage/orders/' . $order->order_document) }}">Abrir</a> <br>
                                @else
                                    Cargar documento: <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#orderDocument{{ $order->order_id }}">Documentos</a> <br>
                                    @include('content.modals.orderDocument')
                                @endif
                            @endif --}}
                            
                            @if ($order->order_document)
                                Documento original: <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#orderDocument{{ $order->order_id }}">Documento</a> <br>
                            @else
                                Cargar documento: <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#orderDocument{{ $order->order_id }}">Documento</a> <br>
                                
                            @endif
                            @include('content.modals.orderDocument')
                            Pertenece a: 
                            @if ($order->order_belongsTo == 2)
                                H Ayuntamiento
                            @else
                                {{ $order->RComOrders->comision_name }}
                            @endif
                            
                        </div>
                        <br>
                        {{-- <button onclick="location.reload()">Reload Page</button> --}}
                        @if ((Auth::user()->rol_id == 5 && $order->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6) 
                            <div class="d-flex justify-content-between align-text-bottom">
                                <div class="d-flex  col-9 row">
                                    <form action="{{ route('order.updateStatus') }}" method="post" class="row">
                                        @csrf
                                        <div class="col-6 form-floating mb-3">
                                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                            
                                            <select name="status" id="" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                                <option value="" selected disabled>Abrir opciones</option>
                                                <option value="1" @if ($order->order_status == 1) disabled @endif>En preparación @if ($order->order_status == 1) (Actual)@endif</option>
                                                <option value="2" @if ($order->order_status == 2) disabled @endif>Revisión interna @if ($order->order_status == 2) (Actual)@endif</option>
                                                <option value="3" @if ($order->order_status == 3) disabled @endif>Abierta al público @if ($order->order_status == 3) (Actual)@endif</option>
                                                <option value="4" @if ($order->order_status == 4) disabled @endif>Cancelar @if ($order->order_status == 4) (Actual)@endif</option>
                                                @if (Auth::user()->rol_id == 6)
                                                <option value="5" @if ($order->order_status == 5) disabled @endif>Privada @if ($order->order_status == 5) (Actual)@endif</option>
                                                @endif
                                            </select>
                                            <label for="status" class="form-label">Estado de la orden</label>
                                        </div>
                                        <div class="col-6 ps-1 align-middle">
                                            <button type="submit" class="btn btn-primary col-8 ">Actualizar orden</button>
                                        </div>
                                    </form>
                                    
                                </div>
                                @if ($order->order_status == 1 ||  Auth::user()->rol_id == 6)
                                    <div class="justify-content-end col-3 align-top ">
                                        <a href="{{ route('content.newContent', $order->order_id) }}"
                                            class="btn btn-outline-primary col-8 align-top"> Añadir punto </a> &nbsp;&nbsp;
                                    </div>
                                @endif
                                
                            </div>
                        @endif
                        
                        <br>
                        <br>
                        <table class="table table-striped dt-responsive table-bordered text-uppercase" id="content" style="width:100%">
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
                                            <input type="hidden" id="number{{ $content->content_id }}"
                                                value="{{ $content->content_number }}">
                                        </td>
                                        <td class="text-break word-wrap break-word">
                                            {{ $content->content_description }}
                                        </td>
                                        {{-- Subpunto: {{ $content->RConSubcontent->content_id }} <br> --}}
                                        <td>
                                            @if (($order->order_status != 4 && $content->ROrdContent->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                                                <div class="d-flex justify-content-evenly">
                                                    <a href="#" onclick="CUp({{ $content->content_id }})"> <i
                                                            class="fa-solid fa-arrow-up"></i> </a> &nbsp;&nbsp;
                                                    <a href="#" onclick="CDown({{ $content->content_id }})"> <i
                                                            class="fa-solid fa-arrow-down"></i> </a>
                                                </div>
                                                @if ((Auth::user()->rol_id == 5 && $order->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6 )
                                                    <a href="{{ route('subcontent.newSubcontent', $content->content_id) }}"
                                                        class="btn btn-outline-primary btn-sm"> Añadir subpunto </a>
                                                    <form action="{{ route('content.disable', $content->content_id) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id_content" value="{{ $content->content_id }}">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm text-uppercase"
                                                            onclick="return confirm('¿Seguro que desea dar de baja este punto?')">Deshabilitar</button>
                                                    </form>
                                                @endif
                                            @endif
                                            @if ($content->content_document || $content->ROrdContent->order_createdBy == Auth::user()->id ||  Auth::user()->rol_id == 6)
                                                <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#contentDocument{{ $content->content_number }}">Documentos</a>
                                                <a class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editContent{{ $content->content_id }}">
                                                    Editar contenido</a>
                                                
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach ($content->RConSubcontent as $subcontent)
                                        <tr>
                                            <td class="text-end">
                                                # {{ $content->content_number . '.' . $subcontent->subcontent_number }}
                                                <input type="hidden" id="subnumber{{ $subcontent->subcontent_id }}"
                                                    value="{{ $content->content_number . '.' . $subcontent->subcontent_number }}">
                                            </td>
                                            <td>
                                                {{ $subcontent->subcontent_description }} <br>
                                            </td>
                                            <td class="p-1">
                                                @if (($order->order_status != 4 && $content->ROrdContent->order_createdBy == Auth::user()->id) || Auth::user()->rol_id == 6)
                                                
                                                    <div class="d-flex justify-content-evenly">
                                                        <a onclick="SCUp({{ $subcontent->subcontent_id }})"> <i
                                                                class="fa-solid fa-arrow-up"></i> </a> &nbsp;&nbsp;
                                                        <a onclick="SCDown({{ $subcontent->subcontent_id }})">
                                                            <i class="fa-solid fa-arrow-down"></i> </a>
                                                    </div>
                                                    <form action="{{ route('subcontent.disable', $subcontent->subcontent_id) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-sm text-uppercase"
                                                            onclick="return confirm('¿Seguro que desea dar de baja este subpunto?')">Deshabilitar</button>
                                                    </form>
                                                @endif
                                                @if ($subcontent->subcontent_document || $content->ROrdContent->order_createdBy == Auth::user()->id)
                                                    <a class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#subContentDocument{{ $content->content_number }}_{{ $subcontent->subcontent_number }}">
                                                        Documentos</a>
                                                    <a class="btn btn-outline-success btn-sm" data-bs-toggle="modal" 
                                                        data-bs-target="#editSubcontent{{ $subcontent->subcontent_id }}">
                                                        Editar contenido</a>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        @include('content.modals.subContentDocuments')
                                        @include('content.modals.editSubcontent')
                                    @endforeach
                                    @include('content.modals.contentDocuments')
                                    @include('content.modals.editContent')
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
                            data: {
                                "_token": "{{ csrf_token() }}",
                                content_id: id,
                            }
                        }).done(function(contents) {
                            console.log(contents)
                            location.reload();
                        })
                    } else {
                        // Do something if user cancels
                        console.log("User cancelled" + id);
                    }
                } else {
                    alert("El punto no puede subir ya que es el número uno.")
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
                            data: {
                                "_token": "{{ csrf_token() }}",
                                content_id: id,
                            }
                        }).done(function(content) {
                            console.log(content)
                            location.reload();
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
                console.log('el subnúmero es: ' + id);
                var number = document.getElementById('subnumber' + id).value;
                if (number >= 10) {
                    var subnumber = number.substring(3);
                    console.log(number);
                    console.log(subnumber);
                    if (subnumber != '1') {
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
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    subcontent_id: id,
                                }
                            }).done(function(subcontent) {
                                console.log(subcontent)
                                location.reload();
                            })
                        } else {
                            // Do something if user cancels
                            console.log("User cancelled" + id);
                        }
                    } else {
                        alert("El punto no puede subir ya que es el número uno.")
                    }
                } else {
                    var subnumber = number.substring(2);
                    console.log(number);
                    console.log(subnumber);
                    if (subnumber != '1') {
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
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    subcontent_id: id,
                                }
                            }).done(function(subcontent) {
                                console.log(subcontent)
                                location.reload();
                            })
                        } else {
                            // Do something if user cancels
                            console.log("User cancelled" + id);
                        }
                    } else {
                        alert("El punto no puede subir ya que es el número uno.")
                    }
                }

            }
        </script>
        <script>
            function SCDown(id) {
                var subnumber = document.getElementById('subnumber' + id).value;
                subnumber = parseFloat(subnumber);
                var nextNumber = subnumber + 0.1;
                // console.log('el valor original es: ' + nextNumber);
                nextNumber = nextNumber.toFixed(1);
                // console.log('el valor cambiado es: ' + nextNumber);
                var next = id + 1;
                // console.log('el id es: ' + id);
                // console.log('el número es: ' + subnumber);
                // console.log('el siguiente número es: ' + nextNumber);
                // console.log($('#subnumber' + id).val());
                // console.log($('#subnumber' + nextNumber).val());
                // console.log($('#subnumber' + next).val());
                if ($('#subnumber' + next).val() == nextNumber) {
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
                            url: '/bajarPrioridadSubcontenido',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                subcontent_id: id,
                            }
                        }).done(function(subcontent) {
                            console.log(subcontent)
                            location.reload();
                        })
                    } else {
                        // Do something if user cancels
                        console.log("User cancelled" + id);
                    }
                } else {
                    alert("El subpunto no puede bajar ya que es el último del punto.")
                }
            }
        </script>
    @endsection
@endsection
