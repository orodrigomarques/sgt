<nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
            <ul class="acc-menu" id="sidebar">
                    <li><a href="../home.php"><i class="icon-home"></i> <span>Home</span></a></li>
                    <?php if($_SESSION['permissao']== 1){?>
                    <li><a href="../usuario/index.php"><i class="icon-user"></i> <span>Usuarios</span></a></li> <?php }; ?>
                   <li><a href="javascript:;"><i class="icon-cog"></i> <span>Cadastros</span> </a>
            <ul class="acc-menu">
                <li><a href="../associacao/index.php"><i class="icon-th"></i> <span>Associações</span></a></li>
                <li><a href="../modalidade/index.php"><i class="icon-th"></i> <span>Modalidades</span></a></li>
                <li><a href="../processo/index.php"><i class="icon-th"></i> <span>Processos</span></a></li>
                <li><a href="../recurso/index.php"><i class="icon-th"></i> <span>Recursos</span></a></li>
                <li><a href="../tipopessoa/index.php"><i class="icon-th"></i> <span>Tipo de Pessoa</span></a></li>

        </li>
                </ul>
                <li><a href="../contato/index.php"><i class="icon-envelope"></i> <span>Contato</span></a></li>

                
<!--                <li><a href="javascript:;"><i class="icon-th"></i> <span>Cadastros</span> </a>
                    <ul class="acc-menu">
                        <li><a href="layout-grid.php"><span>Grids</span></a>
                        </li><li><a href="layout-horizontal.php"><span>Horizontal Navigation</span></a>
                    </li>
                 </ul>
                
                <li><a href="javascript:;"><i class="icon-list-ol"></i> <span>UI Elements</span> <span class="badge badge-indigo">4</span></a>
                    <ul class='acc-menu'>
                        <li><a href="ui-typography.php">Typography</a></li>
                        <li><a href="ui-buttons.php">Buttons</a></li>
                        <li><a href="tables-basic.php">Tables</a></li>
                        <li><a href="form-layout.php">Forms</a></li>
                        <li><a href="ui-panels.php">Panels</a></li>
                        <li><a href="ui-images.php">Images</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                
                <li><a href="javascript:;"><i class="icon-sitemap"></i> <span>Unlimited Level Menu</span></a>
                    <ul class="acc-menu">
                        <li><a href="javascript:;">Menu Item 1</a></li>
                        <li><a href="javascript:;">Menu Item 2</a>
                            <ul class="acc-menu">
                                <li><a href="javascript:;">Menu Item 2.1</a></li>
                                <li><a href="javascript:;">Menu Item 2.2</a>
                                    <ul class="acc-menu">
                                        <li><a href="javascript:;">Menu Item 2.2.1</a></li>
                                        <li><a href="javascript:;">Menu Item 2.2.2</a>
                                            <ul class="acc-menu">
                                                <li><a href="javascript:;">And deeper yet!</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </li>-->
            </ul>
            <!-- END SIDEBAR MENU -->
        </nav>
