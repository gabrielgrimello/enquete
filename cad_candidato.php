<?php
    include 'session.php';

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
                <a class="navbar-brand" href="http://www.wbagestao.com.br" target="_blank">Desenvolvido por STOREWARE TEAM</a>
            </div>
            
            
            <!-- Menu Superior -->
            <?php
            include 'menu_superior.php';
            ?>
            
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <?php
            include 'barra_acoes.html';
            ?>
            <div class="container-fluid">
                <form action="cad_candidato.php" data-toggle="validator" method="post">
                    <!-- Page Heading -->
                    <div class="row">

                        <div class="col-lg-1">
                        </div>

                        <div class="col-lg-10">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="panel-title text-center">Cadastrar candidatos</h2>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <br>
                                    <?php
                                        if (isset($_POST['salvar'])){
                                            include 'conexao.inc'; //inclui a conexao com o banco
                                            $nome = $_POST['nome']; // Recebendo o valor placa do formulário
                                            $login = $_POST['login'];
                                            $senha = $_POST['senha'];
                                            $email = $_POST['email'];
                                            $setor = $_POST['setor'];// Recebendo o valor fabricante do formulário
                                            $tipo = $_POST['tipo'];
                                            $filial = $_POST['filial'];
                                            $situacao = $_POST['situacao'];
                                            $senha = md5($senha);

                                            $result = mysql_query("SELECT * FROM tb_candidato WHERE nome_cand='$nome'"); // faz um select no banco para ver se existe algum registro com o usuario e senha informado
                                            $resultado = mysql_num_rows($result); //conta quantidade de linhas no resultado do select

                                            /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */

                                            if($resultado > 0){
                                    ?>
                                                <div class="alert alert-danger">
                                                    <strong>Atenção!</strong> Candidato já cadastrado.
                                    <?php
                                                    echo "<script type=\"text/javascript\">
                                                           window.setTimeout(\"location.href='../votacao/ger_candidato.php';\", 2000);
                                                         </script>";

                                    ?>
                                                </div>
                                    <?php   }
                                            else{
                                                $string_sql = "INSERT INTO tb_candidato (cod_cand,nome_cand,login_cand,senha_cand,email_cand,filial_cand,setor_cand,tipo_cand,votosenv_cand,votoenvdest_cand,votoenvdestfut_cand,votorecdest_cand,votorecdestfut_cand,ativado_cand) VALUES (null,'$nome','$login','$senha','$email','$filial','$setor','$tipo',0,0,0,0,0,'$situacao')"; 
                                                mysql_query($string_sql,$conexao); //Realiza a consulta
                                                
                                                setLOG("Usuario $nome", "CADASTRO USUARIO");

                                                if(mysql_affected_rows() > 0){ //verifica se foi afetada alguma linha, nesse caso inserida alguma linha
                                                    
                                    ?>          
                                                    <div class="alert alert-success">
                                                        <strong>Muito bem!</strong> Candidato CADASTRADO com sucesso.
                                                    </div>
                                    <?php           echo "<script type=\"text/javascript\">
                                                            window.setTimeout(\"location.href='../votacao/ger_candidato.php';\", 2000);
                                                          </script>";
                                                }
                                                else {
                                    ?>              <div class="alert alert-danger">
                                                        <strong>Atenção!</strong> Houve um problema durante o cadastro do candidato. Verifique com o administrador.
                                    <?php               echo    "<script type=\"text/javascript\">
                                                                window.setTimeout(\"location.href='../votacao/ger_candidato.php';\", 2000);
                                                                </script>";
                                    ?>                </div>
                                    <?php
                                                }
                                            mysql_close($conexao); //fecha conexão com banco de dados 
                                            }
                                        }

                                        else{
                                    ?>      <div class="col-lg-4">
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Nome</span>
                                                        <input type="text" required name="nome" value="" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Login</span>
                                                        <input type="text" required name="login" value="" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Senha</span>
                                                        <input type="password" required name="senha" value="" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">E-mail</span>
                                                        <input type="email" required name="email" value="" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Setor</span>
                                                        <select name="setor" class="form-control">
                                                            <option value="SUPORTE">SUPORTE</option>
                                                            <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                                                            <option value="COMERCIAL">COMERCIAL</option>
                                                            <option value="ASSISTENCIA">ASSISTÊNCIA</option>
                                                            <option value="DESENVOLVIMENTO">DESENVOLVIMENTO</option>
                                                        </select>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                 <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Tipo</span>
                                                        <select name="tipo" class="form-control">
                                                            <option value="CANDIDATO">CANDIDATO</option>
                                                            <option value="ADMIN">ADMINISTRADOR</option>
                                                        </select>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Filial</span>
                                                        <select name="filial" class="form-control">
                                                            <option value="SP">SÃO PAULO/BRAGANÇA</option>
                                                            <option value="SAN">SANTOS</option>
                                                        </select>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Situação</span>
                                                        <select name="situacao" class="form-control">
                                                            <option value="1">ATIVO</option>
                                                            <option value="0">DESATIVADO</option>
                                                        </select>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br> 
                                                <div class=" col-lg-2">
                                                </div>
                                                <div class=" col-lg-4">
                                                    <button type="submit" name="salvar" class="btn btn-lg btn-success">SALVAR</button>
                                                </div>
                                                <div class=" col-lg-4">
                                                    <input type="button" class="btn btn-lg btn-primary" value="VOLTAR" onClick="history.go(-1)">
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
    <script src="js/validator.js"></script>
</body>

</html>
