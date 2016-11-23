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

<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='assets/js/enquire.js'></script>
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.touchSwipe.min.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-wysihtml5/wysihtml5-0.3.0.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-wysihtml5/bootstrap-wysihtml5.js'></script> 
<script type='text/javascript' src='assets/plugins/fullcalendar/fullcalendar.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script> 
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.min.js'></script> 
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.resize.min.js'></script> 
<script type='text/javascript' src='assets/plugins/charts-flot/jquery.flot.orderBars.min.js'></script> 
<script type='text/javascript' src='assets/demo/demo-index.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/demo/demo.js'></script> 
</body>
</html>
