<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/validar.php';
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])){
    $id = antiInjection($_GET['id']) == false ? $_GET['id']: "";
    
    $conn = conecta();
    
    //Verifica se o histórico é um serviço de manutenção. Se sim, chama o removerManutenção.php
    $querySelecionaHistorico = "SELECT idManut FROM historico WHERE id = ".$id;
    $sql = mysqli_query($conn, $querySelecionaHistorico);
    while($historico = mysqli_fetch_assoc($sql)){
        if($historico['idManut'] !== NULL){
            header("Location: ../manutencao/removerManutencao.php?id=".$historico['idManut']);
        }
    }
    
    $queryApagaHistorico = "DELETE FROM `historico` WHERE id = ".$id;
    $sql = mysqli_query($conn, $queryApagaHistorico);
    desconecta($conn);
    echo $sql === false ? "flaso" : "verdadeiro";
    //header("Location: ../principal.php?flag=9");
}