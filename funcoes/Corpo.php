<?php
include_once 'validar.php';
function cabecalho(){
    sessao();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventário de Computadores</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="js/script.js"></script>
        <script src="../js/script.js"></script>
    </head>
    <body>
        <div id="modalPrincipal" class="modalFundo"></div>
        <header>
            <h2><i class="glyphicon glyphicon-tasks"></i>&nbsp;Sistema de Inventário de Computadores da PMO</h2>
            <div class="dropdown" style="float: right;">
                Bem vindo,&nbsp;<a class="dropdown-toggle" data-toggle="dropdown"><?php echo isset($_SESSION['login']) ? "".utf8_encode($_SESSION['login'])."&nbsp;&nbsp;": "";?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a onclick="editarUsuario('<?php echo $_SESSION['id'];?>',true);">Editar meus dados</a></li>
                    <?php if($_SESSION['id'] === "1"){
                        echo "<li><a href=\"./usuario/listarUsuarios.php\">Editar usuários</a></li>";
                    }?>
                    <li class="divider"></li>
                    <li><a href="http://localhost/inventario/logout.php">Logout</a></li>
                </ul>
            </div>    
        </header>
        <?php
}

function rodape(){
    ?>
        <footer><p>Sistema de inventário de computadores - versão 0.3.1 - Todos os direitos reservados</p></footer>
    </body>
</html>
        <?php
}