@extends('layouts.app')

@section('content')

    <div class="container">
        {{-- lista de las ordenes vigentes --}}
        <div class="container">
            <div class="card mb-4 mt-3">
                <div class="card-header">{{ __('Listado de órdenes vigentes') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('createorden') }}" class="btn btn-success">Crear una orden</a>
                        <a href="{{ route('reportes') }}"class="btn btn-success">Generar reporte</a>
                    </div>
                    <br>
                    <br>
                    <div class="d-grid gap-2 mb-4 justify-content-md-end">
                        <form action="{{ route('ordenes') }}" method="get" class="d-inline-flex ">
                            <input class="form-control me-md-2" type="text" name="folio" placeholder="Buscar..."
                                aria-label="Search">
                            <button class="btn btn-outline-success " type="submit">Buscar</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Dependencia</th>
                                    <th>Folio</th>
                                    <th>Fecha de elaboración</th>
                                    <th>Fecha de entrega</th>
                                    <th>Comentarios</th>
                                    <th>Estatus orden</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($ord) <= 0)
                                    <tr>
                                        <td colspan="8">No hay resultados</td>
                                    </tr>
                                @else
                                    @foreach ($ord as $orden)
                                        <tr>
                                            <td class="v-align-middle text-uppercase">{{ $orden->nombre }}
                                                {{ $orden->apepat }} {{ $orden->apemat }}</td>
                                            <td class="v-align-middle text-uppercase">{{ $orden->descripcion_dep }}</td>
                                            <td class="v-align-middle">{{ $orden->folio }}</td>
                                            <td class="v-align-middle">
                                                {{ date_format(date_create($orden->fecha), 'd-m-Y') }}</td>
                                            <td class="v-align-middle">
                                                {{ date_format(date_create($orden->fecha_entrega), 'd-m-Y') }}</td>
                                            <td class="v-align-middle text-uppercase">{{ $orden->comentarios }}</td>
                                            {{-- <td class="v-align-middle">{{$orden->activo == 1 ? 'Con seguimiento' : 'Sin seguimiento, unidad perdida' }}</td> --}}
                                            <td class="v-align-middle text-uppercase">
                                                @if ($orden->estado_order == 0)
                                                    {{ 'Cancelada' }}
                                                @elseif ($orden->estado_order == 1)
                                                    {{ 'Creada' }}
                                                @elseif($orden->estado_order == 2)
                                                    {{ 'En proceso' }}
                                                @elseif ($orden->estado_order == 3)
                                                    {{ 'Entregada' }}
                                                @endif
                                            </td>
                                            <td class="v-align-middle"><button type="button"
                                                    {{ $orden->estado_order == 1 ? '' : ($orden->estado_order == 2 ? '' : ($orden->estado_order == 3 ? '' : 'disabled')) }}
                                                    class="btn btn-sm btn-success" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modalStateOrdAdmin{{ $orden->idorden }}">Cambiar
                                                    estatus</button></td>
                                            @include('admins.ModalEdoOrdAdmin')
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <a href="{{ route('principal') }}" class="btn btn-primary">Regresar</a>
                        <div class="d-flex justify-content-end">
                            {{ $ord->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- otros --}}

        <div class="container">
            {{-- lista de las ordenes muertas --}}
            <div class="container">
                <div class="card mb-4 mt-3">
                    <div class="card-header">{{ __('Listado de órdenes dadas de baja') }}</div>
                    <div class="card-body">
                        <div class="d-grid gap-2 mb-4 justify-content-md-end">
                            {{-- <form action="{{route('ordenes')}}"  method="get" class="d-inline-flex ">
                <input class="form-control me-md-2" type="text" name="folio" placeholder="Buscar..." aria-label="Search">
                <button class="btn btn-outline-success " type="submit">Buscar</button>
            </form> --}}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Dependencia</th>
                                        <th>Folio</th>
                                        <th>Fecha de elaboración</th>
                                        <th>Fecha de entrega</th>
                                        <th>Comentarios</th>
                                        <th>Estatus orden</th>
                                        {{-- <th>Acciones</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($order_dead) <= 0)
                                        <tr>
                                            <td colspan="8">No hay resultados</td>
                                        </tr>
                                    @else
                                        @foreach ($order_dead as $order)
                                            <tr>
                                                <td class="v-align-middle text-uppercase">{{ $order->nombre }}
                                                    {{ $order->apepat }} {{ $order->apemat }}</td>
                                                <td class="v-align-middle text-uppercase">{{ $order->descripcion_dep }}
                                                </td>
                                                <td class="v-align-middle">{{ $order->folio }}</td>
                                                <td class="v-align-middle">
                                                    {{ date_format(date_create($order->fecha), 'd-m-Y') }}</td>
                                                <td class="v-align-middle">
                                                    {{ date_format(date_create($order->fecha_entrega), 'd-m-Y') }}</td>
                                                <td class="v-align-middle text-uppercase">{{ $order->comentarios }}</td>
                                                {{-- <td class="v-align-middle">{{$orden->activo == 1 ? 'Con seguimiento' : 'Sin seguimiento, unidad perdida' }}</td> --}}
                                                <td class="v-align-middle text-uppercase">
                                                    @if ($order->estado_order == 0)
                                                        {{ 'Cancelada' }}
                                                    @elseif ($order->estado_order == 1)
                                                        {{ 'Creada' }}
                                                    @elseif($order->estado_order == 2)
                                                        {{ 'En proceso' }}
                                                    @elseif ($order->estado_order == 3)
                                                        {{ 'Entregada' }}
                                                    @endif
                                                </td>
                                                {{-- <td class="v-align-middle"><button type="button" {{$order->estado_order == 1 ? '' : ($order->estado_order == 2 ? '' : ($order->estado_order == 3 ? '' : 'disabled'))}} class="btn btn-sm btn-success" href="#" data-bs-toggle="modal" data-bs-target="#modalStateOrdAdmin{{$order->idorden}}">Cambiar estatus</button></td>
                                                    @include('admins.ModalEdoOrdAdmin') --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <a href="{{ route('principal') }}" class="btn btn-primary">Regresar</a>
                            <div class="d-flex justify-content-end">
                                {{ $order_dead->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection


        /*/*/*/*/*/*/*/*/*/*/*/*/*/* ORIGINAL 

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
                    <div class="card-header">Lista de actas</div>

                    <div class="card-body">
                        @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <div class="d-flex justify-content-end " >
                                <a type="button" class="btn btn-primary" href="{{ route('certificates.newCertificate') }}">
                                    Añadir acta
                                </a>
                            </div>
                        @endif
                        <br>
                        <div class="d-flex justify-content-end ">
                            <div class="col-3">
                                <div class="input-group ">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
                                    <button class="input-group-text" id="basic-addon2" onclick="busqueda()"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                @include('certificates.js.search')
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
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
                                                <a href="{{ route('content.IRIndex', $certificate->RCerOrder->order_id) }}" 
                                                    class="btn btn-outline-primary text-uppercase">{{ $certificate->RCerOrder->order_subject }}</a>
                                                
                                                
                                            </td>
                                            <td class=" text-center" >
                                                <a target="_blank" class="btn btn-outline-success" 
                                                    href="{{ asset('storage/certificates/'.$certificate->certificate_document) }}">
                                                    Descargar</a>
                                                @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                                                    <button type="button" class="btn btn-outline-success" onclick="orders({{ $certificate->certificate_id }})" data-bs-toggle="modal" 
                                                        data-bs-target="#editCertificate{{ $certificate->certificate_id }}">
                                                        Editar</button >
                                                    <a href="{{ route('certificates.disable', $certificate->certificate_id) }}" class="btn btn-outline-danger" 
                                                        onclick="return confirm('¿Seguro que desea dar de baja a esta acta?')">Desactivar</a>
                                                    @include('certificates.js.getOrders')
                                                @endif
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
                        <div class="d-flex justify-content-end">
                            {{ $certificates->links()}}
                        </div>
            
                    </div>
                </div>
            </div>
        
        </div>
    </div>

    @section('js')
        
    @endsection
@endsection
