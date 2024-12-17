@extends('layouts.GPcarcasa')

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
                            @if ($order->order_document)
                                Documento original: <a target="_blank" class="btn btn-sm btn-secondary"
                                href="{{ asset('storage/orders/' . $order->order_document) }}">Abrir</a> <br>
                            @endif
                            
                            Pertenece a: 
                                {{ $order->RComOrders->comision_name }}
                        </div>
                        <br>
                        {{-- <button onclick="location.reload()">Reload Page</button> --}}
                        
                        <br>
                        <br>
                        <table class="table table-striped dt-responsive table-bordered text-uppercase" id="content"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        # del punto
                                    </th>
                                    <th>
                                        Contenido
                                    </th>
                                    <th>
                                        Documentos
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
                                            @if ($content->content_document)
                                                <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#GPcontentDocument{{ $content->content_number }}">Documentos</a>
                                            @else
                                                No cuenta con documento descargable
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
                                                @if ($subcontent->subcontent_document)
                                                    <a class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#GPsubContentDocument{{ $content->content_number }}_{{ $subcontent->subcontent_number }}">
                                                        Documentos</a>
                                                @else
                                                    No cuenta con documento descargable
                                                @endif
                                                
                                            </td>
                                        </tr>
                                        
                                        @include('content.modals.GPsubContentDocuments')
                                    @endforeach
                                    @include('content.modals.GPcontentDocuments')
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
            console.log('el id es: ' + id);
            console.log('el número es: ' + subnumber);
            console.log('el siguiente número es es: ' + nextNumber);
            console.log($('#subnumber' + id).val());
            console.log($('#subnumber' + nextNumber).val());
            if ($('#subnumber' + nextNumber).val()) {
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
