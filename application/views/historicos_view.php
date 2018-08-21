

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page" style="background-color: #f1f1f1;">
    <!-- Start content -->
    <div class="content">
        <div class="container">
                <a class="btn btn-casier casier" href="<?php print site_url( 'projetos' ); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>

           
            <div class="row">
                <div class="col-md-12">
                    <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Ação</th>
                                <th>Descrição</th>
                                <th>Sistema Operacional/Navegador</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Ação</th>
                                <th>Descrição</th>
                                <th>Sistema Operacional/Navegador</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!--- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
 

    <footer class="footer text-right">
        Sistema Administrativo ERT Contábil - <?php print date('Y') ?> 
    </footer>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
<?php $this->load->view('template/jquery');?>
<script type="text/javascript">

    var save_method;
    var table;


    $(document).ready(function() {
        table = $('#table').DataTable({
            "oLanguage":{
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "processing": true, 
            "serverSide": true, 
            "bServerSide": true,
            "bStateSave": false,
            "order": [],

            "ajax": {
                "url": "<?php echo site_url($this->uri->segment(1).'/ajax_list')?>",
                "type": "POST",
                "data": function ( data ) {
                    var formFilter =  $('#form-filter').serializeArray();
                    formFilter.forEach((field, index)=>{
                        data[field.name] = field.value;
                    });
                }
                
            },
            
            "columnDefs": [
            {
                "targets": [ -1 ],  
                "orderable": false, 
            },
            ],

        });
 });
</script>