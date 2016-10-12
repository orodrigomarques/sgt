<?php 
    include '../include/conexao/conecta.php';
    include '../include/head.php';
    include '../include/funcoes.php';
    validaAcesso();
    
    if(isset($_GET['retorno']) && $_GET['retorno'] == 'inserido'){
       
       echo "<script>alert('Registro inserido com sucesso!');
                   location.href=\"index.php\"</script>";
    }
    
     if(isset($_GET['retorno']) && $_GET['retorno'] == 'alterado'){
       
       echo "<script>alert('Registro alterado com sucesso!');
                   location.href=\"index.php\"</script>";
    }
    //WHERE
    $where = '';
    $associacao = '';
   // $ativo = 1;
    if(isset($_POST['associacao']) && !empty($_POST['associacao'])){
            $associacao = addslashes($_POST['associacao']);
            $associacao = str_replace('\\','',$associacao);
    }
    $where .= " WHERE nm_razao_social LIKE '%$associacao%'";
    
   // if(isset($_POST['ds_ativo'])){
     //       $ativo = ($_POST['ds_ativo']);
            
    //}
    //$where .= " and ds_ativo = $ativo"; 
           

    //if(isset($_POST['ds_permissao']) && !empty($_POST['ds_permissao'])){
      //      $permissao = ($_POST['ds_permissao']);
        //    $where .= " and ds_permissao = $permissao";		
    //}    
    //--
        
    // PAGINAÇÃO
    $pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1);
    $registros = 20;

    $inicio = ($pagina -1) * $registros;
    $fim = $registros;//$pagina * $registros;

    $limit = " LIMIT $inicio, $fim";
    
    $sqlcount = "SELECT count(*) as qtd ".
                "FROM associacao ".
                $where;	
    $qtd = mysqli_fetch_assoc(mysqli_query($conexao, $sqlcount));
    
    $ultima_pagina = ceil((int)$qtd['qtd']/$registros);
    //--
    

    $sql_associacoes =     "SELECT * FROM associacao ".
                        $where.			
			" ORDER BY nm_razao_social ASC ".
			$limit;   
    
    $associacoes = mysqli_query($conexao, $sql_associacoes);   

    
?>


