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
                <div class="card-header">Carga de Costos</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ route('cargar.costos') }}" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Subir Planilla</label>
                                    <input class="form-control  @error('file') is-invalid @enderror"" type="file" id="file" name="file">
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
                                </ul>
                            </div>
                        </div>     
                    </form>
                </div>
            </div>

            <!-- @include('admin.listadocargapresupuesto') -->
        </div>
    </div>
</div>
@endsection
