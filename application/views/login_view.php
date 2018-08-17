
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
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                                                <span><img src="assets/images/logo2.jpg" alt="" class="img-responsive"></span>
                                            </a>
                                        </h2>
                                        <h5 class="text-uppercase font-bold m-b-5 m-t-50">Login</h5>
                                        <p class="m-b-0">Acesse sua conta do sistema administrativo</p>
                                    </div>
                                    <div class="account-content">
                                        <form class="form-horizontal">

                                            <div class="form-group m-b-20">
                                                <div class="col-xs-12">
                                                    <label for="emailaddress">Login</label>
                                                    <input class="form-control" type="email" id="username" autocomplete="off" placeholder="email@provedor.com.br">
                                                </div>
                                            </div>

                                            <div class="form-group m-b-20">
                                                <div class="col-xs-12">
                                                   <!--  <a href="page-recoverpw.html" class="text-muted pull-right"><small>Esqueceu sua senha?</small></a> -->
                                                    <label for="password">Senha</label>
                                                    <input class="form-control" type="password" id="password" placeholder="Digite sua senha">
                                                </div>
                                            </div>

                                            <div class="form-group text-center m-t-10">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-md btn-block waves-effect waves-light button-manzoni" type="submit" id="btnEntrar">Entrar </button>
                                                </div>
                                            </div>

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



        <script>
            var resizefunc = [];
        </script>

    <!-- jQuery  -->
    <script src="<?php print site_url()?>assets/js/jquery.min.js"></script>
    <script src="<?php print site_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/js/sweetalert2.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/styleSweetalert2.js')?>"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("form").submit(function(){
                var login = $("#username").val()
                var senha = $("#password").val();
                if(login == "" || senha == ""){
                    sweetAlert("Oops...", "Preencha o campo login e senha.", "error");
                    event.preventDefault();
                    return 0;
                }


                $.post( "<?php echo site_url('login/process')?>", { login: login, senha:  senha })
                    .done(function( data ) {
                        data = jQuery.parseJSON(data);
                        if(data.status == 'erro'){
                          error("Oops...", "Usuário ou senha incorretos");

                        } else {
                            window.location= data.redirect;
                        }

                    });
                event.preventDefault();
            });
        });
        function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
        }
        function esquecisenha(){
            swal({
                    title: "Sem problemas!",
                    text: "Digite seu email para enviarmos um link para alterar a senha",
                    type: "input",
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "meuemail@provedor.com",
                    confirmButtonColor: "#67BE4D",
                    cancelButtonColor: "#00394d",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true
                },
                function(inputValue){
                    if (inputValue === false) return false;

                    if (inputValue === "" || !validateEmail(inputValue)) {
                        swal.showInputError("Você precisa digitar um email válido.");
                        return false
                    }
                    var url = "<?php echo site_url('recuperar/generate')?>";
                    // ajax adding data to database
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: {email: inputValue},
                        dataType: "JSON",
                        success: function(data)
                        {
                            swal("Sucesso!", "Solicitação realizada com sucesso, confira seu email.", "success");
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        swal("Erro!", "Verifique o email digitado, caso o problema persista  entre contato conosco.", "error");

                    }
                    });
                });
        }
    </script>
    </body>
</html>