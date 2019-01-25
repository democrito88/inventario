<?php
include_once '../funcoes/validar.php';
include_once '../funcoes/conection.php';
sessao(); //Para validar a exclusão, deve-se estar logado coo Administrador
if($_SERVER['REQUEST_METHOD'] === "GET" && $_SESSION['id'] === "1"){
    $id = (isset($_GET['id']) && !antiInjection($_GET['id']))? $_GET['id'] : header("Location: ../logout.php");
    $query = "DELETE FROM `usuario` WHERE `id`=".$id;
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    if(!$sql){
        header("Location: listarUsuarios.php?flag=13");
    }
    desconecta($conn);
    header("Location: listarUsuarios.php?flag=12");
}else{
    header("Location: ../logout.php");
}
