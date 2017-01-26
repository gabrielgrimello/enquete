<?php
   session_start();

   if(isset($_SESSION['logado']) === false){
        echo "Por favor aguarde, você será redirecionado...";
        echo "<script type=\"text/javascript\">
            window.setTimeout(\"location.href='../votacao/login.php';\", 2000);
          </script>";
         exit;
   }
   
   if ($_SESSION['permissao'] !== "ADMIN"){
       echo "Você não tem permissão para acessar esta página";
       echo "<script type=\"text/javascript\">
            window.setTimeout(\"location.href='../votacao/index.php';\", 2000);
          </script>";
       exit;
   }
   
   $nome_usuario = $_SESSION['usuario'];
   $permissao = $_SESSION['permissao'];
   $filial_session = $_SESSION['filial'];
?>
