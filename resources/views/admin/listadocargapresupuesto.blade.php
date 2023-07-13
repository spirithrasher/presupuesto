<div class="card mt-5">
    <div class="card-header">Listado de Periodos</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 pt-5">
                <table class="table mt-3" id="datatables-example">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Periodo</th>
                            <th scope="col">Fecha Carga</th>
                            <th scope="col">Cerrado</th>
                        </tr>
                    </thead>
                </table>
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
            ajax: "{{ url('listado/carga/presupuesto') }}",
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'periodo', name: 'periodo' },
                    { data: 'fecha_carga', name: 'fecha_carga' },
                    { data: 'estado', name: 'estado' },
                 ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
       });
    });
  </script>