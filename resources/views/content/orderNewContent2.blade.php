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
                        <form action="{{ route('content.save', $order->order_id) }}" method="post">
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
                                <div id="description" class="col-12"></div>
                            </div>
                            <br>
                            <div class="mb-3 col-12">
                                <br>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBox" required>
                                    <label class="form-check-label" for="checkBox">He verificado los datos y son correctos.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar contenido</button>
                            </div>
                        </form>&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
        <script>
            $(document).ready(function() {
                toastr.options.timeOut = 10000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif
            });
        </script>
        <script>
            $('#points').on('change',function(){
                var value=$(this).val();
                //console.log(value);
                var output='';
                var j = 1;
                for(var i=1; i<=value; i++)
                {
                    output+='<div class="col-12 border">' + 
                                '<label for="position" class="form-label">&nbsp;Punto ' + i + '</label>' + 
                                '<input type="text" name="content_description' + i + '" class="form-control text-uppercase" placeholder="Descripción completa del punto" required>' + 
                                
                                '<div id="position" class="form-text">Descripción completa del punto ' + i + '</div>' + 
                            '</div>' +  
                            '<div class="col-12 border">' + 
                                '<label for="actions" class="form-label">&nbsp;&nbsp;Añadir&nbsp;</label>' +
                                '<input type="number" step"1" max="10" min="0" id="subpoints' + i + '" name="subpoints' + i + '" > Número de subpuntos: <br />' + 
                                '<a id="filldetails" onclick="addFields(' + i + ')" class="btn btn-secondary ml-5">Añadir subpuntos </a> ' + 
                                
                            '</div>' + 
                            '<div id="container' + i + '" class="col-12 border bg-info bg-opacity-10"></div> <br>' ;
                        
                }
                $('#description').empty().append(output);
            });
        </script>
        <script type='text/javascript'>
            function addFields(i){
                //console.log(i);
                // Generate a dynamic number of inputs
                var number = document.getElementById("subpoints" + i).value;
                // Get the element where the inputs will be added to
                var container = document.getElementById("container" + i);
                // Remove every children it had before
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }
                for (j=1; j<=number; j++){
                    // Append a node with a random text
                    container.appendChild(document.createTextNode("Subpunto " + (j) + ".- "));
                    // Create an <input> element, set its type and name attributes
                    var input = document.createElement("input");
                    input.type = "text";
                    input.name = "subpunto" + i + '.' + j;
                    input.size = 100;
                    input.class = "form-control text-uppercase";
                    input.style = "padding-top: 3px; padding-bottom: 3px; text-transform: uppercase;";
                    container.appendChild(input);
                    // Append a line break 
                    //console.log(j);
                    container.appendChild(document.createElement("br"));
                }
            }
        </script>
    @endsection
@endsection
