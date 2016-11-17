<?php
    include 'include/head.php';

    include 'include/funcoes.php';
  //  validaAcesso();
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">        </script>
     <script src="assets/js/typeahead.min.js"></script>
     <script>
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search.php?key=%QUERY',
        limit : 10
    });
});
    </script>
<body class="">
    <?php include 'include/header.php';?>

    <div id="page-container">

        <?php include 'include/menu.php';?>

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li class='active'><a href="home.php">Home</a></li>
            </ol>
            <h1>Home.</h1>
            <input type="text" name="typeahead" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Type your Query">
            <?php
            $ip = $_SERVER['REMOTE_ADDR'];
                echo $ip;?>
        </div>

        <div class="container">
            <h1></h1>
        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

    <?php include 'include/footer.php';?>

</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
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
<script type='text/javascript' src='assets/js/placeholdr.js'></script>
<script type='text/javascript' src='assets/js/application.js'></script>
<script type='text/javascript' src='assets/demo/demo.js'></script>

</body>
</html>
