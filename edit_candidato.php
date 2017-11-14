<?php
   include 'session.php';
   
    function setLOG($MSG, $REL) {
        include 'conexao.inc'; //inclui a conexao com o banco
        $IP = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
        
        date_default_timezone_set('America/Sao_Paulo'); 
        $HORA = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
        $nome_usuario = strtoupper($_SESSION['usuario']);
        $MSGF = mysqli_escape_string($conexao,$MSG); // Limpando String

        // Monta a query para inserir o log no sistema
        
        $sql = "INSERT INTO logs (logid,hora,ip,relacionamento,mensagem,acao) VALUES (null,'$HORA','$IP','$REL','$MSGF','$nome_usuario')"; 
        if (mysqli_query($conexao,$sql)) //Realiza a consulta
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
                                $login = $_POST['login'];
                                $email = $_POST['email'];
                                $setor = $_POST['setor'];
                                $tipo = $_POST['tipo'];
                                $filial = $_POST['filial'];
                                $votosenv = $_POST['votosenv'];
                                $situacao = $_POST['situacao'];
                                
                               
                                // inserindo valores recebidos na base de dados
                                mysqli_query($conexao,"UPDATE tb_candidato SET nome_cand='$nome',login_cand='$login',email_cand='$email',filial_cand='$filial',setor_cand='$setor',tipo_cand='$tipo',votosenv_cand='$votosenv',ativado_cand='$situacao' WHERE cod_cand=$cod_candidato");
                                // grava log na base
                                setLOG("Usuario $nome", "ALTERACAO USUARIO");
                              
                                if(mysqli_affected_rows($conexao) > 0){ //verifica se foi afetada alguma linha, nesse caso atualizada alguma linha
                    ?>              <br>
                                    <div class="alert alert-success">
                                        <strong>Muito bem!</strong> Os dados do usuário foram atualizados com sucesso.
                                    </div>
                    <?php
                                    echo "<script type=\"text/javascript\">
                                            window.setTimeout(\"location.href='../votacao/ger_candidato.php';\", 2000);
                                          </script>";
                                } 
                                else {
                    ?>
                                    <div class="alert alert-danger">
                                    <strong>Atenção!</strong> Houve um problema na atualização dos dados do usuário. Verifique com o administrador.
                                    </div>
                    <?php
                                }
                                 
                            }//fecha if isset
                            else{ // else do isset
                    ?> 
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <form action="edit_candidato.php" data-toggle="validator" method="post">
                    <?php
                                            //verifica se existe conexão com bd, caso não tenta criar uma nova
                                            include 'conexao.inc';
                                            $cod_cand = $_GET['id']; // Recebendo o valor vindo do link
                                            $sql = mysqli_query($conexao,"Select * From tb_candidato WHERE cod_cand=$cod_cand");
                                            $linha = mysqli_fetch_array($sql)
                                                            
                    ?> 
                                            <div class="col-lg-4">
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="hidden" name="cod_cand" class="form-control" readonly="" value="<?php echo $linha['cod_cand']; ?>">
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Nome</span>
                                                        <input type="text" required name="nome" value="<?php echo $linha['nome_cand']; ?>" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Login</span>
                                                        <input type="text" required name="login" value="<?php echo $linha['login_cand']; ?>" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">E-mail</span>
                                                        <input type="email" required name="email" value="<?php echo $linha['email_cand']; ?>" class="form-control">
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Setor</span>
                                                        <select name="setor" class="form-control">
                                                            <option value="SUPORTE" <?php if($linha['setor_cand']=='SUPORTE') echo 'selected';?>>SUPORTE</option>
                                                            <option value="ADMINISTRATIVO" <?php if($linha['setor_cand']=='ADMINISTRATIVO') echo 'selected';?>>ADMINISTRATIVO</option>
                                                            <option value="COMERCIAL" <?php if($linha['setor_cand']=='COMERCIAL') echo 'selected';?>>COMERCIAL</option>
                                                            <option value="ASSISTENCIA" <?php if($linha['setor_cand']=='ASSISTENCIA') echo 'selected';?>>ASSISTÊNCIA</option>
                                                            <option value="DESENVOLVIMENTO" <?php if($linha['setor_cand']=='DESENVOLVIMENTO') echo 'selected';?>>DESENVOLVIMENTO</option>
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
                                                            <option value="CANDIDATO" <?php if($linha['tipo_cand']=='CANDIDATO') echo 'selected';?>>CANDIDATO</option>
                                                            <option value="ADMIN"<?php if($linha['tipo_cand']=='ADMIN') echo 'selected';?>>ADMINISTRADOR</option>
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
                                                            <option value="SP" <?php if($linha['filial_cand']=='SP') echo 'selected';?>>SÃO PAULO/BRAGANÇA</option>
                                                            <option value="SAN" <?php if($linha['filial_cand']=='SAN') echo 'selected';?>>SANTOS</option>
                                                        </select>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Votos enviados</span>
                                                    <input type="text" required name="votosenv" value="<?php echo $linha['votosenv_cand']; ?>" class="form-control">
                                                </div>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>
                                                </div>
                                                <br>
                                                <div class="form-group has-feedback">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Situação</span>
                                                        <select name="situacao" class="form-control">
                                                            <option value="1" <?php if($linha['ativado_cand']=='1') echo 'selected';?>>ATIVO</option>
                                                            <option value="0" <?php if($linha['ativado_cand']=='0') echo 'selected';?>>DESATIVADO</option>
                                                        </select>
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
