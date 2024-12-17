@extends('layouts.carcasa')

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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Panel de cambio de contraseña</div>

                    <div class="card-body">
                        <form class="col-md-12 mb-3" action="{{ route('user.saveNewPass') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ Auth()->user()->id }}">
                            <div class="form-group">
                                <label for="lastPass">Anterior contraseña</label>
                                <input type="password" name="lastPass" class="form-control col-6 " id="lastPass"
                                    aria-describedby="lPasslHelp" placeholder="Anterior contraseña" autofocus="on" required>
                                <small id="lPasslHelp" class="form-text text-muted">Ingrese su anterior contraseña.</small>
                            </div>
                            <div class="form-group">
                                <label for="newPass">Nueva contraseña</label>
                                <input type="password" name="newPass" class="form-control col-6" id="newPass"
                                    aria-describedby="nPasslHelp" placeholder="Nueva contraseña" required>
                                <small id="nPasslHelp" class="form-text text-muted">Minimo 8 caracteres.</small>
                            </div>
                            <div class="form-group">
                                <label for="newPass_confirmation">Verifique la contraseña</label>
                                <input type="password" name="newPass_verified" class="form-control col-6"
                                    id="newPass_confirmation" aria-describedby="nVPasslHelp"
                                    placeholder="Verifique la contraseña" required>
                                <small id="nVPasslHelp" class="form-text text-muted">Repetir la misma contraseña.</small>
                            </div>
                            <br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input " id="exampleCheck1" required>
                                <label class="form-check-label" for="exampleCheck1">He verificado los datos</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                        </form>
                        <br>
                        <hr/>
                        @if (Auth::user()->id == 1)
                            <a href="{{ route('user.predial') }}">nombre</a>
                        @endif
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                        <div class="col-md-12">
                            Lista de usuarios

                            <table id="usuarios" class="table table-striped table-bordered nowrap dt-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            Nombre
                                        </th>
                                        <th>
                                            Correo
                                        </th>
                                        <th>
                                            Estatus
                                        </th>
                                        <th>
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <th class="text-uppercase">{{ $user->name }}</th>
                                        <th class="text-uppercase">{{ $user->email }}</th>
                                        <th class="text-uppercase">
                                            @if ($user->user_status == 1)
                                                activo
                                            @else
                                                inactivo
                                            @endif
                                        </th>
                                        <th>
                                            <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changeUserPasswordSM{{ $user->id }}">Cambiar contraseña</a> 
                                            @if ($user->user_status == 1)
                                                <a href="{{ route('user.disable', $user->id) }}" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea dar de baja a este usuario?')">Dar de baja</a> 
                                            @else
                                            <a href="{{ route('user.enable', $user->id) }}" class="btn btn-outline-success" onclick="return confirm('¿Seguro que desea dar de alta a este usuario?')">Dar de alta</a> 
                                            @endif
                                            
                                        </th>
                                    </tr>
                                    @include('users.modals.changeUserPassword')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
