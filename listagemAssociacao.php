<!--BY SHIELD--->
<?php 
if(!isset($_SESSION)){session_start();//echo $_SESSION['nomeUuario'];
                           }
if(empty($_SESSION['nomeUuario'])){

 header("Location: login.php?erro=aut");
}

?>
<?php
    require_once 'include/conexao/conecta.php';
    require_once 'include/conexao/crud.class.php';

    $con = new conexao(); // instancia classe de conxao
    $con->connect(); // abre conexao com o banco
?>
  <!DOCTYPE html>
  <html>

<head>
	<?php include 'include/head.php';?>


    <?php include 'include/header.php';?>

    <div id="page-container">
       
        <?php include 'include/menu.php';?>
			<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
<!--                 <li class='active'><a href="index.php">Dashboad</a></li> -->
            </ol>
<!--             <h1>Dashboard</h1>             -->
        </div>       

        <div class="container">               
          	
		<div class="col-sm-3">
			<h2>Associcações cadastradas</h2>
		</div>
		<div class="col-sm-6">
			<form name="frmBusca" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?a=buscar">
				<div class="input-group h2">
					<input name="palavra" class="form-control" id="search" type="text" 
								 placeholder="Pesquisar associações por Razao Social">
					<span class="input-group-btn">
					<button class="btn btn-primary" type="submit">
						<span class="glyphicon glyphicon-search"></span>BUSCAR
					</button>
					</span>
				</div>
			</form>
		</div>
		<div class="col-sm-3">

			<a href="associacao.php" class="btn btn-primary pull-right h2">
            Novo 
        </a>
		</div>
	
	<script type="text/javascript">
function deletaDado (idDado){
    //seta o caminho para quando clicar em "Apagar".
    var href = $('#confirmaDelecao')[0]+ '/SGT/excluir.php?id=' + idDado;
    //adiciona atributo de delecao ao link
    $('#confirmaDelecao').prop("href", href);
}
</script>
<div id="deletar-dado" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Confirmação</h4>
        </div>
        <div class="modal-body">
            <p>Deseja realmente excluir este registro?</p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <a class="btn btn-primary" id="confirmaDelecao" class="btn red">Apagar</a>
        </div>
    </div>
</div>
				</div>

	<hr/>
