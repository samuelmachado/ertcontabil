<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page" style="background-color: #f1f1f1;">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php print base_url(); ?>assets/dropzone.js" ></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php print base_url(); ?>assets/dropzone.css">


<STYLE>
    .dz-message{
        font-size:250%;
        color:#3D4D86;
    }
</STYLE>

<script>

    Dropzone.options.myAwesomeDropzone = {
        paramName: "file",
        maxFilesize: 100 // MB
    };

    function confirma(url){
        swal({
            title: "Tem certeza?",
            text: "Não será possível recuperar esse registro!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, Delete agora!",
            cancelButtonText: "Não, Eu não quero remover",
            closeOnConfirm: false
        }).then((result) => {
          if (result.value) {
             location.href=url.trim();
          }
        });
    }

    function atualizar()
    {

        var content = '';
        $.post('<?php print base_url('pastas/getFiles/'.$this->uri->segment(3)); ?>', function (lista) {
            // $('#frase').html('<i>' + frase.texto + '</i><br />' + frase.autor);
            // http://127.0.0.1/ertcontabil/pastas/deleteArquivo/0b54ed63a7a416554781ce8c92ae674d
            //
            $.each(lista, function( index, value ) {
                var formattedDate = new Date(value.fol_date);
                var d = formattedDate.getDate();
                var m =  formattedDate.getMonth();
                m += 1;
                var y = formattedDate.getFullYear();
                content += '<tr><td>'+d+'/'+m+'/'+y+'</td><td>'+value.arq_name+'</td><td><textarea class="form-control" onchange="changeTitle('+value.arq_id+',this.value)">'+value.arq_description+'</textarea></td><td><a target="_blank" href="<?php print base_url('pastas/forceDownloadArquivo/');?>'+value.arq_hash+'"><i class="fa fa-download fa-2x"></i></a></td>';

                <?php if($this->session->auth == 'admin'){ ?>
                content += '<td><a onclick=confirma("<?php print base_url('pastas/deleteArquivo/');?>'+value.arq_hash+'"); ><i class="fa fa-times fa-2x" style="color:red;"></i></a></td>';
                <?php } ?>
                content += '</tr>';
                //console.log( index + ": " + value.arq_endereco );
            });
            $( "#pesquisa" ).html(content);

        }, 'JSON');
    }

    function update(){
        setInterval("atualizar()", 2000);
    }
    atualizar();

</script>

        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-casier casier" href="<?php print site_url( 'pastas/projeto/'.md5($projeto->prj_id) ); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
                

                <?php if($this->session->auth == 'admin'){ ?>

                <h2>Adicionar Arquivos</h2>
                <form onclick="update();" style="background: papayawhip" id="my-awesome-dropzone" action="<?php print site_url( 'pastas/fileUpload/'.$this->uri->segment(3).'/'.$projeto->fol_id); ?>" method="POST" class="dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </form>
                <?php } ?>
                <h2>Arquivos Adicionados <a onclick="atualizar()" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i> Atualizar Arquivos</a> </h2>
                
                <div class="table-responsive" >
                    <table  id="table" class="table table-striped table-bordered table-hover sortable table-responsive">
                        <thead>
                        <tr>
                            <th> Data</th>
                            <th> Arquivo</th>
                            <th> Descrição</th>
                            <th> Baixar</th>
                                            <?php if($this->session->auth == 'admin'){ ?> <th> Remover</th> <?php } ?>
                        </tr>
                        </thead>
                        <tbody id="pesquisa">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  

<script>
  <?php if($this->session->auth == 'admin'){ ?>
   
 
 function changeTitle(aud_id,value){
    $.post('<?php print base_url() ?>home/changeTitle/'+aud_id+'/'+value).then(() => {
      swal('Sucesso!','Atualizamos a descrição do arquivo','success');
    }).catch((e) => {
          alert('Erro ao atualizar descrição');
    });


         // 
    }
       <?php } ?>
    // function saveDes(){

    //     $.ajax({
    //         url: "<?php print site_url('home/changeTitle/') ?>",
    //         type: "POST",
    //         data: $('#form').serialize(),
    //         dataType: "JSON",
    //         success: function (data) {
    //             swal('Sucesso!','Realizado com sucesso','success');
    //         }
    //     });
    // }
</script>
        </div>
    </div>
</div>