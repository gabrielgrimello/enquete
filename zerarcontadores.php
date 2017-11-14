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
                                <h2 class="panel-title text-center">Zerar contadores de votos</h2>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <br>
                                    <form action="zerarcontadores.php" data-toggle="validator" method="post">
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger">
                                            <strong>Atenção!</strong><br>
                                            Ao clicar em confirmar, todos os contadores de votos enviados e recebidos de todos os candidatos serão zerados.
                                        </div>  
                                    </div>
                                    <br> 
                                        <div class=" col-lg-5">
                                        </div>
                                        <div class=" col-lg-4">
                                            <button type="submit" name="zerar" class="btn btn-lg btn-success">ZERAR</button>
                                        </div>
                                    </form>
                                    <?php
                                    if (isset($_POST['zerar'])){
                                        include 'conexao.inc'; //inclui a conexao com o banco
                                        mysqli_query($conexao, "UPDATE tb_candidato SET votosenv_cand='0',votoenvdest_cand='0',votoenvdestfut_cand='0',votorecdest_cand='0',votorecdestfut_cand='0'");
                                    }
                                        ?>
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
