<?php
    session_start();
    
   if(isset($_SESSION['logado']) === false){
         echo "Por favor aguarde, você será redirecionado...";
         echo "<script type=\"text/javascript\">
             window.setTimeout(\"location.href='../votacao/login.php';\", 2000);
           </script>";
         exit;
    }
    
    $nome_usuario = $_SESSION['usuario'];
    $permissao = $_SESSION['permissao'];
    $filial_session = $_SESSION['filial'];
    $codigo_cand = $_SESSION['codigo'];
  
   
    function setLOG($MSG, $REL) {
        include 'conexao.inc'; //inclui a conexao com o banco
        $IP = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
        
        date_default_timezone_set('America/Sao_Paulo'); 
        $HORA = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
        $nome_usuario = strtoupper($_SESSION['usuario']);
        $MSGF = mysql_escape_string($MSG); // Limpando String

        // Monta a query para inserir o log no sistema
        
        $sql = "INSERT INTO logs (logid,hora,ip,relacionamento,mensagem,acao) VALUES (null,'$HORA','$IP','$REL','$MSGF','$nome_usuario')"; 
        if (mysql_query($sql,$conexao)) //Realiza a consulta
        return true;
        else
        return false;
    }
   
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
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                                <h2 class="panel-title text-center">Editar candidatos</h2>
                            </div>
                <?php
                            include 'conexao.inc';

                            if (isset($_POST['salvar'])){
                                include 'conexao.inc';
                                 
                                // Recebendo o valores do formulário
                                $cod_candidato = $_POST['cod_cand']; 
                                $nome = $_POST['nome']; 
                                $senha = $_POST['senha'];
                                $senha = md5($senha);
                               
                                // inserindo valores recebidos na base de dados
                                mysql_query("UPDATE tb_candidato SET senha_cand='$senha' WHERE cod_cand=$cod_candidato");
                                // grava log na base
                                setLOG("Usuario $nome", "ALTERACAO USUARIO");
                              
                                if(mysql_affected_rows() > 0){ //verifica se foi afetada alguma linha, nesse caso atualizada alguma linha
                    ?>              <br>
                                    <div class="alert alert-success text-center">
                                        <strong>Muito bem!</strong> Os dados do usuário foram atualizados com sucesso.
                                    </div>
                    <?php
                                    echo "<script type=\"text/javascript\">
                                            window.setTimeout(\"location.href='../votacao/index.php';\", 2000);
                                          </script>";
                                } 
                                else {
                    ?>
                                    <div class="alert alert-danger text-center">
                                    <strong>Atenção!</strong> Houve um problema na atualização dos dados do usuário. Verifique com o administrador.
                                    </div>
                    <?php
                                }
                                 
                            }//fecha if isset
                            else{ // else do isset
                    ?> 
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <form action="alt_senha_candidato.php" data-toggle="validator" method="post">
                    <?php
                                            //verifica se existe conexão com bd, caso não tenta criar uma nova
                                            include 'conexao.inc';
                                            $cod_cand = $_GET['id']; // Recebendo o valor vindo do link
                                            if($cod_cand!=$codigo_cand and $permissao!="ADMIN"){
                    ?>
                                                <div class="alert alert-warning text-center">
                                                    <strong>VOCÊ NÃO POSSUI PERMISSÃO PARA ALTERAR A SENHA DESTE USUÁRIO</strong>
                                                </div>
                    <?php
                                                echo "<script type=\"text/javascript\">
                                                    window.setTimeout(\"location.href='../votacao/index.php';\", 2000);
                                                  </script>";
                                                exit;
                                            }
                                            $sql = mysql_query("Select * From tb_candidato WHERE cod_cand=$cod_cand");
                                            $linha = mysql_fetch_array($sql)
                                                            
                    ?> 
                                            <div class="col-lg-4">
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="hidden" name="cod_cand" class="form-control" readonly="" value="<?php echo $linha['cod_cand']; ?>">
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">nome</span>
                                                        <input type="text" required name="nome" value="<?php echo $linha['nome_cand']; ?>" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Nova Senha</span>
                                                        <input type="password" required name="senha" value="" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                 
                                            <div class=" col-lg-2">
                                            </div>
                                            <div class=" col-lg-4">
                                                <button type="submit" name="salvar" class="btn btn-lg btn-success">Salvar</button>
                                            </div>
                                            <div class=" col-lg-4">
                                                <input type="button" class="btn btn-lg btn-primary" value="Voltar" onClick="history.go(-1)">
                                            </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            <?php 
                            } //fecha else do if isset
                            ?>
                        </div>
                    </div>
                </div><!-- /.row -->
               
            </div><!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validator.js"></script>
</body>

</html>
