<!---BY SHIELD--->
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
    @$getId = $_GET['id'];  //pega id para ediçao caso exista
    if(@$getId){ //se existir recupera os dados e tras os campos preenchidos
        $consulta = mysql_query("SELECT * FROM associacao WHERE id = + $getId");
        $campo = mysql_fetch_array($consulta);
    }
    
    if(isset ($_POST['cadastrar'])){  // caso nao seja passado o id via GET cadastra 
        $razao = $_POST['razao'];  //pega o elemento com o pelo NAME
			$cep = $_POST['cep']; //pega o elemento com o pelo NAME 
			$logradouro = $_POST['logradouro']; //pega o elemento com o pelo NAME 
			$bairro = $_POST['bairro']; //pega o elemento com o pelo NAME 
			$numero = $_POST['numero']; //pega o elemento com o pelo NAME 
			$complemento = $_POST['complemento']; //pega o elemento com o pelo NAME 
			$cidade = $_POST['cidade']; //pega o elemento com o pelo NAME 
			$estado = $_POST['estado']; //pega o elemento com o pelo NAME 
			$telefone = $_POST['telefone']; //pega o elemento com o pelo NAME 
			$email = $_POST['email']; //pega o elemento com o pelo NAME 
			$linha = $_POST['linha']; //pega o elemento com o pelo NAME 
        $crud = new crud('associacao');  // instancia classe com as operaçoes crud, passando o nome da tabela como parametro
        $crud->inserir("razao,cep,logradouro,bairro,numero,complemento,cidade,estado,telefone,email,
				linha", "'$razao','$cep','$logradouro','$bairro',
				'$numero','$complemento','$cidade','$estado','$telefone','$email','$linha'"); // utiliza a funçao INSERIR da classe crud
        header("Location: listagemAssociacao.php"); // redireciona para a listagem
    }

    if(isset ($_POST['editar'])){ // caso  seja passado o id via GET edita 
        $razao = $_POST['razao'];  //pega o elemento com o pelo NAME
			$cep = $_POST['cep']; //pega o elemento com o pelo NAME 
			$logradouro = $_POST['logradouro']; //pega o elemento com o pelo NAME 
			$bairro = $_POST['bairro']; //pega o elemento com o pelo NAME 
			$numero = $_POST['numero']; //pega o elemento com o pelo NAME 
			$complemento = $_POST['complemento']; //pega o elemento com o pelo NAME 
			$cidade = $_POST['cidade']; //pega o elemento com o pelo NAME 
			$estado = $_POST['estado']; //pega o elemento com o pelo NAME 
			$telefone = $_POST['telefone']; //pega o elemento com o pelo NAME 
			$email = $_POST['email']; //pega o elemento com o pelo NAME 
			$linha = $_POST['linha']; //pega o elemento com o pelo NAME 
        $crud = new crud('associacao'); // instancia classe com as operaçoes crud, passando o nome da tabela como parametro
        $crud->atualizar("razao='$razao',cep='$cep',logradouro='$logradouro'
				,bairro='$bairro',numero='$numero',complemento='$complemento'
				,cidade='$cidade',estado='$estado',telefone='$telefone'
				,email='$email',linha='$linha'", "id='$getId'"); // utiliza a funçao ATUALIZAR da classe crud
        header("Location: listagemAssociacao.php"); // redireciona para a listagem
    }

?>
	<!DOCTYPE html>
	<html lang="pt-br">

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

       <div id="main" class="col-sm-3">
			<h3 class="page-header">Cadastro de Associações</h3>
		</div>

		


			<script src="js/mascaraCpf-Tel.js"></script>

			<script src="js/pesquisaCep.js"></script>

			<form action="" method="POST">

				<div class="row">
					<div class="form-group col-md-6">
						<label for="InputRazao">Razao Social:</label>
						<input type="text" name="razao" id="razao" class="form-control" maxlength="45" required value="<?php echo @$campo['razao'];?>" />
					</div>
				</div>


				<label>Cep:
      <input type="text" name="cep" id="cep" class="form-control"  maxlength="9"
               onblur="pesquisacep(this.value);" value="<?php echo @$campo['cep'];?>" /></label>

				<label>Logradouro:
      <input name="logradouro" type="text" id="rua" class="form-control"  size="30" required value="<?php echo @$campo['logradouro'];?>" /></label>

				<label>Bairro:
      <input name="bairro" type="text" id="bairro" class="form-control" required value="<?php echo @$campo['bairro'];?>" /></label></br>

				<div class="row">
					<div class="form-group col-md-2">
						<label for="InputNumero">Numero</label>
						<input type="number" id="numero" name="numero" class="form-control" required value="<?php echo @$campo['numero'];?>" />
					</div>
					<div class="form-group col-md-4">


						<label for="InputComplemento">Complemento</label>
						<input type="text" id="complemento" name="complemento" class="form-control" value="<?php echo @$campo['complemento'];?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2">
						<label>Cidade:</label>
						<input type="text" id="cidade" name="cidade" class="form-control" required value="<?php echo @$campo['cidade'];?>" />
					</div>
					<div class="form-group col-md-1">
						<label>Estado:</label>
						<input type="text" id="uf" name="estado" class="form-control" required value="<?php echo @$campo['estado'];?>" />
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-2">
						<label for="InputTelefone">Telefone</label>
						<input type="text" id="telefone" name="telefone" class="form-control" onkeypress="javascript: mascara(this, tel_mask);" maxlength="13" required value="<?php echo @$campo['telefone'];?>" />
					</div>
					<div class="form-group col-md-4">
						<label for="InputEmail">Email</label>
						<input type="email" id="email" name="email" class="form-control" required value="<?php echo @$campo['email'];?>" />
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-2">
						<label for="InputLinha">Linha</label>
						<input type="text" id="linha" name="linha" class="form-control" required value="<?php echo @$campo['linha'];?>" />
					</div>
				</div>

				<?php
                if(@!$campo['id']){ // se nao passar o id via GET nao está editando, mostra o botao de cadastro
            ?>
					<input type="submit" name="cadastrar" class="btn btn-primary" value="Cadastrar" />
					<a href="listagemAssociacao.php" class="btn btn-default">Cancelar</a>
					<?php }else{ // se  passar o id via GET  está editando, mostra o botao de ediçao ?>
					<input type="submit" name="editar" class="btn btn-primary" value="Salvar" />
					<a href="listagemAssociacao.php" class="btn btn-default">Cancelar</a>
					<?php } ?>
			</form> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

    <?php include 'include/footer.php';?>

</div> <!-- page-container -->
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