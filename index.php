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
    $votosenv_session = $_SESSION['votosenv'];
   

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
                    if($permissao == "ADMIN"){
                    include 'barra_acoes.html';
                    
                    }
                    ?>
                    
                    
                    <div class="col-lg-1">
                    </div>
                    
                    <div class="col-lg-10">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title text-center">Votação destaque do ano</h2>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                <br>
                                <div class="alert alert-success text-center">
                                    <strong>BEM VINDO A VOTAÇÃO DESTAQUE 2016!</strong><br> Você está prestes a votar no destaque 2016, mas antes de começar comunicamos que toda campanha de votos é válida!
                                </div>
                                
                                <div class="alert alert-warning text-center">
                                    <strong>LEIA ATENTAMENTE AS REGRAS ANTES DE COMEÇAR, BASTA CLICAR NO BOTÃO REGRAS AQUI NO CANTO DA TELA</strong>
                                </div>
                                
                                <div class="text-right">
                                <button class="btn btn-lg btn-danger" data-toggle="modal" data-target=".bd-example-modal-lg">REGRAS</button>
                                </div>
                                
                                <br><br>
                                
                                <div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <br>
                                            
                                            <div class="alert alert-success">
                                                <strong> A partir de agora você terá direto a dois votos: <br></strong> <br>
                                                
                                                    1) O primeiro voto é para o <strong> Destaque do ano </strong> - é aquele que ajudou melhor os clientes, que colaborou com seus colegas, ou porque você considera ele como uma pessoa que se destacou esse ano.
                                                    <br>
                                                    2) O segundo voto é para o <strong> Destaque futuro </strong> - é aquele que você vê o potencial dele, que acredita que ele tem muito a oferecer a todos no ano que vem.

                                            </div>
                                            
                                            <div class="alert alert-danger">
                                                <strong>Agora vamos as regras:</strong><br><br>
                                                    1)	Não é possível votar em si mesmo;
                                                    <br>
                                                    2)	Você só pode votar uma única vez para cada modalidade (Destaque e futuro destaque). 
                                                    <br>
                                                    3)	Não serão computados votos para mesma pessoa.
                                                    <br>
                                                    4)	A Votação acontece até 8/12/2016.
                                                    <br>
                                                    5)	O prêmio será entregue no dia da Confraternização.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    
                                
                                
                                <?php
                                    if (isset($_POST['votar'])){
                                        include 'conexao.inc';
                                        $cod_candidato_voto = $_POST['voto'];//recebe o codigo do candidato escolhido
                                        
                                        //faz o select para pegar dados do candidato que efetuou o voto
                                        $sql3 = mysql_query("Select * From tb_candidato where cod_cand='$codigo_cand'");
                                        $linha3 = mysql_fetch_array($sql3);
                                        $votosenv = $linha3['votosenv_cand'];
                                        
                                        switch ($votosenv){
                                            case 0:
                                        $votosenv = $linha3['votosenv_cand']+1; //soma um nos votos enviados de quem efetuou o voto e grava no BD
                                        mysql_query("UPDATE tb_candidato SET votosenv_cand='$votosenv', votoenvdest_cand='$cod_candidato_voto' WHERE cod_cand=$codigo_cand");
                                        
                                        // pega dados do candidato que recebeu o voto, como é o primeiro soma um no campo destaque
                                        $sql2 = mysql_query("Select * From tb_candidato where cod_cand='$cod_candidato_voto'");
                                        $linha2 = mysql_fetch_array($sql2);
                                        $votorecdest = $linha2['votorecdest_cand']+1;
                                        $nome_candidato=$linha2['nome_cand'];
                                        mysql_query("UPDATE tb_candidato SET votorecdest_cand='$votorecdest' WHERE cod_cand=$cod_candidato_voto");
                                        break;
                                    
                                            case 1:
                                        $votosenv = $linha3['votosenv_cand']+1;
                                        mysql_query("UPDATE tb_candidato SET votosenv_cand='$votosenv', votoenvdestfut_cand='$cod_candidato_voto' WHERE cod_cand=$codigo_cand");
                                        
                                        // pega dados do candidato que recebeu o voto, como é o primeiro soma um no campo destaque
                                        $sql2 = mysql_query("Select * From tb_candidato where cod_cand='$cod_candidato_voto'");
                                        $linha2 = mysql_fetch_array($sql2);
                                        $votorecdestfut = $linha2['votorecdestfut_cand']+1;
                                        $nome_candidato=$linha2['nome_cand'];
                                        mysql_query("UPDATE tb_candidato SET votorecdestfut_cand='$votorecdestfut' WHERE cod_cand=$cod_candidato_voto");
                                        break;     
                                        }
                                        
                                        setLOG("Usuario $nome_usuario votou no candidato $nome_candidato", "VOTAÇÃO");

                                        if(mysql_affected_rows() > 0){ //verifica se foi afetada alguma linha, nesse caso atualizada alguma linha
                            ?>
                                            <div class="alert alert-success text-center">
                                            <strong>OBRIGADO!</strong> Seu voto foi computado com sucesso.
                                            </div>
                            <?php
                                            echo "<script type=\"text/javascript\">
                                                    window.setTimeout(\"location.href='../votacao/index.php';\", 2000);
                                                  </script>";
                                        } 
                                        else{
                            ?>
                                            <div class="alert alert-danger text-center">
                                            <strong>Atenção!</strong> Houve um problema durante a votação. Verifique com o administrador.
                                            </div>
                            <?php
                                        }
                                            
                                    }//fecha if isset
                                    else{
                                        include 'conexao.inc';
                                        $sql3 = mysql_query("Select * From tb_candidato where cod_cand='$codigo_cand'");
                                        $linha3 = mysql_fetch_array($sql3);
                                        $votosenv = $linha3['votosenv_cand'];   
                                        if($votosenv<2){                                            
                            ?>
                                            <form action="index.php" data-toggle="validator" method="post">   
                                                <table id="table-usuarios" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Setor</th>
                                                            <th class="text-center">Votar</th>
                                                        </tr>
                                                    </thead>
                            <?php
                                                    //verifica se existe conexão com bd, caso não tenta criar uma nova
                                                    include 'conexao.inc';
                                                    $sql2 = mysql_query("Select * From tb_candidato where cod_cand='$codigo_cand'");
                                                    $linha2 = mysql_fetch_array($sql2);
                                                    $sql = mysql_query("Select * From tb_candidato where (ativado_cand=1 and dispvoto_cand=1 and filial_cand='$filial_session' and cod_cand!='$codigo_cand' and cod_cand!='$linha2[votoenvdest_cand]')");

                                                    while($linha = mysql_fetch_array($sql)) //Já a instrução while faz um loop entre todos os registros e armazena seus valores na variável $linha
                                                    { //Inicia o loop
                            ?> 
                                                        <tr> 
                                                            <input type="hidden" name="cod_cand" class="form-control" readonly="" value="<?php echo $linha['cod_cand']; ?>">
                                                            <td><?php echo strtoupper($linha['nome_cand']); ?></td> 
                                                            <td><?php echo strtoupper($linha['setor_cand']); ?></td> 


                                                            <td class="text-center">
                                                                <input type="radio" required name="voto" value="<?php echo $linha['cod_cand']; ?>">
                                                            </td>
                                                        </tr>
                            <?php

                                                    } // Retorna para o início do loop caso existam mais registros a serem mostrados
                            ?>
                                                </table>
                                                <br> 
                                                <div class=" col-lg-4">
                                                </div>

                                                <div class=" col-lg-4">
                                                    <button type="submit" name="votar" class="btn btn-lg btn-success">CONFIRMAR VOTO</button>
                                                </div>

                                            </form>
                            <?php
                                        } //fecha if do teste se ja votou duas vezes
                                        if($votosenv>=2){
                            ?>
                                            <div class="alert alert-success text-center">
                                                <strong>Você já votou nos candidatos!</strong> Aguarde a divulgação dos resultados durante a confraternização.
                                            </div>
                            <?php
                                        }
                                            
                                            
                                    } //fecha else do isset
                            ?>
                                
                                </div> <!-- div table responsible -->
                            </div><!-- div painel body -->
                        </div> <!-- div panel primary -->
                    </div><!-- div col lg-10 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validator.js"></script>
    

</body>

</html>
