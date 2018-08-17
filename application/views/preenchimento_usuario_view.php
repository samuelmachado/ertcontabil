
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>ERT Contábil 1.0</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->       
        <link rel="apple-touch-icon" sizes="180x180" href="<?php print site_url() ?>assets/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php print site_url() ?>assets/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php print site_url() ?>assets/icon/favicon-16x16.png">
        <link rel="manifest" href="<?php print site_url() ?>assets/icon/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <!-- App css -->
        <link href="<?php print site_url()?>assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="<?php print site_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print site_url()?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php print site_url()?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php print site_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php print site_url()?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php print site_url()?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php print site_url()?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/sweetalert2.min.css')?>" rel="stylesheet">
        <link href="<?php print site_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?php print site_url()?>assets/js/modernizr.min.js"></script>

    </head>

    <body class="">

        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="account-pages">
                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <h2 class="text-uppercase text-center">
                                            <a href="index.html" class="text-success">
                                                <span><img src="<?php print site_url('assets/images/logo2.jpg')?>" alt="" class="img-responsive"></span>
                                            </a>
                                        </h2>
                                        <h5 class="text-uppercase font-bold m-b-5 m-t-50">Bem-vindo(a),</h5>
                                        <p class="m-b-0"><?php print $data->usr_name ?></p>
                                    </div>
                                    <div class="account-content">
                                        <x class="form-horizontal">
                                            <div class="form-group text-center m-t-10">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-md btn-block waves-effect waves-light button-manzoni" onclick="load_modal()">Finalizar meu cadastro </button>
                                                </div>
                                            </x>

                                        </form>                                      
                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->


                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->
    <div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="usr_id" value="<?php print $data->usr_id ?>"></input>

                       
                        <div id="afterType" style="display: block">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input autocomplete="off" type="password" class="form-control" id="usr_password" name="usr_password" >
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Repita a Senha</label>
                                        <input autocomplete="off" type="password" class="form-control" id="usr_password2" name="usr_password2" >
                                        <span class="help-block"></span>
                                    </div>
                                </div>
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
    </div>


        <script>
            var resizefunc = [];
        </script>

    <!-- jQuery  -->
    <script src="<?php print site_url()?>assets/js/jquery.min.js"></script>
    <script src="<?php print site_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/js/sweetalert2.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/styleSweetalert2.js')?>"></script>
<script src="<?php echo site_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo site_url() ?>assets/js/bootstrap3-typeahead.min.js"></script>

    <script type="text/javascript">
    function save()
{
    $('#btnSalvar').text('Salvando...'); 
    $('#btnSalvar').attr('disabled',true); 
    var url;

 
        url = "<?php echo site_url($this->uri->segment(1).'/saveUser')?>";
  

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
                swal("Sucesso!", "Suas informações foram atualizadas com sucesso.", "success");
                location.href = "<?php print site_url('login'); ?>";


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
        function load_modal() {
            $('#form')[0].reset(); 
            $('.form-group').removeClass('has-error'); 
            $('.help-block').empty(); 
            $('#modal_form').modal({backdrop: 'static', display:'show'}); 
        } 

         $( "#con_cep" ).change(() => {
        $.get("https://viacep.com.br/ws/"+$("#con_cep").val()+"/json/", (data) => {
            $("#con_address").val(data.logradouro);
            $("#con_neighborhood").val(data.bairro);
            $("#con_city").val(data.localidade);
            $("#con_state").val(data.uf);
        },'json');
    });
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.sp_celphones').mask(SPMaskBehavior, spOptions);
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
   
    </script>
    </body>
</html>