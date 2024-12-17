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
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Añadir nuevo subpunto</div>
                    <div class="card-body">
                        <div class="text-uppercase">Contenido del punto principal: {{ $content->content_description}}</div>
                        <br>
                        <form action="{{ route('subcontent.saveNewSubcontent') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if (!$subcontents->isEmpty())
                                <div class="mb-3 col-12 ">
                                    <label for="place" class="form-label">Posición relativa</label>
                                    <select name="place" class="form-control text-uppercase" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Antes</option>
                                        <option value="2">Después</option>
                                    </select>
                                    @error('place')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>  
                                <div class="mb-3 col-12 ">
                                    <label for="id" class="form-label">Punto de pivote</label>
                                    <select name="id" class="form-control text-uppercase" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        @foreach ($subcontents as $subcontent)
                                            <option value="{{ $subcontent->subcontent_id}}">{{ $subcontent->subcontent_number }}.- {{ Str::limit($subcontent->subcontent_description, 60 ) }}</option>
                                        @endforeach
                                    </select>
                                    @error('id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>  
                            @else
                                <input type="hidden" name="place" value="first">
                                <input type="hidden" name="order" value="{{ $content->order_id }}">
                                <input type="hidden" name="content" value="{{ $content->content_id }}">
                            @endif
                            
                            
                            <div class="mb-3 col-12 ">
                                <label for="description" class="form-label">Descripción del nuevo subpunto (sin número de referencia)</label>
                                <input type="text" name="description" id="" class="form-control text-uppercase" required>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div> 
                            
                            <div class="col-12 row">
                                <div class="col-6 mb-3 p-3  border-start-1">
                                    <label for="points" class="form-label">[OPCIONAL] Añadir más subpuntos: (estos seguiran la numeración del primero añadido)</label>
                                    <select name="points" id="points" class="form-control" required>
                                        <option disabled selected>Cantidad de subpuntos del punto principal</option>
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value={{ $i }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 mb-3 p-3  border-start-1">
                                    <label for="archivo" class="form-label">[OPCIONAL] Documento del subpunto</label>
                                    <input type="file" name="file" class="form-control text-uppercase" aria-describedby="fileHelp">
                                    <div id="fileHelp" class="form-text">Documento oficial del punto.</div>
                                    @error('file')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div id="subcontent" class="col-12"></div>
                            </div>
                            <br>
                            <br>
                            <div class="mb-3 col-12">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="checkBoxContent" required>
                                    <label class="form-check-label" for="checkBoxContent">He verificado y quiero ingresar un nuevo punto principal.</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Registar punto</button>
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
                for(var i=1; i<=value; i++)
                {
                    output+='<div class="col-12">' + 
                                '<label for="position" class="form-label">&nbsp;Subpunto ' + i + '</label>' + 
                                '<input type="text" name="subcontent_description' + i + '"' + 
                                'class="form-control text-uppercase" placeholder="Descripción completa del subpunto">' + 
                                '<div id="position" class="form-text">Descripción completa del subpunto ' + i + '</div>' + 
                                '</div> <br>' + 
                            '<div class="col-6">' + 
                                '<label for="archivo" class="form-label">[OPCIONAL] Documento del subpunto ' + i + '</label>' + 
                                '<input type="file" name="subFile' + i + '" class="form-control text-uppercase" aria-describedby="fileHelp">' + 
                                '<div id="fileHelp" class="form-text">Documento oficial del punto.</div>' + 
                            '</div>';
                        
                }
                $('#subcontent').empty().append(output);
            });
        </script>
    @endsection
@endsection

