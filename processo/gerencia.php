<?php
include '../include/head.php';
include '../include/funcoes.php';
include '../include/conexao/conecta.php';
$conexao = conecta();
validaAcesso();


if (isset($_GET['acao']) && $_GET['acao'] != '') {

    $acao = $_GET['acao'];

    $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
    $id = base64_decode($id);

    if ($acao == 'excluir') {
        $deletaProcesso = $conexao->prepare("DELETE FROM processo WHERE id_processo = :id");
        $deletaProcesso->bindValue(":id", $id);
        $deletaProcesso->execute();

        if ($deletaProcesso->rowCount() == 0) {
            echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
        } else {
            echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
            auditoria("Processo id ".$id." deletada" );
        }
    }
    if ($acao == 'visualizar' || $acao == 'editar') {
        $pegaProcessos = $conexao->prepare("SELECT * FROM processo WHERE id_processo = :id");
        $pegaProcessos->bindValue(":id", $id);
        $pegaProcessos->execute();
        $processo = $pegaProcessos->fetch(PDO::FETCH_ASSOC);

        $id = $processo['id_processo'];
        $tipoVeiculo = $processo['cd_modalidade'];
        $codigoProcesso = $processo['cd_processo'];
        $anoProcesso = $processo['aa_processo'];
        $placa = $processo['cd_placa'];
        $dataDenuncia = $processo['dt_relato_denuncia'];
        $dataDefesa = $processo['dt_apresentacao_defesa'];
        $dataRelatorio = $processo['dt_apresentacao_relatorio'];
        $dataJulgamento = $processo['dt_inicio_julgamento'];
        $dataJulgado = $processo['dt_julgado'];
        $resultado = $processo['ds_resultado'];
        $notificacao = $processo['dt_notificacao'];
        $observacoes = $processo['ds_observacoes_processos'];
    }

    if ($acao == 'novo') {

        $id = 0;
        $tipoVeiculo = "";
        $codigoProcesso = "";
        $anoProcesso = "";
        $placa = "";
        $dataDenuncia = "";
        $dataDefesa = "";
        $dataRelatorio = "";
        $dataJulgamento = "";
        $dataJulgado = "";
        $resultado = "";
        $notificacao = "";
        $observacoes = "";
    }
}

