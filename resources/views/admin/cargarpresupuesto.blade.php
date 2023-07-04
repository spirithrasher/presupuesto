@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="col-md-12 ">
                <div class="alert alert-danger">
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    @foreach($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach      
                </div>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Carga de Presupuesto</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ route('carga.presupuesto') }}" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Subir Planilla</label>
                                    <input class="form-control" type="file" id="file" name="file">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-outline-primary" id="submit">Cargar</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>*<a href="{{ asset('planilla_pme.xlsx') }}">Descargar Plantilla</a></p>
                                <p>Importante:</p>
                                <ul>
                                    <li>Las Columnas no se pueden modificar</li>
                                    <li>La columna descripción en el caso que sea vacio colocar un punto</li>
                                    <li>La columna año colocar solo el año ej: 1900</li>
                                    <li>La columna presupuesto ingresar un numero sin punto ni signo $</li>
                                </ul>
                            </div>
                        </div>     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
