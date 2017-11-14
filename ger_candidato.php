<?php
   include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Destaque do ano</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
//verifica se existe conexão com bd, caso não tenta criar uma nova
   include 'conexao.inc';
    
?>

    <div >

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://www.wbagestao.com.br" target="_blank">Desenvolvido por STOREWARE TEAM</a>
            </div>
            
            <!-- Menu Superior -->
            <?php
            include 'menu_superior.php';
            ?>
            
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                
                <!-- Page Heading -->
                <div class="row">
                    
                    
                    <!-- barra de ações -->
                    <?php
                    include 'barra_acoes.html';
                    ?>
                    
                    
                    <div class="col-lg-1">
                    </div>
                    
                    <div class="col-lg-10">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title text-center">Gerenciar usuários cadastrados</h2>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                 <br>
                                 
                        <div class="col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon">Nome</span>
                                <input type="text" name="nome" value="" class="form-control">
                             </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-group">
                                <button class="btn btn-primary btn-block">Filtrar</button>
                             </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-right">
                                <a title="Novo equipamento" href="cad_candidato.php" class="btn btn-success btn-small">Novo candidato  <i class="glyphicon glyphicon-plus-sign"></i></a>
                                <br><br>
                            </div>
                        </div>
                                 
                               
                                    <table id="table-usuarios" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Nome</th>
                                                <th>Setor</th>
                                                <th>Votos enviados</th>
                                                <th>Situação</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>


                                        <?php
                                        //verifica se existe conexão com bd, caso não tenta criar uma nova
                                            include 'conexao.inc';
                                            $sql = mysqli_query($conexao,"Select * From tb_candidato order by nome_cand");
                                                                                        
                                            while($linha = mysqli_fetch_array($sql)) //Já a instrução while faz um loop entre todos os registros e armazena seus valores na variável $linha
                                            { //Inicia o loop
                                               
                                        ?> 

                                        <tr> 
                                        <td><?php echo strtoupper($linha['cod_cand']); ?> </td>
                                        <td><?php echo strtoupper($linha['nome_cand']); ?></td> 
                                        <td><?php echo strtoupper($linha['setor_cand']); ?></td> 
                                        <td><?php echo strtoupper($linha['votosenv_cand']); ?></td>
                                        <td><?php if($linha['ativado_cand']==1){echo "ATIVO";}
                                        else{echo "DESATIVADO";}?></td>
                                        <td class="text-center">
                                            <a title="editar" href="edit_candidato.php?id=<?php echo $linha['cod_cand']; ?>" class="btn btn-primary btn-small">Editar <i class="fa-fw glyphicon glyphicon-check"></i> </a>
                                            <a title="Alterar Senha" href="alt_senha_candidato.php?id=<?php echo $linha['cod_cand']; ?>" class="btn btn-danger btn-small">Alterar Senha <i class="fa-fw glyphicon glyphicon-check"></i> </a>
                                            
                                        </td>
                                        </tr>
                                        <?php

                                        } // Retorna para o início do loop caso existam mais registros a serem mostrados
                                        ?>
                                    </table>  
                                </div>
                           </div>
                        </div>
                    </div>
              
                </div>
                <!-- /.row -->
               
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
