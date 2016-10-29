<?php 
    include '../include/head.php';
    include '../include/funcoes.php';
    include '../include/conexao/conecta.php';
    validaAcesso();  
        

    if(isset($_GET['acao']) && $_GET['acao'] != ''){
        
        $acao = $_GET['acao'];
        
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
        $id = base64_decode($id);
        
        if($acao == 'excluir'){
            
           

                $deleta = mysqli_query($conexao,"DELETE FROM associacao WHERE cd_associacao = '$id'");

                if($deleta == ''){
                echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
                }else{
                   echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
                }
                   
        }        
                
        if($acao == 'visualizar' || $acao  == 'editar'){
            $sql = "SELECT * FROM associacao WHERE cd_associacao = ".$id;
            $linha = mysqli_query($conexao, $sql);
            $associacao = mysqli_fetch_assoc($linha) or die(mysql_error());

            $id = $associacao['cd_associacao'];
            $razao = $associacao['nm_razao_social'];
            $logradouro = $associacao['nm_logradouro'];
            $local = $associacao['nm_local'];
            $numero = $associacao['ds_numero'];
            $complemento = $associacao['ds_complemento'];
            $cep = $associacao['cd_cep'];
            $bairro = $associacao['nm_bairro'];
            $municipio = $associacao['nm_municipio'];
            $uf = $associacao['nm_UF'];
            $telefone = $associacao['cd_telefone'];
            $email = $associacao['nm_email'];    
            $nm_linha = $associacao['nm_linha'];
        }
        
        if($acao == 'novo' ){
            
            $id = 0;
            $razao = "";
            $logradouro = "";
            $local = "";
            $numero = "";
            $complemento ="";
            $cep = "";
            $bairro = "";
            $municipio ="";
            $uf ="";
            $telefone = "";
            $email = "";
            $nm_linha = "";
        }    
    }   
        
    if(isset($_POST['cd_associacao']) && $_POST['cd_associacao'] != ''){
            $id = $_POST['cd_associacao'];;
            $razao = $_POST['nm_razao_social'];
            $logradouro = $_POST['nm_logradouro'];
            $local = $_POST['nm_local'];
            $numero = $_POST['ds_numero'];;
            $complemento = $_POST['ds_complemento'];
            $cep = $_POST['cd_cep'];;
            $bairro = $_POST['nm_bairro'];
            $municipio = $_POST['nm_municipio'];
            $uf = $_POST['nm_UF'];
            $telefone = $_POST['cd_telefone'];;
            $email = $_POST['nm_email'];
            $nm_linha = $_POST['nm_linha'];
        
        
        
        if(empty($id)){
             
                $sqlAssociacao = "INSERT INTO associacao (nm_razao_social, nm_logradouro, nm_local, ds_numero,"
                        . "ds_complemento, cd_cep, nm_bairro, nm_municipio, nm_UF, cd_telefone, nm_email, nm_linha) "
                                ."VALUES ('".$razao."', '".$logradouro."', '".$local."', ".$numero.", '".$complemento."', ".$cep.", '".$bairro."', '".$municipio."', '".$uf."', '".$telefone."', '".$email."', '".$nm_linha."')"; 
                echo $sqlAssociacao;
                $res = mysqli_query($conexao, $sqlAssociacao) or die(mysqli_error($conexao));
                $retorno='inserido';
            
        }else{            
            $sqlAssociacao = "UPDATE associacao SET nm_razao_social = '".$razao."', nm_logradouro = '".$logradouro."', nm_local = '".$local."', ds_numero = ".$numero.", ds_complemento = '".$complemento."', cd_cep = ".$cep.", nm_bairro = '".$bairro."', nm_municipio = '".$municipio."', nm_UF = '".$uf."', cd_telefone = '".$telefone."', nm_email = '".$email."', nm_linha = '".$nm_linha."' "
                        . "WHERE cd_associacao = ".$id ; 
                                
            $res = mysqli_query($conexao, $sqlAssociacao) or die(mysqli_error());
            $retorno='alterado';

            
        }  
        if($retorno){
            header('Location: index.php?retorno='.$retorno);
        }else{
            header('Location: gerencia.php?id='.base64_encode($id).'&acao=novo&retorno=invalido');
        }
    } 
?>
<script>alertaSucesso("a", "a", "a")</script>


<body class="">
    <?php include '../include/header.php';?>

    <div id="page-container">
       
        <?php include '../include/menu.php';?>
 
