<?php
include '../include/head.php';
include '../include/funcoes.php';
include '../include/conexao/conecta.php';
validaAcesso();


if (isset($_GET['acao']) && $_GET['acao'] != '') {

    $acao = $_GET['acao'];

    $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
    $id = base64_decode($id);

    if ($acao == 'excluir') {

        if ($_SESSION['cdUsuario'] == $id) {
            echo "<script>alert('Não é posivel deletar seu próprio usuario!');
                location.href=\"index.php\"</script>";
        } else {

            $deleta = mysqli_query($conexao, "DELETE FROM usuario WHERE id_usuario = '$id'");

            if ($deleta == '') {
                echo "<script>alert('Houve um erro ao deletar!');
                location.href=\"index.php\"</script>";
            } else {
                echo "<script>alert('Registro excluido com sucesso!');
                   location.href=\"index.php\"</script>";
            }
        }
    }

    if ($acao == 'visualizar' || $acao == 'editar') {
        $sql = "SELECT * FROM usuario WHERE id_usuario = " . $id;
        $linha = mysqli_query($conexao, $sql);
        $usuario = mysqli_fetch_assoc($linha) or die(mysql_error());

        $id = $usuario['id_usuario'];
        $nome = $usuario['nm_usuario'];
        $ativo = $usuario['ds_ativo'];
        $permissao = $usuario['ds_permissao'];
    }

    if ($acao == 'novo') {

        $id = 0;
        $nome = "";
        $ativo = 0;
        $permissao = 0;
    }
}

