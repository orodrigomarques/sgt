<?php
//Variaveis
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$msg = $_POST['msg'];
$data_envio = date('d/m/Y');
$hora_envio = date('H:i:s');
// -------------
// Corpo E-mail
	$arquivo = "
	<style type='text/css'>
	body {
	margin:0px;
	font-family:Verdane;
	font-size:12px;
	color: #666666;
	}
	a{
	color: #666666;
	text-decoration: none;
	}
	a:hover {
	color: #FF0000;
	text-decoration: none;
	}
	</style>
    <html>
        <table align=center border=1px>
            <tr>
              <td colspan=2 align=center>CONTATO
			    <tr>
                 <td>Nome:$nome</td>
                </tr>
                <tr>
                  <td>E-mail:<b>$email</b></td>
	            </tr>
				<tr>
                  <td>Telefone:<b>$telefone</b></td>
                </tr>
	      <tr>
                  <td>Mensagem:$msg</td>
                </tr>
            </td>
          </tr>
          <tr>
            <td>Este e-mail foi enviado em <b>$data_envio</b> &agrave;s <b>$hora_envio</b></td>
          </tr>
        </table>
    </html>
	";
// -------------------------
//enviar
	// emails para quem será enviado o formulário
  $emailenviar="adsix@sgt.esy.es";
	$destino = $emailenviar;
	$assunto = "Contato pelo SGT";
	// É necessário indicar que o formato do e-mail é html
	$headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:'. $nome .'<$email>';
	//$headers .= "Bcc: $EmailPadrao\r\n";
	$enviaremail = mail($destino, $assunto, $arquivo, $headers);
	if($enviaremail){
	$mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
//	echo " <meta http-equiv='refresh' content='3;URL=contato/index.php'>";
  echo "<script>alert('Email enviado com sucesso!');
  location.href=\"index.php\"</script>";
	} else {
	$mgm = "ERRO AO ENVIAR E-MAIL!";
	echo "";
	}
?>
