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

?>