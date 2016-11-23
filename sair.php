<?php if(!isset($_SESSION)){session_start();}
    include './include/funcoes.php';
    auditoria("Saiu");
    unset($_SESSION['cdUsuario']);    
    header("Location: login.php");
?>
