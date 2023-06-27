@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <div class="col-md-8">
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
            </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"> 
                            <!-- <a class="btn btn-outline-primary" href="{{ route('admin.listado.users') }}" role="button">Nuevo Usuario</a> -->
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <table class="table mt-3" id="datatables-example">
                                <thead>
                                    <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rol</th>
                                    <th scope="col">Estado</th>
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
<!-- <script>
    $(document).ready( function () {
        $('#datatables-example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'print'
            ],
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/users') }}",
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'nombre' },
                    { data: 'email', name: 'email' },
                    { data: 'rol', name: 'Rol' },
                    { data: 'habilitado', name: 'habilitado' },
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},

                 ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
       });
    });
  </script> -->
@endsection


