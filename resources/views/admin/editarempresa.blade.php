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
            <div class="card">
                <div class="card-header">Editar Empresa</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <form method="post"  action="{{ route('admin.editarempresa',['id' => $empresa->id]) }}" >
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="solicitado_por" class="form-label">Codigo Empresa</label>
                                        <input type="number" class="form-control @error('cod_empresa') is-invalid @enderror" id="cod_empresa" name="cod_empresa" value="{{old('cod_empresa')?old('cod_empresa'):$empresa->cod_empresa }}">
                                        @error('cod_empresa')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nombre" class="form-label">Nombre Empresa</label>
                                        <input type="text" class="form-control @error('cod_empresa') is-invalid @enderror" id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa')?old('nombre_empresa'):$empresa->nombre}}">
                                        @error('nombre_empresa')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                        @enderror
                                    </div>                            
                                    <div class="col-md-4">
                                        <label for="activo" class="form-label">Activo</label>
                                        <select class="form-select" id="activo" name="activo">
                                            @foreach($estado as $id => $e)
                                                @php $selected_e = (old('activo') == $id)?"selected":($empresa->activo == $id)? "selected":"" @endphp
                                                <option value="{{$id}}" {{$selected_e}}>{{$e}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <button type="submit" name="guardar" value="1" class="btn btn-primary">
                                            {{ __('Guardar') }}
                                        </button>
                                        <a class="btn btn-outline-danger" href="{{route('admin.listadoempresas')}}">Volver</a>
                                    </div>
                                </div>   
                            </form>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection