<?php include 'headerBar.php';?>
<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="pull-left" data-toggle="tooltip" data-placement="bottom" title="Toggle Left Sidebar"></a>
        <a id="rightmenu-trigger" class="pull-right" data-toggle="tooltip" data-placement="bottom" title="Toggle Right Sidebar"></a>

        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="home.php">SGT</a>
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        	<li class="dropdown">
        		<a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs"><?php echo $_SESSION['nomeUsuario'] ?><i class="icon-caret-down icon-scale"></i></span></a>
        		<ul class="dropdown-menu userinfo arrow">
        			<li class="username">
                        <a href="#">
<!--        				    <div class="pull-left"><img class="userimg" src="../assets/demo/avatar/dangerfield.png" alt="Jeff Dangerfield" /></div>-->
        				    <div class="pull-right"><h5>Olá, <?php echo $_SESSION['nomePessoa'] ?>!</h5><small>Logado como <span><?php echo $_SESSION['nomeUsuario'] ?></span></small></div>
                        </a>
        			</li>
        			<li class="userlinks">
        				<ul class="dropdown-menu">
<!--        					<li><a href="#">Edit Profile <i class="pull-right icon-pencil"></i></a></li>
        					<li><a href="#">Account <i class="pull-right icon-cog"></i></a></li>
        					<li><a href="#">Help <i class="pull-right icon-question-sign"></i></a></li>-->

        					<li><a href="../sair.php" class="text-right">Sair</a></li>
        				</ul>
        			</li>
        		</ul>
        	</li>
<!--        	<li class="dropdown">
        		<a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="icon-envelope"></i><span class="badge">1</span></a>
        		<ul class="dropdown-menu messeges arrow">
        			<li>
        				<span>You have 1 new message(s)</span>
        				<span><a href="#">Mark all Read</a></span>
        			</li>
        			<li><a href="#" class="active">
        				<span class="time">6 mins</span>
        				<img src="assets/demo/avatar/doyle.png" alt="avatar" />
        				<div><span class="name">Alan Doyle</span><span class="msg">Please mail me the files by tonight.</span></div>
        			</a></li>
        			<li><a href="#">
        				<span class="time">12 mins</span>
        				<img src="assets/demo/avatar/paton.png" alt="avatar" />
        				<div><span class="name">Polly Paton</span><span class="msg">Uploaded all the files to server. Take a look.</span></div>
        			</a></li>
        			<li><a href="#">
        				<span class="time">9 hrs</span>
        				<img src="assets/demo/avatar/corbett.png" alt="avatar" />
        				<div><span class="name">Simon Corbett</span><span class="msg">I am signing off for today.</span></div>
        			</a></li>
        			<li><a href="#">
        				<span class="time">2 days</span>
        				<img src="assets/demo/avatar/tennant.png" alt="avatar" />
        				<div><span class="name">David Tennant</span><span class="msg">How are you doing?</span></div>
        			</a></li>
        			<li><a class="dd-viewall" href="#">View All Messages</a></li>
        		</ul>
        	</li>-->

<!--            <li>
                <a href="#" id="headerbardropdown"><span><i class="icon-level-down"></i></span></a>
            </li>-->

		</ul>
</header>