<!-- 	<div id="list" class="row">

		<div class="table-responsive col-md-12"> -->
		<?php if(isset($_GET['a'])==null){ ?>
						
		<table class="table table-striped" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>
              Razao
            </th>
            <th>
              Cep
            </th>
            <th>
              Logradouro
            </th>
            <th>
              Bairro
            </th>
            <th>
              Numero
            </th>
            <th>
              Complemento
            </th>
            <th>
              Cidade
            </th>
            <th>
              Estado
            </th>
            <th>
              Telefone
            </th>
            <th>
              Email
            </th>
            <th>
              Linha
            </th>
            <th colspan=2>
              Ações 
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
                    $consulta = mysql_query("SELECT * FROM associacao "); // query que busca todos os dados da tabela associacao
                    while($campo = mysql_fetch_array($consulta)){ 
											// laço de repetiçao que vai trazer todos os resultados da consulta
                ?>
            <tr>
              <td>
                <?php echo $campo['razao']; // mostrando o campo RAZAO da tabela ?>
              </td>
              <td>
                <?php echo $campo['cep']; // mostrando o campo CEP da tabela ?>
              </td>
              <td>
                <?php echo $campo['logradouro']; // mostrando o campo LOGRADOURO da tabela ?>
              </td>
              <td>
                <?php echo $campo['bairro']; // mostrando o campo BAIRRO da tabela ?>
              </td>
              <td>
                <?php echo $campo['numero']; // mostrando o campo NUMERO da tabela ?>
              </td>
              <td>
                <?php echo $campo['complemento']; if($campo['complemento']==null)echo '-' ;
                      // mostrando o campo COMPLEMENTO da tabela ?>
              </td>
               <td>
                <?php echo $campo['cidade']; // mostrando o campo CIDADE da tabela ?>
              </td>
              <td>
                <?php echo $campo['estado']; // mostrando o campo ESTADO da tabela ?>
              </td>
              <td>
                <?php echo $campo['telefone']; // mostrando o campo TELEFONE da tabela ?>
              </td>
              <td>
                <?php echo $campo['email']; // mostrando o campo EMAIL da tabela ?>
              </td>
              <td>
                <?php echo $campo['linha']; // mostrando o campo LINHA da tabela ?>
              </td>
              <td>
                <a href="associacao.php?id=<?php echo $campo['id']; 
                      //pega o campo ID para a ediçao ?>"class="btn btn-warning btn-xs">
                                Editar</a>
                            
              </td>
              <td>
								
								<a class="btn btn-danger btn-xs" href="#deletar-dado" role="button"
									 data-toggle="modal" onclick="deletaDado(<?php echo $campo['id'] ?>)" 
									 class="deletar">Excluir</a>
								
              </td>
            </tr>
            <?php } }else{
				// Recuperamos a ação enviada pelo formulário
    $a = $_GET['a'];

// Verificamos se a ação é de busca
if ($a == "buscar") {
 
	// Pegamos a razao
	$razaoSocial = trim($_POST['palavra']);
 
	// Verificamos no banco de dados produtos equivalente a palavra digitada
	$sql = mysql_query("SELECT * FROM associacao WHERE razao LIKE '%".$razaoSocial."%'");
 
	// Descobrimos o total de registros encontrados
	$numRegistros = mysql_num_rows($sql);
 
	// Se houver pelo menos um registro, exibe-o
	if ($numRegistros != 0) {?>
	
		<table class="table table-striped" cellspacing="0" cellpadding="0">
	<?php echo "<tr>";
	echo "<th>
              Razao
            </th>
            <th>
              Cep
            </th>
            <th>
              Logradouro
            </th>
            <th>
              Bairro
            </th>
            <th>
              Numero
            </th>
            <th>
              Complemento
            </th>
            <th>
              Cidade
            </th>
            <th>
              Estado
            </th>
            <th>
              Telefone
            </th>
            <th>
              Email
            </th>
            <th>
              Linha
            </th>
            <th colspan=2>
              Ações 
            </th>";
	echo "</tr>";
		while ($campo = mysql_fetch_object($sql)) {
		echo "<tr>";
	
	 echo "<td>$campo->razao</td>" . "<td> $campo->cep</td>". "<td>$campo->logradouro</td>". "<td> $campo->bairro </td>".
		"<td> $campo->numero</td>". "<td>$campo->complemento</td>"."<td> $campo->cidade</td>". "<td>$campo->estado</td>".
		 "<td>$campo->telefone</td>". "<td>$campo->email </td>"."<td>$campo->linha </td>";?>
	<td>
                <a href="associacao.php?id=<?php echo $campo->id; 
                      //pega o campo ID para a ediçao ?>"class="btn btn-warning btn-xs">
                                Editar
                            </a>
              </td>
              <td>
								<a class="btn btn-danger btn-xs" href="#deletar-dado" role="button"
									 data-toggle="modal" onclick="deletaDado(<?php echo $campo->id ?>)" 
									 class="deletar">Excluir</a>
              </td>
					<?php
			echo "</tr>";
		
	}echo "</table>";
	// Se não houver registros
	} else {
		echo "Nenhum associação foi encontrada com a Razao Social ".$razaoSocial."";
	}
}
 }?>
        </tbody>
      </table>     
        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

    <?php include 'include/footer.php';?>

</div> <!-- page-container -->
<!-- <title>Cadastro de Associações</title> -->
		<?php
            //apenas testando a conexao
      //      if($con->connect() == true){
        //        echo 'Conectou ao BD!!';
          //  }else{
            //    echo 'Não conectou';
            //}
        ?>    
      
     
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
  <?php $con->disconnect(); // fecha conexao com o banco ?>