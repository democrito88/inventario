<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/validar.php';
sessao();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $nome  = antiInjection($_POST['nome']) != false? "":  $_POST['nome'];
    $login = antiInjection($_POST['login']) != false? "":  $_POST['login'];
    $senha = antiInjection($_POST['senha']) != false? "":  $_POST['senha'];

    $query = "INSERT INTO `usuario` (`nome`, `login`, `senha`) VALUES ('".$nome."', '".$login."', SHA1('".$senha."'))";
    $conn = conecta();
    mysqli_query($conn, $query);
    desconecta($conn);
    header("Location: listarUsuarios.php");
}

