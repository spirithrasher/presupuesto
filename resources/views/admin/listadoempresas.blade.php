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
                <div class="card-header">Listado de Empresas</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"> 
                            <a class="btn btn-outline-primary" href="{{ route('admin.nuevaempresa') }}" role="button">Nueva Empresa</a>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <table class="table mt-3" id="datatables-example">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Interno</th>
                                        <th scope="col">Codigo Empresa </th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Activo</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>   
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#datatables-example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ],
            processing: true,
            serverSide: true,
            ajax: "{{ url('listado/empresas') }}",
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'cod_empresa', name: 'cod_empresa' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'activo', name: 'activo' },
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                 ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
       });
    });
  </script>
@endsection