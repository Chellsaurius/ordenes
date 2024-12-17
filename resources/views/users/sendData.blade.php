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
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            Usted es administrador.
                        @endif


                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Launch demo modal
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Cuenta predial</label>
                                                <input type="text" class="form-control" id="cuenta"
                                                    value="25A001768001" aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Total</label>
                                                <input type="number" class="form-control" id="total" value="125"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Rezago</label>
                                                <input type="number" class="form-control" id="rezago" value="1"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Recargo</label>
                                                <input type="number" class="form-control" id="recargo" value="1"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Corriente</label>
                                                <input type="number" class="form-control" id="corriente" value="125"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">DAP</label>
                                                <input type="number" class="form-control" id="dap" value="1"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="direccion"
                                                    value="Av. cap. Vicente Lopez #274" aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Ab inicial</label>
                                                <input type="text" class="form-control" id="abinicial" value="2018/1"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Ab final</label>
                                                <input type="text" class="form-control" id="abfinal" value="2023/6"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre"
                                                    value="Emmanuel Chacha Avendaño" aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">T pago</label>
                                                <input type="text" class="form-control" id="tpago" value="1"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputText" class="form-label">Forma de pago</label>
                                                <input type="text" class="form-control" id="fpago" value="OXXO"
                                                    aria-describedby="acountHelp">
                                                <div id="acountHelp" class="form-text">Cuenta única e irrepetible.</div>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="mandarDatos()">Save
                                            changes</button>
                                    </div>
                                    <script>
                                        function mandarDatos() {
                                            var cuenta = document.getElementById('cuenta').value;
                                            var total = document.getElementById('total').value;
                                            var rezago = document.getElementById('rezago').value;
                                            var recargo = document.getElementById('recargo').value;
                                            var corriente = document.getElementById('corriente').value;
                                            var dap = document.getElementById('dap').value;
                                            var direccion = document.getElementById('direccion').value;
                                            var abinicial = document.getElementById('abinicial').value;
                                            var abfinal = document.getElementById('abfinal').value;
                                            var nombre = document.getElementById('nombre').value;
                                            var tpago = document.getElementById('tpago').value;
                                            var fpago = document.getElementById('fpago').value;

                                            console.log(cuenta);
                                            console.log(total);
                                            console.log(rezago);
                                            console.log(recargo);
                                            console.log(corriente);
                                            console.log(dap);
                                            console.log(direccion);
                                            console.log(abinicial);
                                            console.log(abfinal);
                                            console.log(nombre);
                                            console.log(tpago);
                                            console.log(fpago);


                                            $.ajax({
                                                type: "POST",
                                                url: '//172.17.5.214/cobropredial/public/api/guardarCobro',
                                                dataType: 'json',
                                                data: {
                                                    cuenta: cuenta,
                                                    total: total,
                                                    rezago: rezago,
                                                    recargo: recargo,
                                                    corriente: corriente,
                                                    dap: dap,
                                                    direccion: direccion,
                                                    abinicial: abinicial,
                                                    abfinal: abfinal,
                                                    nombre: nombre,
                                                    tpago: tpago,
                                                    fpago: fpago,

                                                }
                                            }).done(function(respuesta) {
                                                console.log(respuesta)

                                            })
                                            .fail(function(jqXHR, textStatus, errorThrown) {
                                                console.log(jqXHR, textStatus, errorThrown)
                                            })
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
@endsection
@endsection