<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Associações</a> > <?php echo $acao?></li>
                
            </ol>
            <h1>Associações</h1>            
        </div>       

        <div class="container">               
            		
                <div class="panel panel-midnightblue">
            
                    <div class="panel-heading">
        <h4>Dados da associação</h4>
       
    </div>
    <div class="panel-body collapse in">
        
        <script src="../assets/js/pesquisaCep.js"></script>
        <script src="../assets/js/mascaraCpf-Tel.js"></script>
        <form id="formAssociacao" name="formAssociacao" action="gerencia.php" method="post"  class="form-horizontal" />
            <input type="hidden" name="cd_associacao" id="cd_associacao" value="<?php echo($id);?>">
           
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Razao Social</label>
                <div class="col-sm-4">
                    <input name="nm_razao_social" id="nm_razao_social" type="text" class="form-control"  value="<?php echo $razao?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">CEP</label>
                <div class="col-sm-4">
                    <input name="cd_cep" id="cd_cep" type="text" class="form-control" onblur="pesquisacep(this.value);" value="<?php echo $cep?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Logradouro</label>
                <div class="col-sm-4">
                    <select name="nm_logradouro" id="nm_logradouro" class="form-control" <?php if($acao == 'visualizar'){?>disabled="disabled" <?php };?> required>
                        <option value=''>-</option>
                        <option value="AV" <?php echo($logradouro == 'AV') ? 'selected' : '';?>>AV</option>
                        <option value="RUA" <?php echo($logradouro == 'RUA') ? 'selected' : '';?>>RUA</option>
                        <option value="ROD." <?php echo($logradouro == 'ROD.') ? 'selected' : '';?>>ROD.</option>
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Endereço</label>
                <div class="col-sm-4">
                    <input name="nm_local" id="nm_local" type="text" class="form-control"  value="<?php echo $local?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Numero</label>
                <div class="col-sm-4">
                    <input name="ds_numero" id="ds_numero" type="number" min=1  title="Insira um valor maior ou igual a 1" class="form-control"  value="<?php echo $numero?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Complemento</label>
                <div class="col-sm-4">
                    <input name="ds_complemento" id="ds_complemento" type="text" class="form-control"  value="<?php echo $complemento?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?>/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Bairro</label>
                <div class="col-sm-4">
                    <input name="nm_bairro" id="nm_bairro" type="text" class="form-control"  value="<?php echo $bairro?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Municipio</label>
                <div class="col-sm-4">
                    <input name="nm_municipio" id="nm_municipio" type="text" class="form-control"  value="<?php echo $municipio?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">UF</label>
                <div class="col-sm-4">
                    <input name="nm_UF" id="nm_UF" type="text" class="form-control"  value="<?php echo $uf?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Telefone</label>
                <div class="col-sm-4">
                    <input name="cd_telefone" id="cd_telefone" type="text" class="form-control"  onkeypress="javascript: mascara(this, tel_mask);" value="<?php echo $telefone?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                    <input name="nm_email" id="nm_email" type="email" class="form-control"  value="<?php echo $email?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Linha</label>
                <div class="col-sm-4">
                    <input name="nm_linha" id="nm_email" type="text" class="form-control"  value="<?php echo $nm_linha?>" <?php if($acao == 'visualizar'){?>readonly="readonly" <?php };?> required/>
                </div>
            </div>
        
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                    <?php 
                        if($acao  == 'visualizar'){?>
                            <a class="btn-primary btn" href='index.php'>Voltar</a>
                    <?php 
                        }else{?>
                            <button class="btn-primary btn" id="btn_gravar" >Gravar</button>
                            <a class="btn-default btn" href='index.php'>Cancelar</a>
                    <?php 
                        }?>
                    </div>
                </div>
            </div>
        </div> 
        </form>
        
    </div>
    
</div>
            
        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

    <?php include '../include/footer.php';?>

</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

<script type='text/javascript' src='../assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='../assets/js/alertas.js'></script> 
<script type='text/javascript' src='..assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='../assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='../assets/js/enquire.js'></script> 
<script type='text/javascript' src='../assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='../assets/js/jquery.touchSwipe.min.js'></script> 
<script type='text/javascript' src='../assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='../assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-wysihtml5/wysihtml5-0.3.0.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-wysihtml5/bootstrap-wysihtml5.js'></script> 
<script type='text/javascript' src='../assets/plugins/fullcalendar/fullcalendar.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-daterangepicker/moment.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.resize.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.orderBars.min.js'></script> 
<script type='text/javascript' src='../assets/demo/demo-index.js'></script> 
<script type='text/javascript' src='../assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='../assets/js/application.js'></script> 
<script type='text/javascript' src='../assets/demo/demo.js'></script> 

</body>
</html>

