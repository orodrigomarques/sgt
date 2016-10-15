<?php
include '../include/conexao/conecta.php';
include '../include/head.php';
include '../include/funcoes.php';
validaAcesso();

if (isset($_GET['retorno']) && $_GET['retorno'] == 'inserido') {

    echo "<script>alert('Registro inserido com sucesso!');
                   location.href=\"index.php\"</script>";
}

if (isset($_GET['retorno']) && $_GET['retorno'] == 'alterado') {

    echo "<script>alert('Registro alterado com sucesso!');
                   location.href=\"index.php\"</script>";
}
//WHERE
$where = '';
$processo = '';
$aa_processo = '';


if (isset($_POST['nm_modalidade']) && !empty($_POST['nm_modalidade'])) {
    $tipo_veiculo = addslashes($_POST['nm_modalidade']);
    $tipo_veiculo = str_replace('\\', '', $tipo_veiculo);
    if($where!=''){
    $where .= " and nm_modalidade LIKE '%$tipo_veiculo%'";}
    else{
        $where .= " WHERE nm_modalidade LIKE '%$tipo_veiculo%'";
    }
}
if (isset($_POST['processo']) && !empty($_POST['processo'])) {
    $processo = $_POST['processo'];
    

    $where .= " WHERE cd_processo = $processo";
}

if (isset($_POST['aa_processo']) && !empty($_POST['aa_processo'])) {
    $aa_processo = addslashes($_POST['aa_processo']);
    $aa_processo = str_replace('\\', '', $aa_processo);
    if($where!=''){
    $where .= " and aa_processo LIKE '%$aa_processo%'";}
    else{
        $where .= " WHERE aa_processo LIKE '%$aa_processo%'";
    }
}

if (isset($_POST['dt_relato_denuncia']) && !empty($_POST['dt_relato_denuncia'])) {
    $denuncia = ($_POST['dt_relato_denuncia']);
    if($where!=''){
    $where .= " and dt_relato_denuncia LIKE '%$denuncia%' ";
    }else{
        $where .= " WHERE dt_relato_denuncia LIKE '%$denuncia%'";
    }
}

if (isset($_POST['ds_resultado']) && !empty($_POST['ds_resultado'])) {
    $resultado = ($_POST['ds_resultado']);
    if($where!=''){
    $where .= " and ds_resultado LIKE '%$resultado%' ";
    }else{
        $where .= " WHERE ds_resultado LIKE '%$resultado%'";
    }
}




// PAGINAÇÃO
$pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
$registros = 20;

$inicio = ($pagina - 1) * $registros;
$fim = $registros; //$pagina * $registros;

$limit = " LIMIT $inicio, $fim";

$sqlcount = "SELECT count(*) as qtd " .
        "FROM processo " .
        $where;
$qtd = mysqli_fetch_assoc(mysqli_query($conexao, $sqlcount));

$ultima_pagina = ceil((int) $qtd['qtd'] / $registros);
//--


$sql_processos = "SELECT * FROM processo " .
        $where .
        " ORDER BY cd_processo ASC " .
        $limit;
    $sql_tipoveiculos =     "SELECT * FROM tipoVeiculo ".
                        $where.			
			" ORDER BY nm_modalidade ASC ".
			$limit;   
    
$tipoveiculos = mysqli_query($conexao, $sql_tipoveiculos);
$processos = mysqli_query($conexao, $sql_processos);
$dataRelatos = mysqli_query($conexao, $sql_processos);
?>


<body class="">
    <?php include '../include/header.php'; ?>

    <div id="page-container">

        <?php include '../include/menu.php'; ?>

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a> > Processos</li>
                    </ol>
                    <h1>Processos</h1>  
                    <div class="options">
                        <div class="btn-toolbar">
                            <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Novo Processo</a>
                        </div>
                    </div>
                </div>      
                <div class="container">               
                    <div class="container">		
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Exibindo Procesos cadastrados</h4>										
                                    </div>

                                    <div class="panel-body collapse in">
                                        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                            <form name="processos" method="POST" id="processos">
                                                <div class="col-sm-2">                                                    
                                                        <select name="nm_modalidade" id="nm_modalidade" class="form-control">
                                                            <option value='' >Tipo do Serviço...</option>
                                                            <?php while ($tipoveiculo = mysqli_fetch_assoc($tipoveiculos)) { ?>
                                                                <option value='<?php echo $tipoveiculo['nm_modalidade']; ?>'><?php echo $tipoveiculo['nm_modalidade']; ?></option>
                                                            <?php } ?>                                              
                                                        </select>
                                                    </div>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="processo" placeholder="Nº do processo" value="<?php echo($processo); ?>" type="number">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input class="form-control" name="aa_processo" id="aa_processo" placeholder="Ano do Processo" value="<?php echo($aa_processo); ?>" type="text" minlength="4">
                                                    </div>

                                                    <div class="col-sm-2">                                                    
                                                        <select name="dt_relato_denuncia" id="dt_relato_denuncia" class="form-control">
                                                            <option value='' >Data...</option>
                                                            <?php while ($dataRelato = mysqli_fetch_assoc($dataRelatos)) { ?>
                                                                <option value='<?php echo $dataRelato['dt_relato_denuncia']; ?>'><?php echo strftime('%d/%m/%y', strtotime($dataRelato['dt_relato_denuncia'])); ?></option>
                                                            <?php } ?>                                              
                                                        </select>
                                                    </div>
                                                    

                                                    <div class="col-sm-2">                                                    
                                                        <select name="ds_resultado" id="ds_resultado" class="form-control">
                                                            <option value=''>Resultado...</option>
                                                            <option value='ABSOLVIÇÃO' >ABSOLVIÇÃO</option>
                                                            <option value="MULTA" >MULTA</option>
                                                            <option value="NÃO COMPARECEU" >NÃO COMPARECEU</option>
                                                            <option value="JUSTIFICADO" >JUSTIFICADO</option>
                                                            <option value="ADVERTENCIA" >ADVERTENCIA</option>
                                                            <option value="SUSPENSÃO" >SUSPENSÃO</option>
                                                            <option value="CASSAÇÃO" >CASSAÇÃO</option>
                                                        </select> 
                                                    </div>



                                                    <div class="col-xs-1">
                                                        <button style="float:left" class="btn-primary btn">Buscar</button>
                                                    </div><br /><br /><br />
                                                </div>
                                            </form>

                                            <?php if (mysqli_num_rows($processos) > 0) { ?>
                                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable" id="example" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Tipo do seviço</th>		
                                                            
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Nº do processo</th>		
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Ano do Processo</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Data Rel. Denuncia</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Resultado</th>                                                      
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                        <?php while ($processo = mysqli_fetch_assoc($processos)) { ?>
                                                            <tr class="gradeA odd">
                                                                <td style="width:20%" class=""><?php echo($processo['nm_modalidade']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                                <td style="width:10%" class=""><?php echo($processo['cd_processo']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>


                                                                <td style="width:10%" class=""><?php echo $processo['aa_processo']; ?></td>
                                                                <td style="width:20%" class=""><?php echo strftime('%d/%m/%y', strtotime($processo['dt_relato_denuncia'])); ?></td>
                                                                <td style="width:5%" class=""><?php echo $processo['ds_resultado']; ?></td>
                                                                <td style="width:40%" class="center">
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($processo['id_processo']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($processo['id_processo']); ?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($processo['id_processo']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($processo['id_processo']); ?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>
        <!--                                                                    <a onClick="buscaUsuario('<?php echo($processo['cd_processo']); ?>');location.href='gerencia.php?acao=visualizar&id_usuario=<?php echo $usuario['id_usuario']; ?>'" class="btn btn-success"><i class="icon-trash">&nbsp;&nbsp;Visualizar</i> </a>-->
                                                                    <a onClick="if (confirm('Tem certeza que deseja excluir este registro?')) {
                                                                                location.href = 'gerencia.php?acao=excluir&id=<?php echo base64_encode($processo['id_processo']); ?>'
                                                                            }" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                </td>
                                                            </tr>
    <?php } ?>
                                                    </tbody>
                                                </table>

                                                <div style="float:left">
                                                    &nbsp;<?php echo($qtd['qtd']); ?> registros encontrados.
                                                </div>
                                            <?php } else { ?>
                                                <div style="margin-left:10px">Nenhum documeto encontrado.</div>
<?php } ?>
                                        </div>		



                                        <div class="tab-pane active" style="text-align:right;" id="dompaginate">
                                            <ul class="pagination">

                                                <li><a href="?pagina=1&nome=<?php echo($processo); ?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>

                                                <?php
                                                $inicio_paginacao = ($pagina - 2 < 1) ? 1 : $pagina - 2;

                                                if ($pagina > 1) {
                                                    ?>
                                                    <li><a href="?pagina=<?php echo($pagina - 1); ?>&nome=<?php echo($processo); ?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } else { ?>
                                                    <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } ?>

                                                <?php
                                                for ($i = $inicio_paginacao; $i < $inicio_paginacao + 5; $i++) {
                                                    if ($i <= $ultima_pagina) {
                                                        ?>
                                                        <li<?php echo ($pagina == $i) ? ' class="active"' : ''; ?>><a href="?pagina=<?php echo($i); ?>&nome=<?php echo($processo); ?>"><?php echo($i); ?></a></li>
    <?php } ?>
<?php } ?>
                                                <li <?php echo($pagina >= $ultima_pagina) ? 'class="disabled"' : '' ?>><a href="?pagina=<?php echo($pagina + 1); ?>&nome=<?php echo($processo); ?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                                <li><a href="?pagina=<?php echo($ultima_pagina); ?>&nome=<?php echo($processo); ?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                                <div style="margin-left:30px;width:100px;float:left;">
                                                    <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina); ?>" style="float:left;width:50px">
                                                    <a onclick="location.href = '?pagina=' + $('#pagina_ir').val() + '&nome=<?php echo($processo); ?>'" style="float:left;" class="btn btn-muted btn-default">Ir</a>
                                                </div>                                
                                            </ul>
                                        </div>            
                                    </div>
                                </div>
                            </div>            
                        </div>
                    </div> <!-- container -->     
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
    <script type='text/javascript' src='../assets/js/jqueryui-1.10.3.min.js'></script> 
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

