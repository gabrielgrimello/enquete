<ul class="nav navbar-right top-nav">
             
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo strtoupper($nome_usuario); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        
                        <li>
                            <a href="alt_senha_candidato.php?id=<?php echo $codigo_cand; ?>"><i class="fa fa-fw fa-gear"></i> Alterar senha</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
</ul>