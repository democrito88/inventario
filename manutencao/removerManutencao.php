<?php
include '../funcoes/conection.php';
include '../funcoes/validar.php';
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])){
    $id = antiInjection($_GET['id']) === false? $_GET['id'] : "";
    $query = array("DELETE FROM `historico` WHERE idManut = ".$id,
        "DELETE FROM `manutencao_problema` WHERE idManut = ".$id,
        "DELETE FROM `manutencao` WHERE id = ".$id);
    
    $conn = conecta();
    for($i =0; $i<3; $i++){
        $sql = mysqli_query($conn, $query[$i]);
        //echo "<br/>ID: ".$id.", SQL ".$i.": ".($sql == false? "falso": "verdadeiro");
    }
    desconecta($conn);
    
    header("Location: ../principal.php?flag=6");
}