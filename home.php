<?php
include 'include/head.php';

include 'include/funcoes.php';
validaAcesso();
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Untitled Document</title>

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery.bgiframe.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.ajaxQueue.js"></script>
    <script type="text/javascript" src="assets/js/thickbox-compressed.js"></script>
    <script type="text/javascript" src="assets/js/jquery.autocomplete.js"></script>
    <!--css -->
    <link rel="stylesheet" type="text/css" href="assets/js/jquery.autocomplete.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/thickbox.css"/>


</head>

<body>
    <?php include 'include/header.php'; ?>

    <div id="page-container">

        <?php include 'include/menu.php'; ?>

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li class='active'><a href="index.php">Home</a></li>
                    </ol>
                    <h1>Home</h1>
                    <img width="300px" height="200px"  src="/assets/img/sgt_logo.png"/>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#txtNome").autocomplete("completar.php", {
                                width: 540,
                                selectFirst: false
                            });
                        });
                    </script>


                </div>       
                <div class="col-xs-6" >
                    <input type="text" name="txtNome" id="txtNome" size="60" class="form-control"/>
                </div><div class="col-xs-2">
                    <button style="float:left" class="btn-primary btn">Buscar</button>
                </div>
                <div class="container">               

                </div> <!-- container -->
            </div> <!--wrap -->
        </div> <!-- page-content -->

        <?php include 'include/footer.php'; ?>

    </div> <!-- page-container -->


</body>
</html>
