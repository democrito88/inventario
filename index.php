<?php
include_once './funcoes/validar.php';
include_once './funcoes/funcoesAvisos.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Inventário de Máquinas</title>
        <link rel="stylesheet" href="css/style.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            body{height: 100vh;}
        </style>
    </head>
    <body>
        <?php
            if(isset($_GET['flag']) && !antiInjection($_GET['flag'])){
                mostraAviso($_GET['flag']);
            }
        ?>
        <section class="fundoLogin">
            <div class="containerLogin">
                <h1 style="text-align: center;">Sistema de Inventário de Máquinas</h1>
                <img class="img-responsive" src="img/brasao.png" alt="Brasão de Olinda" height="135" width="101">

                <canvas></canvas>
                <form class="formLogin" action="validaLogin.php" method="post">

                    <?php echo isset($_GET['e']) && $_GET['e'] == "1"? "<h5>Usuário ou senha inválido</h5>": "";?>
                    <label ><b>Login</b></label>
                    <input type="text" name="login" required>

                    <label ><b>Senha</b></label>
                    <input type="password" name="senha" required>

                    <button type="submit" class="btn btn-success">Login</button>
               </form>
                <span style="margin-top: 20px !important; float: left;">Versão 0.3.0 - Todos os direitos reservados</span>
            </div>
        </section>
    </body>
</html>
