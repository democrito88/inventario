<?php
include '../funcoes/validar.php';
include '../funcoes/conection.php';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && !antiInjection($_GET['id'])){
    $nome = "";
    $conn = conecta();
    $query = "SELECT problema FROM problema WHERE id = ".$_GET['id']." LIMIT 1";
    $sql = mysqli_query($conn, $query);
    while($problema = mysqli_fetch_assoc($sql)){
        $nome = "".$problema['problema'];
    }
    desconecta($conn);
    
    echo $nome;//return não funciona aqui.
}