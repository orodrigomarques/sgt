<?php
 include './include/conexao/conecta.php';

$q=strtolower ($_GET["q"]);

$sql = "SELECT * FROM usuario WHERE nm_usuario like '%" . $q . "%'";

$query = mysqli_query($conexao, $sql);// or die ("Erro". mysql_query());

if(mysqli_num_rows($query)>0){
while($reg=mysqli_fetch_array($query)){

	//if (srtpos(strtolower($reg['nom_lista']),$q !== false){
		echo $reg["nm_usuario"]."|".$reg["nm_usuario"]."\n";
//	}
}}else{echo "A consulta não retornou nenhum registro";};
?>
