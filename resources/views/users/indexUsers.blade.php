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
                    <div class="card-header">Lista de usuarios</div>
    
                    <div class="card-body">
                        <div class="d-flex justify-content-end" >
                            <a type="button" class="btn btn-primary" href="{{ route('user.new') }}">
                                Añadir usuario
                            </a>
                            
                        </div>
                        <br>
                        <table id="usuarios" class="table table-striped dt-responsive table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Correo
                                    </th>
                                    <th>
                                        Partido
                                    </th>
                                    <th>
                                        Rol
                                    </th>
                                    <th>
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="whitespace-nowrap">
                                        <td class="text-uppercase ">{{ $user->name }}</td>
                                        <td >
                                            {{ $user->email }}
                                        </td>
                                        <td >
                                            <div class="btn btn-lg" style="background-color: {{ $user->RPartyUsers->party_colour ?? '' }}; --bs-btn-padding-y: .5rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: .75rem;">
                                                {{ $user->RPartyUsers->party_acronym ?? '' }}
                                            </div>
                                            
                                        </td>
                                        <td >
                                            {{ $user->RRolUsers->rol ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center border-b" >
                                            <a class="btn btn-outline-success btn-sm"data-bs-toggle="modal" data-bs-target="#editUserM{{ $user->id }}">Editar</a>
                                            @if ((Auth::user()->rol_id == 5 && ($user->rol_id == 1 || $user->rol_id == 2 || $user->rol_id == 3)) || Auth::user()->rol_id == 6 || Auth::user()->id == $user->id)
                                                <a href="{{ route('user.disable', $user->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que desea dar de baja a este usuario?')">Desactivar</a>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                    @include('users.modals.editUserM')
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
            
        </script>
    @endsection
@endsection