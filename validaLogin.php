<?php
include './funcoes/conection.php';
include './funcoes/validar.php';

$login = $_POST['login'];
$senha = $_POST['senha'];

if(antiInjection($login) != false || antiInjection($senha) !=false){
    header("Location: index.php?flag=10");
}

$conn = conecta();
$query = "SELECT id, nome FROM usuario WHERE login = '".$login."' AND senha = SHA1('".$senha."')";
$sql = mysqli_query($conn, $query);
desconecta($conn);
if(is_null($sql) || is_bool($sql)){
    echo "<h1>ERROR: query inválida</h1><br/>";
    echo $conn != false? "conn: true<br/>" : "conn: false <br/>";
    echo $sql != false? "sql: true<br/>" : "sql: false<br/>";
}else{
    if(mysqli_num_rows($sql)<= 0){
        header("Location: index.php?flag=10");
    }else{
        while($resultado = mysqli_fetch_assoc($sql)){
            $nome = $resultado['nome'];
            $id = $resultado['id'];
        }
        $_SESSION['login'] = $nome;
        $_SESSION['id'] = $id;
        header("Location: principal.php");
    }
}
