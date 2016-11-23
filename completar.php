<?php
 include './include/conexao/conecta.php';

$q=strtolower ($_GET["q"]);

$sql = "SELECT * FROM veiculo WHERE cd_placa like '%" . $q . "%'";

$query = mysqli_query($conexao, $sql);// or die ("Erro". mysql_query());

if(mysqli_num_rows($query)>0){
while($reg=mysqli_fetch_array($query)){

	//if (srtpos(strtolower($reg['nom_lista']),$q !== false){
		echo $reg["cd_placa"]."|".$reg["cd_placa"]."\n";
//	}
}}else{echo "A consulta não retornou nenhum registro";};
?>
