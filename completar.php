<?php
 include './include/conexao/conecta.php';
$conexao = conecta();
$q=strtolower ($_GET["q"]);
try {
$sql = $conexao->prepare("SELECT * FROM veiculo WHERE cd_placa like :q" );

    $sql->bindValue(":q", '%' . $q . '%');
    $sql->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}
if($sql->rowCount() > 0){
while($sqls = $sql->fetch(PDO::FETCH_ASSOC)){

	//if (srtpos(strtolower($reg['nom_lista']),$q !== false){
		echo $sqls["cd_placa"]."|".$sqls["cd_placa"]."\n";
//	}
}}else{echo "A consulta não retornou nenhum registro";};
?>
