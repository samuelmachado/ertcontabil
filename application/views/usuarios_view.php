

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page" style="background-color: #f1f1f1;">
    <!-- Start content -->
    <div class="content">
        <div class="container">
                <a class="btn btn-casier casier" href="<?php print site_url( 'projetos' ); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>

            <!-- end row -->
            <div class="row" style="margin-top:10px;margin-bottom: 10px;">
                <div class="col-md-12">
                    <div id="ligacoes" class="tab-pane fade in active">
                        <button class="btn button-manzoni" onclick="add_register()"><i class="glyphicon glyphicon-plus"></i> Novo Usuário</button>
                         <form id="form-filter" class="form-horizontal">
                           <input  type="hidden" name="prj_id_filter" id="prj_id_filter" value="<?php print $projeto->prj_id ?>" />       
                          </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Tipo</th>
                                <th style="width:125px;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Tipo</th>
                                <th style="width:125px;">Ação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!--- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    <div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="usr_id"></input>
                        <input type="hidden" name="prj_id"  value="<?php print $projeto->prj_id ?>"></input>
                        <input type="hidden" name="usr_auth"  value="normal"></input>

                        <div class="row">
                         <div class="col-md-5">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Nome</label>  
                                    <input type="text" autocomplete="off" class="form-control" id="usr_name" name="usr_name">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label" >Login</label>
                                        <input autocomplete="off" type="text" class="form-control" id="usr_login" name="usr_login">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                              <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label" >Senha</label>
                                        <input autocomplete="off" type="password" class="form-control" id="usr_password" name="usr_password">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label" >Repita a senha</label>
                                        <input autocomplete="off" type="password" class="form-control" id="usr_password2" name="usr_password2">
                                        <span class="help-block"></span>
                                    </div>
                                </div> -->
                            </div>  
                            <div class="row">
                                <div class="col-md-12">
                                <br>
                                    <i>Aviso: Notifique usuários que utilizam @hotmail.com que o e-mail pode chegar na caixa de SPAM</i>
                                <br>
                                </div>
                            </div>                      
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnSalvar"  onclick="save()"  class="btn button-manzoni waves-effect waves-light">Salvar</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="logModalLabel">Registro de Alterações</h4>
      </div>
      <div class="modal-body" id="log-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="close" onclick='' data-dismiss="modal">X</button>
      </div>
    </div>
  </div>
</div>

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

$("input").change(function(){
    $(this).parent().parent().removeClass('has-error');
    $(this).next().empty();
});
$("textarea").change(function(){
    $(this).parent().parent().removeClass('has-error');
    $(this).next().empty();
});
$("select").change(function(){
    $(this).parent().parent().removeClass('has-error');
    $(this).next().empty();
});



var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};
});


function log_register(id){
$.post( '<?php echo site_url('logs/view')?>', { type: "users", id: id })
    .success(function( data ) {
        $("#log-body").html(data);
        console.log(data);
        $('#logModal').modal({backdrop: 'static', display:'show'}); 
    });
}
function add_register()
{
   
    save_method = 'add';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form').modal({backdrop: 'static', display:'show'}); 
}

function edit_register(id)
{
   
    save_method = 'update';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 

    $.ajax({
        url : "<?php echo site_url($this->uri->segment(1).'/ajax_edit/')?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            data.fields.forEach((field, index)=>{
                $('[name="'+field+'"]').val(data.data[field]);
            });
            // USER HACK
            $('[name="usr_password2"]').val(data.data['usr_password']);
            // USER HACK
            $('#modal_form').modal('show');
          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Erro ao obter informações.');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); 
}

function save()
{
    $('#btnSalvar').text('Salvando...'); 
    $('#btnSalvar').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url($this->uri->segment(1).'/ajax_add')?>";
    } else {
        url = "<?php echo site_url($this->uri->segment(1).'/ajax_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                $('#modal_form').modal('hide');
                reload_table();

            }
            else
            {
                $('.form-group').parent().removeClass('has-error');
                $('.help-block').empty();
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                }
            }
            $('#btnSalvar').text('Salvar');
            $('#btnSalvar').attr('disabled',false);


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            alert('Erro ao adicionar ou atualizar as informações.');
            $('#btnSalvar').text('Salvar');
            $('#btnSalvar').attr('disabled',false); 

        }
    });
}

    function delete_register(id)
    {
        swal({
          title: 'Tem certeza?',
          text: "Não será possível recuperar o registro!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#E4C81F',
          cancelButtonColor: '#666',
          confirmButtonText: 'Sim, remova!',
          cancelButtonText: "Não",
        }).then((result) => {     
            if (result.value) {
                $.ajax({
                    url : "<?php echo site_url($this->uri->segment(1).'/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        success("Sucesso!", "O registro foi apagado.", "success");
                        reload_table();

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        error("Erro", "Não foi possível remover o registro.", "error");
                    }
                });
            } else {
                error("Cancelado", "O registro não foi removido.", "error");
            }
        });
    }

    function send_password(hash)
    {
        swal({
          title: 'Tem certeza?',
          text: "O sistema irá enviar um email solicitando a troca da senha",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#E4C81F',
          cancelButtonColor: '#666',
          confirmButtonText: 'Sim, envie!',
          cancelButtonText: "Não",
        }).then((result) => {     
            if (result.value) {
                $.ajax({
                    url : "<?php echo site_url($this->uri->segment(1).'/generatePassUser')?>/"+hash,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        success("Sucesso!", "Solicitação enviada com sucesso", "success");
                        reload_table();

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        error("Erro", "Não foi possível realizar a transação.", "error");
                    }
                });
            } else {
                error("Cancelado", "A transação não foi processada.", "error");
            }
        });
    }
</script>