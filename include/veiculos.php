<?php     
function getCountries() {$i=0;
 include './conexao/conecta.php';
$conexao = conecta();
try {
$sql = $conexao->prepare("SELECT * FROM veiculo" );

    $sql->execute();
} catch (Exception $e) {
    echo $e;
    exit();
}

if($sql->rowCount() > 0){ 
    $i=0;
while($sqls = $sql->fetch(PDO::FETCH_ASSOC)){

 $menu_items[] =array(
        
        'name' =>$sqls['cd_placa'], 
       
    );
	

$i++;}
}

return $menu_items;
}
?>
