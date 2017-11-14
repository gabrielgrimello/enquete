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
                    if (isset($_POST['filtrar'])){
                        $filial = $_POST['filial'];
                    }
                    else{
                        $filial = "SP";
                    }
                    ?>
                    
                    
                    <div class="col-lg-1">
                    </div>
                    
                    <div class="col-lg-10">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title text-center">Resultados da votação</h2>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                <br>
                                <form action="resultado.php" data-toggle="validator" method="post">
                                    <div class="form-group has-feedback col-lg-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Filial</span>
                                            <select name="filial" class="form-control">
                                                <option value="SP" <?php if($filial=='SP') echo 'selected';?>>SÃO PAULO/BRAGANÇA</option>
                                                <option value="SAN" <?php if($filial=='SAN') echo 'selected';?>>SANTOS</option>
                                            </select>
                                        </div>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <button name="filtrar" class="btn btn-primary btn-block">Filtrar</button>
                                         </div>
                                    </div>
                                 
                                    <div class="col-lg-4">
                                        <div class="text-right">
                                            <a title="Zerar contadores de votação" href="zerarcontadores.php" class="btn btn-success btn-small">Zerar contadores votação  <i class="glyphicon glyphicon-plus-sign"></i></a>
                                            <br><br>
                                        </div>
                                    </div>
                                </form>
                                <table id="table-usuarios" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Setor</th>
                                            <th>Filial</th>
                                            <th>DESTAQUE</th>
                                            <th>FUTURO DESTAQUE</th>
                                        </tr>
                                    </thead>


                                    <?php
                                    //verifica se existe conexão com bd, caso não tenta criar uma nova
                                        include 'conexao.inc';
                                        $sql = mysqli_query($conexao,"Select * From tb_candidato where filial_cand='$filial' order by votorecdest_cand desc");

                                        while($linha = mysqli_fetch_array($sql)) //Já a instrução while faz um loop entre todos os registros e armazena seus valores na variável $linha
                                        { //Inicia o loop

                                    ?> 

                                        <tr> 

                                        <td><?php echo strtoupper($linha['nome_cand']); ?></td> 
                                        <td><?php echo strtoupper($linha['setor_cand']); ?></td>
                                        <td><?php echo strtoupper($linha['filial_cand']); ?></td>
                                        <td><?php echo strtoupper($linha['votorecdest_cand']); ?></td> 
                                        <td><?php echo strtoupper($linha['votorecdestfut_cand']); ?></td>
                                        </tr>
                                        <?php

                                } // Retorna para o início do loop caso existam mais registros a serem mostrados
                                        ?>
                                    </table>  
                                </div>
                           </div> <!-- painel body -->
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
