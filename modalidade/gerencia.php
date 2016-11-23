<?php
include '../include/head.php';
include '../include/funcoes.php';
include '../include/conexao/conecta.php';
$conexao = conecta();
validaAcesso();
;


if (isset($_GET['acao']) && $_GET['acao'] != '') {

    $acao = $_GET['acao'];

    $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
    $id = base64_decode($id);

    if ($acao == 'excluir') {
        $deletaTipoVeiculo = $conexao->prepare("DELETE FROM tipoVeiculo WHERE cd_modalidade = :id");
        $deletaTipoVeiculo->bindValue(":id", $id);
        $deletaTipoVeiculo->execute();

        if ($deletaTipoVeiculo->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
            auditoria("Tipo de Veiculo id ".$id." deletado" );
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaTipoVeiculo = $conexao->prepare("SELECT * FROM tipoVeiculo WHERE cd_modalidade = :id");
        $pegaTipoVeiculo->bindValue(":id", $id);
        $pegaTipoVeiculo->execute();
        $tipoveiculo = $pegaTipoVeiculo->fetch(PDO::FETCH_ASSOC);

        $id = $tipoveiculo['cd_modalidade'];
        $modalidade = $tipoveiculo['nm_modalidade'];
    }

    if ($acao == 'novo') {
        $id = 0;
        $modalidade = "";
    }
}

if (isset($_POST['cd_modalidade']) && $_POST['cd_modalidade'] != '') {
    $id = $_POST['cd_modalidade'];
    ;
    $modalidade = $_POST['nm_modalidade'];



    if (empty($id)) {
        $pegaTipoVeiculo = $conexao->prepare("SELECT nm_modalidade FROM tipoVeiculo WHERE nm_modalidade = :modalidade");
        $pegaTipoVeiculo->bindValue(":modalidade", $modalidade);
        $pegaTipoVeiculo->execute();

        if ($pegaTipoVeiculo->rowCount() > 0) {
            $retornoNome = 'nomeinvalido';
        } else {

            try {
                $novoTipoVeiculo = $conexao->prepare("INSERT INTO tipoVeiculo (nm_modalidade) "
                        . "VALUES ( :modalidade)");
                $novoTipoVeiculo->bindValue(":modalidade", $modalidade, PDO::PARAM_STR);


                $novoTipoVeiculo->execute();
                // echo $novoUsuario->rowCount();
                //var_dump($novoUsuario);

                auditoria("Tipo de veiculo id ".$conexao->lastInsertId()." Inserido" );
                $retorno = 'inserido';
            } catch (Exception $e) {
                echo $e;
                exit($e);
            }
        }
    } else {
        try {
            $atualizarTipoVeiculo = $conexao->prepare("UPDATE tipoVeiculo SET nm_modalidade = :modalidade "
                    . "WHERE cd_modalidade = :id");
            $atualizarTipoVeiculo->bindValue(":modalidade", $modalidade, PDO::PARAM_STR);

            $atualizarTipoVeiculo->bindValue(":id", $id);
            $atualizarTipoVeiculo->execute();

//                echo $atualizarUsuario->rowCount();
//                var_dump($atualizarUsuario);
//                echo $atualizarUsuario->errorCode();
//                exit();
            auditoria("Dados do tipo de veiculo id ".$id." atualizado" );
            $retorno = 'alterado';
        } catch (Exception $e) {
            echo $e;
            exit();
        }
    }

    if ($retornoNome) {
        header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=novo&retorno=nomeinvalido');
    } elseif ($retorno) {
        header('Location: index.php?retorno=' . $retorno);
    } else {
        header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=editar&retorno=invalido');
    }
}
?>
<script>alertaSucesso("a", "a", "a")</script>


<body class="">
<?php include '../include/header.php'; ?>

    <div id="page-container">

<?php include '../include/menu.php'; ?>

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Modalidades</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1>Modalidades</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados da modalidade</h4>

                        </div>
                        <div class="panel-body collapse in">

                            <script src="../assets/js/pesquisaCep.js"></script>
                            <script src="../assets/js/mascaraCpf-Tel.js"></script>
                            <form id="formTipoveiculo" name="formTipoveiculo" action="gerencia.php"method="post"  class="form-horizontal" />
                            <input type="hidden" name="cd_modalidade" id="cd_modalidade" value="<?php echo($id); ?>">

<?php if (isset($_GET['retorno']) && $_GET['retorno'] == 'nomeinvalido') { ?>
                                <div class="form-group ">   
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="alert alert-dismissable alert-danger col-sm-4 ">
                                        <strong>Modalidade já cadastrada</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    </div>
                                </div>
<?php } ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Modalidade</label>
                                <div class="col-sm-4">
                                    <input name="nm_modalidade" id="nm_modalidade" type="text" class="form-control"  value="<?php echo $modalidade ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required="required"/>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <div class="btn-toolbar">
                                            <?php if ($acao == 'visualizar') { ?>
                                                <a class="btn-primary btn" href='index.php'>Voltar</a>
                                            <?php } else {
                                                ?>
                                                <button class="btn-primary btn" id="btn_gravar" >Gravar</button>
                                                <a class="btn-default btn" href='index.php'>Cancelar</a>
                                            <?php }
                                            ?>
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

<?php include '../include/footer.php'; ?>

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

