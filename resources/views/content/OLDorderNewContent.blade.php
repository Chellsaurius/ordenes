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
                    <div class="card-header text-uppercase">Contenido de la orden: "{{ $order->order_subject }}" </div>

                    <div class="card-body">
                        Cantidad de puntos que tendrá la orden
                        <form action="" method="post">
                            @csrf
                            
                            <div class="col-12 row">
                                <div class="col-5 mb-3 p-3  border-start-1">
                                    <label for="points" class="form-label">Puntos de la orden: </label>
                                    <select name="points" id="points" class="form-control" required>
                                        <option value="" disabled selected>Cantidad de puntos de la orden</option>
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value={{ $i }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <span id="description" class="row">
                            </div>
                            <br>
                            <br>
                            <div class="mb-3 col-12">
                                <br>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBox" required>
                                    <label class="form-check-label" for="checkBox">He verificado los datos y son correctos.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar contenido</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script>
            $('#points').on('change',function(){
                var value=$(this).val();
                //console.log(value);
                var output='';
                var j = 1;
                for(var i=1; i<=value; i++)
                {
                    output+='<div class="col-10 border point-container" name="point-container">' + 
                        '<label for="position" class="form-label">Punto ' + i + '</label>' + 
                        '<input type="text" name="content_description' + i + '" class="form-control" maxlength="255" placeholder="Descripción completa del punto">' + 
                        '</select>' + 
                        '<div id="position" class="form-text">Descripción completa del punto ' + i + '</div>' + 
                        '</div>' +  
                        '<div class="col-2 border point-container">' + 
                        '<label for="actions" class="form-label">Acciones</label>' + 
                        '<button class="btn btn-info add-subpoint" id="add-subpoint' + i + '" onclick="addDiv(' + i + ')">Añadir subpunto</button>' +
                        '</div>' + 
                        '<span id="subcontent' + i + '" class="row">';
                        
                }
                $('#description').empty().append(output);
            });
        </script>
        <script>
            function addDiv(j) {
                console.log(j)
                var i = j;
                var j = 1;
                var output2='';
                output2+='<div class="col-10 border point-container" name="point-container">' + 
                            '<label for="position" class="form-label">Subpunto ' + i + '.' + j +'</label>' + 
                            '<input type="text" name="content_description' + j + '" class="form-control" maxlength="255" placeholder="Descripción completa del subpunto">' + 
                            
                            '<div id="position" class="form-text">Descripción completa del subpunto ' + j + '</div>' + 
                        '</div>' +  
                        '<div class="col-2 border">' + 
                            '<label for="actions" class="form-label">Acciones</label>' + 
                            '<button class="btn btn-danger add-subpoint" id="add-subpoint' + j + '">Quitar subpunto</button>' +
                        '</div>';
                $('#subcontent' + j + '').empty().append(output2);
            }
        </script>
        <
        <script>
            // Add a click event listener to the document using event delegation
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-subpoint')) {
                    event.preventDefault();
                    var parent = event.target.closest('.point-container');
                    if (parent) {
                        var newSubpoint = document.createElement('div');
                        newSubpoint.classList.add('col-10', 'border', 'pb-2', 'subpoint-container');
                        newSubpoint.innerHTML = '<label for="actions" class="form-label">Descripción del subpunto ' + (parent.querySelectorAll('.subpoint-container').length + 1) + '</label>' + 
                            '<input type="text" maxlength="255" name="subcontent_description' + parent.querySelector('input').name.match(/\d+/) + '.' + (parent.querySelectorAll('.subpoint-container').length + 1) + '" class="form-control" placeholder="Descripción completa del subpunto">';
                        parent.appendChild(newSubpoint);

                        var newButton = document.createElement('button');
                        newButton.classList.add('btn', 'btn-danger', 'remove-subpoint');
                        newButton.textContent = 'Quitar subpunto';
                        var newButtonContainer = document.createElement('div');
                        newButtonContainer.classList.add('col-2', 'border');
                        newButtonContainer.appendChild(newButton);
                        parent.appendChild(newButtonContainer);

                    }
                }
            });

        </script>
        
    @endsection
@endsection