if (isset($_POST['id_processo']) && $_POST['id_processo'] != '') {
    $id = $_POST['id_processo'];
    $codigoProcesso = $_POST['cd_processo'];
    $anoProcesso = $_POST['aa_processo'];
    $placa = $_POST['cd_placa'];

     try {
                                            $testes = $conexao->prepare("SELECT DISTINCT c.cd_modalidade, t.nm_modalidade FROM veiculo c , tipoVeiculo t where c.cd_placa = '$placa' AND c.cd_modalidade = t.cd_modalidade");
                                            $testes->execute();
                                            while ($teste = $testes->fetch(PDO::FETCH_ASSOC)) {

                                            $tipoVeiculo = $teste['cd_modalidade'];}
                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
    $dataDenuncia = $_POST['dt_relato_denuncia'];
    $dataDefesa = $_POST['dt_apresentacao_defesa'];
    $dataRelatorio = $_POST['dt_apresentacao_relatorio'];

    $dataJulgamento = $_POST['dt_inicio_julgamento'];
    $dataJulgado = $_POST['dt_julgado'];

    $resultado = $_POST['ds_resultado'];
    $notificacao = $_POST['dt_notificacao'];
    $observacoes = $_POST['ds_observacoes_processos'];



    if (empty($id)) {


        try {
            $novoProcesso = $conexao->prepare("INSERT INTO processo ( cd_processo, aa_processo, cd_placa, cd_modalidade, dt_relato_denuncia, dt_apresentacao_defesa,"
                    . "dt_apresentacao_relatorio, dt_inicio_julgamento, dt_julgado, ds_resultado, dt_notificacao, ds_observacoes_processos) "
                    . "VALUES (  :codigoProcesso, :anoProcesso, :placa, :tipoVeiculo, :dataDenuncia, :dataDefesa, :dataRelatorio, :dataJulgamento, :dataJulgado, :resultado, :notificacao, :observacoes )");

            $novoProcesso->bindValue(":codigoProcesso", $codigoProcesso);
            $novoProcesso->bindValue(":anoProcesso", $anoProcesso, PDO::PARAM_STR);
            $novoProcesso->bindValue(":placa", $placa, PDO::PARAM_STR);
            $novoProcesso->bindValue(":tipoVeiculo", $tipoVeiculo);
            $novoProcesso->bindValue(":dataDenuncia", $dataDenuncia, PDO::PARAM_STR);
            $novoProcesso->bindValue(":dataDefesa", $dataDefesa, PDO::PARAM_STR);
            $novoProcesso->bindValue(":dataRelatorio", $dataRelatorio, PDO::PARAM_STR);
            $novoProcesso->bindValue(":dataJulgamento", $dataJulgamento, PDO::PARAM_STR);
            $novoProcesso->bindValue(":dataJulgado", $dataJulgado, PDO::PARAM_STR);
            $novoProcesso->bindValue(":resultado", $resultado, PDO::PARAM_STR);
            $novoProcesso->bindValue(":notificacao", $notificacao, PDO::PARAM_STR);
            $novoProcesso->bindValue(":observacoes", $observacoes, PDO::PARAM_STR);

            $novoProcesso->execute();
            // echo $novoUsuario->rowCount();
            //var_dump($novoUsuario);

            auditoria("Processo id ".$conexao->lastInsertId()." Inserida" );
            $retorno = 'inserido';
        } catch (Exception $e) {
            echo $e;
            exit($e);
        }
    } else {
        try {
            $atualizarProcesso = $conexao->prepare("UPDATE processo SET  cd_processo = :codigoProcesso, aa_processo = :anoProcesso, cd_placa = :placa, cd_modalidade = :tipoVeiculo, dt_relato_denuncia = :dataDenuncia, dt_apresentacao_defesa = :dataDefesa, dt_apresentacao_relatorio = :dataRelatorio, dt_inicio_julgamento = :dataJulgamento, dt_julgado = :dataJulgado, ds_resultado = :resultado, dt_notificacao = :notificacao, ds_observacoes_processos = :observacoes "
                    . "WHERE id_processo = :id");

            $atualizarProcesso->bindValue(":codigoProcesso", $codigoProcesso);
            $atualizarProcesso->bindValue(":anoProcesso", $anoProcesso, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":placa", $placa, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":tipoVeiculo", $tipoVeiculo);
            $atualizarProcesso->bindValue(":dataDenuncia", $dataDenuncia, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":dataDefesa", $dataDefesa, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":dataRelatorio", $dataRelatorio, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":dataJulgamento", $dataJulgamento, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":dataJulgado", $dataJulgado, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":resultado", $resultado, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":notificacao", $notificacao, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":observacoes", $observacoes, PDO::PARAM_STR);
            $atualizarProcesso->bindValue(":id", $id);
            $atualizarProcesso->execute();

//                echo $atualizarUsuario->rowCount();
//                var_dump($atualizarUsuario);
//                echo $atualizarUsuario->errorCode();
//                exit();
            auditoria("Dados do processo id ".$id." atualizados" );
            $retorno = 'alterado';
        } catch (Exception $e) {
            echo $e;
            exit();
        }

    }

   if ($retorno) {
        header('Location: index.php?retorno=' . $retorno);
    } else {
        header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=novo&retorno=invalido');
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
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Processos</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1><strong>Processos</strong></h1>
                </div>

                <div class="container">

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados do processo</h4>

                        </div>
                        <div class="panel-body collapse in" >

                            <form id="formProcesso" name="formProcesso"  action="gerencia.php" method="post"  class="form-horizontal" />
                            <input type="hidden" name="id_processo" id="id_processo" value="<?php echo($id); ?>">
                            

                              <div class="row">
                                <div class="col-md-3">
                                  <label><strong>Número do Processo</strong></label>

                                      <input style="color:blue;height:50px; font-size:30px" type="number" name="cd_processo" id="cd_processo" class="form-control" value="<?php echo($codigoProcesso); ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required>
                                  </div>
                                  <div class="col-md-2">
                                      <label><strong>Ano do Processo</strong></label>
                                        <input style="color:blue;height:50px; font-size:30px" name="aa_processo" id="aa_processo" type="text" class="form-control"  value="<?php echo $anoProcesso ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> pattern="[0-9]{4}" title="No minimo quatro caracteres (Apenas numeros)." required/>
                                      </div>
                                </div></br>

                              <div class="row">

                                <div class="col-md-2">
                              <label><strong>Placa do Veiculo</strong></label>
                                  <select name="cd_placa" id="cd_placa" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                          <option value='' >Placa..</option>
                                          <?php
                                          try {
                                              $placasVeiculo = $conexao->prepare("SELECT * FROM veiculo");
                                              $placasVeiculo->execute();
                                          } catch (Exception $e) {
                                              echo $e;
                                              exit();
                                          }
                                          ?>
                                          <?php while ($placas = $placasVeiculo->fetch(PDO::FETCH_ASSOC)) { ?>
                                              <option value='<?php echo $placas['cd_placa']; ?>' <?php echo ($placas['cd_placa']== $placa) ? 'selected' : ''; ?>><?php echo $placas['cd_placa']; ?>  </option>
                                          <?php } ?>
                                      </select>
                                  </div>


                                <?php if ($acao != 'novo') { ?>
                                <div class="col-md-4">
                                <label><strong>Tipo do Serviço</strong></label>
                                    <select name="cd_modalidade" id="cd_modalidade" class="form-control" disabled="disabled" required>
                                        <?php
                                        try {
                                            $tipoServicos = $conexao->prepare("SELECT DISTINCT c.cd_modalidade, t.nm_modalidade FROM veiculo c , tipoVeiculo t where c.cd_placa = '$placa' AND c.cd_modalidade = t.cd_modalidade");
                                            $tipoServicos->execute();


                                        } catch (Exception $e) {
                                            echo $e;
                                            exit();
                                        }
                                        ?>
                                        <?php while ($tipoServico = $tipoServicos->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value='<?php echo $tipoServico['cd_modalidade']; ?>' selected><?php echo $tipoServico['nm_modalidade']; ?>  </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <div class="col-md-2">
                                    <label><strong>Data do Relato/Denuncia</strong></label>

                                      <input name="dt_relato_denuncia" id="dt_relato_denuncia" type="date" class="form-control"  value="<?php echo $dataDenuncia ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> required/>
                                  </div>

                            </div></br>

                            <div class="row">




                            <div class="col-md-2">
                                <label><strong>Apresentação da defesa</strong></label>

                                    <input name="dt_apresentacao_defesa" id="dt_apresentacao_defesa" type="date" class="form-control"  value="<?php echo $dataDefesa ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> min="<?php $dataDenuncia ?>"/>
                                </div>

                          <div class="col-md-2">
                                <label><strong>Apresentação do relatório</strong></label>

                                    <input name="dt_apresentacao_relatorio" id="dt_apresentacao_relatorio" type="date" class="form-control"  value="<?php echo $dataRelatorio ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                                <div class="col-md-2">
                                  <label><strong>Inicio do Julgamento</strong></label>
                                    <input name="dt_inicio_julgamento" id="dt_inicio_julgamento" type="date" class="form-control"  value="<?php echo $dataJulgamento ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                              </div>

                              <div class="col-md-2">
                                  <label><strong>Julgado</strong></label>

                                      <input name="dt_julgado" id="dt_julgado" type="date" class="form-control"  value="<?php echo $dataJulgado ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?>/>
                                  </div>
                            </div></br>

                            <div class="row">

                            </div></br>

                            <div class="row">
                              <div class="col-md-6">
                                <label><strong>Resultado</strong></label>
                                  <select name="ds_resultado" id="ds_resultado" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> style="height:50px; font-size:30px" >
                                        <option value='SEM RESULTADO'>-</option>
                                        <option value="ABSOLVIÇÃO" <?php echo($resultado == 'ABSOLVIÇÃO') ? 'selected' : ''; ?> style="color:blue;">ABSOLVIÇÃO</option>
                                        <option value="MULTA" <?php echo($resultado == 'MULTA') ? 'selected' : ''; ?> style="color:red;">MULTA</option>
                                        <option value="NÃO COMPARECEU" <?php echo($resultado == 'NÃO COMPARECEU') ? 'selected' : ''; ?> style="color:red;">NÃO COMPARECEU</option>
                                        <option value="JUSTIFICADO" <?php echo($resultado == 'JUSTIFICADO') ? 'selected' : ''; ?>style="color:blue;">JUSTIFICADO</option>
                                        <option value="ADVERTENCIA" <?php echo($resultado == 'ADVERTENCIA') ? 'selected' : ''; ?>style="color:green;">ADVERTENCIA</option>
                                        <option value="SUSPENSÃO" <?php echo($resultado == 'SUSPENSÃO') ? 'selected' : ''; ?> style="color:red;">SUSPENSÃO</option>
                                        <option value="CASSAÇÃO" <?php echo($resultado == 'CASSAÇÃO') ? 'selected' : ''; ?>style="color:red;">CASSAÇÃO</option>
                                    </select>
                                </div>

                              <div class="col-md-2">
                                <label><strong>Notificado</strong></label>

                                    <input name="dt_notificacao" id="dt_notificacao" type="date" class="form-control"  value="<?php echo $notificacao ?>" <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> />
                                </div>
                            </div></br>

                            <div class="row">
                              <div class="col-md-8">
                                <label><strong>Observações</strong></label>
                                <textarea name="ds_observacoes_processos" id="ds_observacoes_processos" class="form-control" rows="4" cols="50"
                                <?php if ($acao == 'visualizar') { ?>readonly="readonly" <?php }; ?> ><?php echo $observacoes ?></textarea>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-5">
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
