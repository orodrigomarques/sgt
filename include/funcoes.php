<?php

    function validaAcesso(){
        if(!isset($_SESSION)){session_start();}
        
        if(!isset($_SESSION['cdUsuario']) || empty($_SESSION['cdUsuario']))
	{
		header("Location: /login.php?erro=aut");
		exit;
	}        
    }
    
    function sair(){
        
        if(!isset($_SESSION)){session_start();}

        unset($_SESSION['codigo']);
        header("Location: /login.php");

    }

 
    function auditoria($acao){
        
        include 'conexao/conecta.php';
        $conexao = conecta();
                
        try{
        
        $auditoria = $conexao->prepare("INSERT INTO `sgt`.`auditoria` (`id_usuario`, `nm_usuario`, `ds_acao`, `dt_momento`, `nr_ip`) "
                                         ."VALUES (:id, :usuario, :acao , now(), :ip)");
        $auditoria->bindValue(":id", $_SESSION['cdUsuario']);
        $auditoria->bindValue(":usuario", $_SESSION['nomeUsuario']);
        $auditoria->bindValue(":acao", $acao);
        $auditoria->bindValue(":ip", $_SERVER['REMOTE_ADDR']);
        $auditoria->execute();
        
        }  catch (Exception $ex){
            return $ex->getMessage();
        }
        

    }

?>