<body class="">
    <?php include '../include/header.php';?>

    <div id="page-container">
       
        <?php include '../include/menu.php';?>

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li class='active'><a href="../home.php">Home</a> > Associações</li>
            </ol>
            <h1>Associações</h1>  
            <div class="options">
                <div class="btn-toolbar">
                    <a href="gerencia.php?acao=novo"  class="btn btn-primary"><i class="icon-user"></i>&nbsp;&nbsp;Nova Associação</a>
                </div>
            </div>
        </div>      
        <div class="container">               
            <div class="container">		
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                    <h4>Exibindo Associações cadastradas</h4>										
                            </div>
                            
                            <div class="panel-body collapse in">
                                <div id="example_wrapper" class="dataTables_wrapper" role="grid">
                                    <form name="associacoes" method="POST" id="associacoes">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <input class="form-control" name="associacao" placeholder="Razao Social" value="<?php echo($associacao);?>" type="text">
                                            </div>
                                           
                                            
                                             
                                            
                                            <div class="col-xs-2">
                                                    <button style="float:left" class="btn-primary btn">Buscar</button>
                                            </div><br /><br /><br />
                                        </div>
                                    </form>

                                    <?php if(mysqli_num_rows($associacoes) > 0){ ?>
                                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables dataTable" id="example" aria-describedby="example_info">
                                                <thead>
                                                        <tr role="row">
                                                                <th class="sorting_asc" role="columnheader" tabindex="1" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width:150px;">Razao Social</th>		
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Telefone</th>
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Email</th>
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Linha</th>                                                      
                                                                <th role="columnheader" tabindex="2" aria-controls="example" rowspan="1" colspan="1" aria-label="" style="width:150px;">Opções</th>
                                                        </tr>
                                                </thead>

                                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                <?php while($associacao = mysqli_fetch_assoc($associacoes)){?>
                                                        <tr class="gradeA odd">
                                                                <td style="width:20%" class=""><?php echo($associacao['nm_razao_social']);?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                      
                                                                
                                                                <td style="width:10%" class=""><?php echo $associacao['cd_telefone'];?></td>
                                                                <td style="width:20%" class=""><?php echo $associacao['nm_email'];?></td>
                                                                <td style="width:5%" class=""><?php echo $associacao['nm_linha'];?></td>
                                                                <td style="width:40%" class="center">
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($associacao['cd_associacao']); ?>&acao=editar" onClick="buscaPessoa('<?php echo($associacao['cd_associacao']);?>')" class="btn btn-primary"><i class="icon-pencil">&nbsp;&nbsp;Editar</i> </a>
                                                                    <a href="gerencia.php?id=<?php echo base64_encode($associacao['cd_associacao']); ?>&acao=visualizar" onClick="buscaPessoa('<?php echo($associacao['cd_associacao']);?>')" class="btn btn-success"><i class="icon-eye-open">&nbsp;&nbsp;Visualizar</i> </a>
<!--                                                                    <a onClick="buscaUsuario('<?php echo($associacao['cd_associacao']);?>');location.href='gerencia.php?acao=visualizar&id_usuario=<?php echo $usuario['id_usuario']; ?>'" class="btn btn-success"><i class="icon-trash">&nbsp;&nbsp;Visualizar</i> </a>-->
                                                                    <a onClick="if(confirm('Tem certeza que deseja excluir este registro?')){location.href='gerencia.php?acao=excluir&id=<?php echo base64_encode($associacao['cd_associacao']); ?>'}" class="btn btn-danger"> <i class="icon-trash">&nbsp;&nbsp;Excluir</i> </a>
                                                                </td>
                                                        </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                            
                                            <div style="float:left">
                                                &nbsp;<?php echo($qtd['qtd']); ?> registros encontrados.
                                            </div>
                                    <?php }else{ ?>
                                            <div style="margin-left:10px">Nenhum documeto encontrado.</div>
                                    <?php } ?>
                                    </div>		

                     
                                    
                                    <div class="tab-pane active" style="text-align:right;" id="dompaginate">
                                        <ul class="pagination">

                                        <li><a href="?pagina=1&nome=<?php echo($associacao);?>"><i class="icon-double-angle-left"></i>&nbsp;</a></li>
                                        
                                        <?php
                                        $inicio_paginacao = ($pagina-2<1) ? 1 : $pagina - 2;

                                        if($pagina >1){?>
                                              <li><a href="?pagina=<?php echo($pagina-1);?>&nome=<?php echo($associacao);?>"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                        <?php }else{ ?>
                                              <li class="disabled"><a href="#"><i class="icon-angle-left"></i>&nbsp;</a></li>
                                        <?php }?>

                                        <?php
                                        for($i = $inicio_paginacao;$i < $inicio_paginacao +5;$i++){
                                                if($i<=$ultima_pagina){?>
                                              <li<?php echo ($pagina == $i) ? ' class="active"': ''; ?>><a href="?pagina=<?php echo($i);?>&nome=<?php echo($associacao);?>"><?php echo($i);?></a></li>
                                        <?php }?>
                                        <?php }?>
                                        <li <?php echo($pagina>=$ultima_pagina) ? 'class="disabled"' : ''?>><a href="?pagina=<?php echo($pagina+1);?>&nome=<?php echo($associacao);?>"><i class="icon-angle-right"></i>&nbsp;</a></li> 

                                        <li><a href="?pagina=<?php echo($ultima_pagina);?>&nome=<?php echo($associacao);?>"><i class="icon-double-angle-right"></i>&nbsp;</a></li>

                                        <div style="margin-left:30px;width:100px;float:left;">
                                              <input type="text" name="pagina_ir" id="pagina_ir" class="form-control" value="<?php echo($pagina);?>" style="float:left;width:50px">
                                              <a onclick="location.href='?pagina='+$('#pagina_ir').val()+'&nome=<?php echo($associacao);?>' 	" style="float:left;" class="btn btn-muted btn-default">Ir</a>
                                        </div>                                
                                    </ul>
                                </div>            
                            </div>
                        </div>
                    </div>            
                </div>
            </div> <!-- container -->     
        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

    <?php include '../include/footer.php';?>

</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

<script type='text/javascript' src='../assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='../assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='../assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='../assets/js/enquire.js'></script> 
<script type='text/javascript' src='../assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='../assets/js/jquery.touchSwipe.min.js'></script> 
<script type='text/javascript' src='../assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='../assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-wysihtml5/wysihtml5-0.3.0.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-wysihtml5/bootstrap-wysihtml5.js'></script> 
<script type='text/javascript' src='../assets/plugins/fullcalendar/fullcalendar.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/form-daterangepicker/moment.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.resize.min.js'></script> 
<script type='text/javascript' src='../assets/plugins/charts-flot/jquery.flot.orderBars.min.js'></script> 
<script type='text/javascript' src='../assets/demo/demo-index.js'></script> 
<script type='text/javascript' src='../assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='../assets/js/application.js'></script> 
<script type='text/javascript' src='../assets/demo/demo.js'></script> 

</body>
</html>

