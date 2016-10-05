<?php 
    include '../include/head.php';
    include '../include/funcoes.php';
    include '../include/conexao/conecta.php';
    validaAcesso();
    

    
    if($_GET['acao'] == 'excluir'){
        $id = $_GET['id_usuario'];
        if($_SESSION['cdUsuario'] == $id){
            echo "<script>alert('Não é posivel deletar seu próprio usuario!');
            location.href=\"index.php\"</script>";
        }else{

            $deleta = mysqli_query($conexao,"DELETE FROM usuario WHERE id_usuario = '$id'");

            if($deleta == ''){
            echo "<script>alert('Houve um erro ao deletar!');
            location.href=\"index.php\"</script>";
            }else{
               echo "<script>alert('Registro excluido com sucesso!');
               location.href=\"index.php\"</script>";
            }

        }
    
    }
  
    if(isset($_GET['acao']) && $_GET['acao'] != ''){        
           
                
                
//                if(ale('Tem certeza que deseja excluir este usuario?')){
//                    $codigo_usuario = base64_decode($_GET['id']);		
//                    $sql = "DELETE FROM usuario WHERE id_usuario = '$codigo_pessoa'";
//                    $resultado = mysql_query($sql, $conexao) or die(mysql_error());	
//                    header('Location: index.php');
//                    exit;
//                }
           
	}	
    
    
?>

<body class="">
    <?php include '../include/header.php';?>

    <div id="page-container">
       
        <?php include '../include/menu.php';?>
 
<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Usuarios</a> > novo usuario</li>
                
            </ol>
            <h1>Usuarios</h1>            
        </div>       

        <div class="container">               
            		
                <div class="panel panel-midnightblue">
            
                    <div class="panel-heading">
        <h4>Dados do usuario</h4>
        
    </div>
    <div class="panel-body collapse in">
        <form action="" class="form-horizontal" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Ativo</label>
                <div class="col-sm-4">
                    <label class="checkbox-inline">
                      <input type="checkbox" id="inlinecheckbox1" value="option1" /> 
                    </label>
                    
                </div>
            </div>    
            <div class="form-group">
                <label class="col-sm-2 control-label">Perfil</label>
                <div class="col-sm-4">
                    <select name="ds_permissao" id="ds_permissao" class="form-control">
                        <option value=''>Perfil...</option>
                        <option value='1' onClick>Administrador</option>
                        <option value='2' onClick>Gerente</option>
                        <option value='3' onClick>Funcionario</option>                                                    
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Usuario</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  value="Usuario"/>
                </div>
            </div>
        
            <div class="form-group">
                <label class="col-sm-2 control-label">Senha</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Confirmar senha</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" />
                </div>
            </div>
        
        </form>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                        <button class="btn-primary btn">Alterar</button>
                        <button class="btn-default btn">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
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

<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.touchSwipe.min.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-wysihtml5/wysihtml5-0.3.0.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-wysihtml5/bootstrap-wysihtml5.js'></script> 
<script type='text/javascript' src='assets/plugins/fullcalendar/fullcalendar.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script> 
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.min.js'></script> 
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.resize.min.js'></script> 
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.orderBars.min.js'></script> 
<script type='text/javascript' src='assets/demo/demo-index.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/demo/demo.js'></script> 

</body>
</html>

