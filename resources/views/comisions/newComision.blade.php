@extends('layouts.carcasa')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="background-color: #e3342f; color: #fff; &:hover { background-color: #cc1f1a; }">
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
                    <div class="card-header">Nueva comisión</div>

                    <div class="card-body">
                        <form action="{{ route('comision.save') }}" method="post">
                            @csrf
                            <div class="d-flex justify-content-start row ">
                                <div class="mb-3 col-12 ">
                                    <label for="name" class="form-label">Nombre de la comisión</label>
                                    <input type="text" name="name" class="form-control text-uppercase" maxlength="255" aria-describedby="nameHelp" autofocus required>
                                    <div id="nameHelp" class="form-text">Nombre completo de la nueva comisión.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                                                
                                <div class="col-12 row">
                                    
                                    <div class="col-5 mb-3 p-3  border-start-1">
                                        <label for="members" class="form-label">Integrantes: </label>
                                        <select name="members" id="members" class="form-control" required>
                                            <option value="" disabled selected>0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                        </select>
                                    </div>
                                    <span id="usuarios" class="row">
                                </div>
                                
                                <div class="mb-3 col-12">
                                    <br>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="checkBox" required>
                                        <label class="form-check-label" for="checkBox">He verificado y quiero ingresar un
                                            una nueva comisión.</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Registrar una comisión</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#members').on('change',function(){
            var value=$(this).val();
            console.log(value);
            var output='';
            for(var i=1; i<=value; i++)
            {
                output+='<div class="col-6 border">'+
                            '<label for="name" class="form-label">Integrante ' + i + '</label>' + 
                            '<select name="users' + i + '" class="form-control text-uppercase" aria-describedby="userHelp" required>' +
                                '<option selected disabled>Seleccione un integrante</option>' + 
                                    '@foreach ($users as $user)' + 
                                        '<option value="{{ $user->id }}">{{ $user->name }} ({{ $user->RPartyUsers->party_acronim ?? ''}})' + 
                                    '@endforeach' + 
                            '</select>' + 
                            '<div id="users" class="form-text">Ingrese a un integrante de la comisión' + '</div>' + 
                        '</div>' + 
                        '<div class="col-4 border">' + 
                            '<label for="position" class="form-label">Cargo del integrante ' + i + '</label>' + 
                            '<select name="position' + i + '" class="form-control text-uppercase" required>' + 
                                        '<option selected disabled>Seleccione un cargo</option>' + 
                                        '@foreach ($positions as $position)' + 
                                            '<option value="{{ $position->position_id }}">{{ $position->position }}</option>' + 
                                        '@endforeach' + 
                                    '</select>' + 
                            '<div id="position" class="form-text">Cargo del integrante en la comisión</div>' + 
                        '</div>'   
            }
            $('#usuarios').empty().append(output);
        });
    </script>
@endsection
@endsection
