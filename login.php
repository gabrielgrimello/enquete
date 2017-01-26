<?php
   session_start();
   if(!isset($_SESSION['logado'])):
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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div>
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
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
                   
            <div class="container-fluid">
                <form action="login.php" method="post">
                <!-- Page Heading -->
                    <div class="row">

                        <!-- barra de ações -->

                        <div class="col-lg-1">
                        </div>

                        <div class="col-lg-10">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="panel-title text-center">Entrar</h2>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                     <br>
                                     <?php
                                     
                                     // testa se houve um POST com o usuario e senha
                                        if (isset($_POST['entrar'])){ //se houve POST entra no IF
                                            
                                            $login = $_POST['login']; // Recebendo o valor usuario do formulário
                                            $senha = $_POST['senha'];// Recebendo o valor senha do formulário
                                            $senha = md5($senha);
                                            
                                            include 'conexao.inc'; //cria a conexão com obanco
                                            $result = mysql_query("SELECT * FROM tb_candidato WHERE login_cand='$login' AND senha_cand='$senha' and ativado_cand=1"); // faz um select no banco para ver se existe algum registro com o usuario e senha informado
                                            $resultado = mysql_num_rows($result); //conta quantidade de linhas no resultado do select
                                          
                                            /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
                                                
                                                if($resultado > 0)
                                                    {
                                                        $array_candidato=mysql_fetch_array($result);
                                                        $_SESSION['logado'] = true;
                                                        $_SESSION['usuario'] = $array_candidato['nome_cand'];
                                                        $_SESSION['permissao'] = $array_candidato['tipo_cand'];
                                                        $_SESSION['filial'] = $array_candidato['filial_cand'];
                                                        $_SESSION['codigo'] = $array_candidato['cod_cand'];
                                                        $_SESSION['votosenv'] = $array_candidato['votosenv_cand'];
                                                        $filial = $_SESSION['filial'];
                                                        $permissao= $_SESSION['permissao'];
                                                        $codigo_cand = $_SESSION['codigo'];
                                                        $votosenv_session = $_SESSION['votosenv'];
                                                        setLOG("Usuario $login", "LOGIN");
                                                        
                                                    
                                                    ?>
                                                    <div class="alert alert-success text-center">
                                                        <strong>Login efetuado com sucesso.</strong>  Você será direcionado em instantes.
                                                    </div>
                                                    <?php
                                                     echo "<script type=\"text/javascript\">
                                                            window.setTimeout(\"location.href='../votacao/index.php';\", 2000);
                                                          </script>";
                                                     }
                                             
                                                else {?>
                                                    <div class="alert alert-danger text-center">
                                                        <strong>Atenção!</strong> Usuário/senha incorretos ou Usuário desativado.
                                                    </div>

                                                    <?php
                                                    unset ($_SESSION['login']);
                                                    unset ($_SESSION['senha']);
                                                    
                                                    echo "<script type=\"text/javascript\">
                                                            window.setTimeout(\"location.href='../votacao/login.php';\", 5000);
                                                          </script>";
                                                }

                                            mysql_close($conexao); //fecha conexão com banco de dados 
                                            }

                                        else{ // caso ainda não tenha existido um POST entra nesete else e mostra o formulário abaixo
                                            ?> 
                                            <div class="col-lg-4">
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Usuário</span>
                                                    <input type="text" name="login" value="" class="form-control">
                                                </div>
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Senha</span>
                                                    <input type="password" name="senha" value="" class="form-control">
                                                </div>
                                                <br>

                                                <div class=" col-lg-4">
                                                </div>
                                                <div class=" col-lg-4">
                                                    <button type="submit" name="entrar" class="btn btn-lg btn-success">Entrar</button>
                                                </div>

                                            </div>
                                            <?php
                                        }
                                            ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.row -->
                </form>
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
<?php else:
     header("Location: index.php"); exit;?>

<?php endif;?>