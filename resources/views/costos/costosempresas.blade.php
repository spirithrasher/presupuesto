@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Costos por Empresas</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ route('costosempresa') }}" >
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="annos" class="form-label">Años</label>
                                <select class="form-select" id="annos" name="annos">
                                    @foreach($annos as $a)
                                        @php $selected_annos = (old('annos') == $a)?"selected":"" @endphp
                                        <option value="{{$a}}" {{$selected_annos}}>{{$a}}</option>
                                    @endforeach
                                </select>
                            </div>    
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="desde" class="form-label">Desde</label>
                                    <select class="form-select" id="desde" name="desde">
                                        @foreach($meses as $mes)
                                            @php $selected_desde = (old('desde') == $mes->numero)?"selected":"" @endphp
                                            <option value="{{$mes->numero}}" {{$selected_desde}}>{{$mes->mes}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="hasta" class="form-label">Hasta</label>
                                    <select class="form-select" id="hasta" name="hasta">
                                        @foreach($meses as $mes)
                                            @php $selected_hasta = (old('hasta') == $mes->numero)?"selected":"" @endphp
                                            <option value="{{$mes->numero}}" {{$selected_hasta}}>{{$mes->mes}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outline-primary" id="submit">Consultar</button>
                            </div>
                        </div>     
                    </form>
                </div>
            </div>

            <!-- @include('admin.listadocargapresupuesto') -->
        </div>
        <div class="table-responsive-lg mt-5">
            <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>Empresas</th>
                    <th>Centros Costo</th>
                    <th>Ingresos</th>
                    <th>Costos</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empresas as $empresas)
                    @php $nombreempresa = (isset($datosTabla[$empresas->nombre]))?$empresas->nombre:""@endphp
                        @foreach($centrosCostos as $cc)
                            @php 
                                $nombrecc = (isset($datosTabla[$empresas->nombre][$cc->cod_centro_costo]))?$cc->nombre:"";
                                $ingresos = (isset($tablaResultado[$empresas->cod_empresa][$cc->cod_centro_costo]['ingresos']))? $tablaResultado[$empresas->cod_empresa][$cc->cod_centro_costo]['ingresos']:0 ;
                                $costos = (isset($tablaResultado[$empresas->cod_empresa][$cc->cod_centro_costo]['costos']))? $tablaResultado[$empresas->cod_empresa][$cc->cod_centro_costo]['costos']:0 ;
                                $total = (isset($tablaResultado[$empresas->cod_empresa][$cc->cod_centro_costo]['total']))? $tablaResultado[$empresas->cod_empresa][$cc->cod_centro_costo]['total']:0 ;
                            @endphp
                            <tr>
                                @if($nombrecc != "")
                                    <td>{{$nombreempresa}}</td>
                                    <td>{{$nombrecc}}</td>
                                    <td>{{$ingresos}}</td>
                                    <td>{{$costos}}</td>
                                    <td>{{$total}}</td>
                                @endif
                            </tr>
                        @endforeach
                    @if(isset($datosTabla[$empresas->nombre]) && $datosTabla[$empresas->nombre] == "" )
                        <tr>
                            <td>{{$nombreempresa}}</td>
                            <td>-</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    @endif
                    
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection