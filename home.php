<!DOCTYPE html>
<html lang="en">
    <?php
include 'include/conexao/conecta.php';
include 'include/head.php';
include 'include/funcoes.php';
validaAcesso();
$conexao = conecta();

//WHERE

$placaVeiculo = '';


if (isset($_POST['cd_placa']) && !empty($_POST['cd_placa'])) {
    $placaVeiculo = $_POST['cd_placa'];
}

//End WHERE
// PAGINAÇÃO
$pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
$registros = 10;
$inicio = ($pagina - 1) * $registros;
$fim = $registros; //$pagina * $registros;
$limit = "LIMIT $inicio, $fim";
try {
    $contador = $conexao->prepare("SELECT count(*) as qtd FROM veiculo "
            . "WHERE cd_placa LIKE  :placaVeiculo "
            .  " " . $limit);
   
    $contador->bindValue(":placaVeiculo", '%' . $placaVeiculo . '%');
    $contador->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}
$qtd = $contador->fetch(PDO::FETCH_ASSOC);
$ultima_pagina = ceil((int) $qtd['qtd'] / $registros);
//End PAGINAÇÃO

if (isset($_POST['cd_placa']) && !empty($_POST['cd_placa'])) {
try {
    $veiculos = $conexao->prepare("SELECT * FROM veiculo "
            . "WHERE cd_placa LIKE  :placaVeiculo            
           " . " ORDER BY cd_placa ASC " . $limit);
   
    $veiculos->bindValue(":placaVeiculo", '%' . $placaVeiculo . '%');
    $veiculos->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}}
?>

<body class="">
    <?php include 'include/header.php'; ?>

    <div id="page-container">

        <?php include 'include/menu.php'; ?>

    
    
	<head>
		
                <link href="./assets/css/easy-autocomplete.min.css" rel="stylesheet" type="text/css">
                <script src="./assets/js/jquery-1.11.2.min.js"></script>
                <script src="./assets/js/jquery.easy-autocomplete.min.js" type="text/javascript" ></script>
	</head>
	<body>
 <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="../home.php">Home</a></li>
                    </ol><div align="center">
                    <img width="300px" height="200px"  src="/assets/img/sgt_logo.png"/> </div>
                    
                </div>   
                 <div class="panel-body collapse in">
                     <form name="veiculos" method="POST" id="veiculos">
                                                
                                                <div class="row">
                                                    
                                                    <div class="col-xs-10">
                                                        <input id="cd_placa" class="form-control" name="cd_placa" placeholder="Placa" value="<?php echo($placaVeiculo); ?>" type="text">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <button style="float:left" class="btn-primary btn">Buscar</button>
                                                    </div><br /><br /><br />
                                                </div>
                                            </form>                 
<script>

		var options = {
			url: function(phrase) {
				return "include/veiculoSearch.php?phrase=" + phrase + "&format=json";
			},

			getValue: "name",
		};

		$("#cd_placa").easyAutocomplete(options);

		</script>
                     
                     
                                     
                                            <div class="container">               
                    <div class="container">		
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                   

                                            
                                            <?php if(isset($_POST['cd_placa']) && !empty($_POST['cd_placa'])) {?> 
                                    
                                            <?php if ($veiculos->rowCount() > 0) { ?>
                                             <div class="panel-heading">
                                        <h4>Exibindo Veiculos cadastrados</h4>										
                                    </div>
                                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable sortable" id="example" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Modelo</th>		
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:50px;">Placa</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:50px;">Tipo de Serviço</th>
                                                            <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:50px;">Opções</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                        <?php while ($veiculo = $veiculos->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr class="gradeA odd">
                                                                <td style="width:10%" class=""><?php echo($veiculo['nm_modelo']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td style="width:10%" class=""><?php echo($veiculo['cd_placa']); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <?php
                                                                try {
                                                                    $tipoServicos = $conexao->prepare("SELECT * FROM  tipoVeiculo");
                                                                    $tipoServicos->execute();
                                                                } catch (Exception $e) {
                                                                    echo $e;
                                                                    exit();
                                                                }
                                                                ?>
                                                                <?php while ($tipoServico = $tipoServicos->fetch(PDO::FETCH_ASSOC)) {
                                                                    if ($tipoServico['cd_modalidade'] == $veiculo['cd_modalidade']) {
                                                                        ?>
                                                                        <td style="width:10%" class=""><?php echo $tipoServico['nm_modalidade']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php }
        } ?>
                                                                <td style="width:23%" class="center">
                                                                    <a href="./veiculo/gerencia.php?id=<?php echo base64_encode($veiculo['cd_veiculo']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($veiculo['cd_veiculo']); ?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="./veiculo/gerencia.php?id=<?php echo base64_encode($veiculo['cd_veiculo']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($veiculo['cd_veiculo']); ?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>
        <!--                                                                    <a onClick="buscaUsuario('<?php echo($veiculo['cd_veiculo']); ?>');location.href='gerencia.php?acao=visualizar&id_usuario=<?php echo $veiculo['cd_veiculo']; ?>'" class="btn btn-success"><i class="icon-trash">&nbsp;&nbsp;Visualizar</i> </a>-->
                                                                    <a onClick="if (confirm('Tem certeza que deseja excluir este registro?')) {
                                                                                        location.href = './veiculo/gerencia.php?acao=excluir&id=<?php echo base64_encode($veiculo['cd_veiculo']); ?>'
                                                                                    }" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                    <td style="width:1%" class="center">
                                                                    <form name="multas" method="POST" id="multas" action="../multa/index.php">
                                                                        <input type="hidden" name="cd_placa" value="<?php echo $veiculo['cd_placa']; ?>" />    
                                                                        <button class="btn btn-default" ><i class="icon-eye-open">Ver Multas</i></button></form>
                                                                    </td>
                                                                                                                                        <td style="width:1%" class="center">

                                                                        <form name="processos" method="POST" id="processos" action="../processo/index.php">
                                                                        <input type="hidden" name="cd_placa" value="<?php echo $veiculo['cd_placa']; ?>" />    
                                                                        <button class="btn btn-default" ><i class="icon-eye-open">Ver Processos</i></button></form>
                                                                        </td>
                                                                </td>
                                                            </tr>


    <?php } ?>                                                    </tbody>
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

                                                <li><a href="?pagina=1&nome=<?php echo($modelo); ?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>

                                                <?php
                                                $inicio_paginacao = ($pagina - 2 < 1) ? 1 : $pagina - 2;
                                                if ($pagina > 1) {
                                                    ?>
                                                    <li><a href="?pagina=<?php echo($pagina - 1); ?>&nome=<?php echo($modelo); ?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } else { ?>
                                                    <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                                <?php } ?>

                                                <?php
                                                for ($i = $inicio_paginacao; $i < $inicio_paginacao + 5; $i++) {
                                                    if ($i <= $ultima_pagina) {
                                                        ?>
                                                        <li<?php echo ($pagina == $i) ? ' class="active"' : ''; ?>><a href="?pagina=<?php echo($i); ?>&nome=<?php echo($modelo); ?>"><?php echo($i); ?></a></li>
    <?php } ?>
<?php } ?>
                                                <li <?php echo($pagina >= $ultima_pagina) ? 'class="disabled"' : '' ?>><a href="?pagina=<?php echo($pagina + 1); ?>&nome=<?php echo($modelo); ?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                                <li><a href="?pagina=<?php echo($ultima_pagina); ?>&nome=<?php echo($modelo); ?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                                <div style="margin-left:30px;width:100px;float:left;">
                                                    <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina); ?>" style="float:left;width:50px">
                                                    <a onclick="location.href = '?pagina=' + $('#pagina_ir').val() + '&nome=<?php echo($modelo); ?>'" style="float:left;" class="btn btn-muted btn-default">Ir</a>
                                                </div>  <?php } ?>                               
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

<?php include 'include/footer.php'; ?>

    </div> <!-- page-container -->
    <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 


<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 



<script type='text/javascript' src='assets/js/application.js'></script> 

</body>
</html>