if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != '') {

    $id = $_POST['idUsuario'];
    $ativo = isset($_POST['ativo']) ? '1' : '0';
    $permissao = $_POST['permissao'];
    $usuario = addslashes($_POST['usuario']);


    //$senhaAtual = md5(addslashes($_POST['senhaAtual']));
    $novaSenha = md5(addslashes($_POST['novaSenha']));
    $confSenha = md5(addslashes($_POST['confSenha']));


    if (empty($id)) {
        $usuario = addslashes($_POST['usuario']);
        $sqlusuario = "SELECT * FROM usuario where nm_usuario = '$usuario'";

        $nomeUsuarios = mysqli_query($conexao, $sqlusuario);
        $nomeUsuario = mysqli_fetch_assoc($nomeUsuarios);



        if ($nomeUsuario > 0) {
            $retornoNome = 'nomeinvalido';
        } else {
            if ($novaSenha == $confSenha) {
                $sqlUsuario = "INSERT INTO usuario (nm_usuario, ds_senha, ds_ativo, ds_permissao) "
                        . "VALUES ('" . $usuario . "', '" . $novaSenha . "', " . $ativo . ", " . $permissao . ")";
                echo $sqlUsuario;
                $res = mysqli_query($conexao, $sqlUsuario) or die(mysqli_error($conexao));
                $retorno = 'inserido';
            } else {
                header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=editar&erro=invalido');
            }
        }
    } else {
        $sqlUsuario = "UPDATE usuario SET nm_usuario = '" . $usuario . "', ds_ativo = " . $ativo . ", ds_permissao = " . $permissao . " "
                . "WHERE id_usuario = " . $id;

        $res = mysqli_query($conexao, $sqlUsuario) or die(mysqli_error());
        $retorno = 'alterado';

        if (!empty($novaSenha)) {
            if ($novaSenha != 'd41d8cd98f00b204e9800998ecf8427e') {
                $linha = mysqli_query($conexao, "SELECT ds_senha FROM usuario WHERE id_usuario = " . $id);
                $senha = mysqli_fetch_assoc($linha);

                $senhaAtual = md5(addslashes($_POST['senhaAtual']));


                if ($senha['ds_senha'] == $senhaAtual && $novaSenha == $confSenha) {

                    $sqlSenha = "UPDATE usuario SET ds_senha = '" . $novaSenha . "' WHERE id_usuario = " . $id;
                    $res = mysqli_query($conexao, $sqlSenha) or die(mysqli_error());
                    $retorno = 'alterado';
                } else {
                    header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=editar&retorno=invalido');

                    exit();
                }
            }
        }
    }if ($retornoNome) {
        header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=novo&retorno=nomeinvalido');
    } else {
        if ($retorno) {
            header('Location: index.php?retorno=' . $retorno);
        } else {
            header('Location: gerencia.php?id=' . base64_encode($id) . '&acao=novo&retorno=invalido');
        }
    }
}
?>
<script>alertaSucesso("a", "a", "a")</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type='text/javascript' src='../assets/js/mascara.js'></script>
<body class="">
    <?php include '../include/header.php'; ?>
    
    <div id="page-container">

        <?php include '../include/menu.php'; ?>

        <?php
        if ($_SESSION['permissao'] != 1) {
            echo '<script>alert("Acesso Restrito!' . '\n' . 'Você será redirecionado para a tela inicial!");
                   location.href="../home.php"</script>';
        }
        ?> 
        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a> > <a href="index.php">Usuarios</a> > <?php echo $acao ?></li>

                    </ol>
                    <h1>Usuarios</h1>            
                </div>       

                <div class="container">               

                    <div class="panel panel-midnightblue">

                        <div class="panel-heading">
                            <h4>Dados do usuario</h4>

                        </div>
                        <div class="panel-body collapse in">
                            <form id="formUsuario" name="formUsuario" action="gerencia.php" method="post"  class="form-horizontal" />
                            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo($id); ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ativo</label>
                                <div class="col-sm-4">
                                    <label class="checkbox-inline">
                                        <input name="ativo" id="ativo" <?php echo($ativo == '1') ? 'checked' : ''; ?> <?php if ($acao == 'visualizar') { ?>disabled="disabled"  <?php }; ?> type="checkbox" value="1"> 
                                    </label>

                                </div>
                            </div>    
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Perfil</label>
                                <div class="col-sm-4">
                                    <select name="permissao" id="permissao" class="form-control" <?php if ($acao == 'visualizar') { ?>disabled="disabled" <?php }; ?> required>
                                        <option value=''>Perfil...</option>
                                        <option value="1" <?php echo($permissao == '1') ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="2" <?php echo($permissao == '2') ? 'selected' : ''; ?>>Gerente</option>
                                        <option value="3" <?php echo($permissao == '3') ? 'selected' : ''; ?>>Funcionario</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Pessoa</label>
                                <div class="col-sm-4">
                                    <input name="pessoa" id="pessoa" type="text" class="form-control"  value="<?php echo $nome ?>"  readonly="readonly"/>
                                </div>
                            </div>
                            <?php if (isset($_GET['retorno']) && $_GET['retorno'] == 'nomeinvalido') { ?>
                                <div class="form-group ">   
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="alert alert-dismissable alert-danger col-sm-4 ">
                                        <strong>Usuario já cadastrado</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Usuario</label>
                                <div class="col-sm-4">
                                    <input name="usuario" id="usuario" type="text" onkeyup="mascara( this, alphanum )" title="Somente letras ou numeros" class="form-control"  value="<?php echo $nome ?>" <?php if ($acao == 'visualizar' || $acao == 'editar') { ?>readonly="readonly" <?php }; ?> required/>
                                   
                                </div>
                            </div>

                            <?php if (isset($_GET['retorno']) && $_GET['retorno'] == 'invalido') { ?>
                                <div class="form-group ">   
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="alert alert-dismissable alert-danger col-sm-4 ">
                                        <strong>Senhas digitadas não conferem</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    </div>
                                </div>
                                <?php
                            }
                            if ($acao != 'visualizar') {
                                if (!empty($id) && $_GET['acao'] == 'editar') {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Senha Atual</label>
                                        <div class="col-sm-4">
                                            <input name="senhaAtual" id="senhaAtual" type="password" class="form-control" onkeyup="mascara( this, alphanum ) "pattern=".{3,}" title="Três ou mais caracteres(Letras ou numeros)"/>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Senha</label>
                                    <div class="col-sm-4">
                                        <input name="novaSenha" id="novaSenha" type="password" class="form-control" <?php if ($acao == 'novo') { ?>required <?php }; ?> onkeyup="mascara( this, alphanum ) "pattern=".{3,}" title="Três ou mais caracteres(Letras ou numeros)"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Confirmar senha</label>
                                    <div class="col-sm-4">
                                        <input name="confSenha" id="confSenha" type="password" class="form-control" <?php if ($acao == 'novo') { ?>required <?php }; ?> onkeyup="mascara( this, alphanum ) "pattern=".{3,}" title="Três ou mais caracteres(Letras ou numeros)"/>
                                    </div>
                                </div> 



                            <?php } ?>

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
