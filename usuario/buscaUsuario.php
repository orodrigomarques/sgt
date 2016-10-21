<?php
include '../include/funcoes.php';
    include '../include/conexao/conecta.php';


if ( $_POST['usuario']!='' ) { 
$usuarioDigitado = $_POST['usuario']; 
$sql = mysqli_query($conexao, "SELECT * FROM usuario WHERE nm_usuario = '{$usuarioDigitado}'") or print mysql_error(); 
if(mysqli_num_rows($sql)>0){	
echo json_encode(array('usuario' => ' Ja existe um usuario cadastrado com este nome')); 
} else { 
echo json_encode(array('usuario' => 'Usuário valido.' )); 
}
}else{echo json_encode(array('usuario' => '' ));}
?>

