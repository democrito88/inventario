<?php
include '../funcoes/conection.php';
include '../funcoes/validar.php';
if($_SERVER['REQUEST_METHOD'] === "GET"){
    $id = antiInjection($_GET['id']) != false? "":  $_GET['id'];
}
//O histórico se apagará em cascata. Mas a manutenção não.
$querySelecionaManutencao = "SELECT m.id FROM manutencao m, historico h, computador c WHERE c.id = h.idComp AND h.idManut = m.id";
$queryApagaManutencao = "DELETE FROM `manutencao` WHERE id = ";
$queryApagaComputador = "DELETE FROM `computador` WHERE id = ".$id;

$conn = conecta();
//Deleta os registros de manutenção daquele computador
$sql = mysqli_query($conn, $querySelecionaManutencao);
while ($idManut = mysqli_fetch_assoc($sql)){
    mysqli_query($conn, $queryApagaManutencao.$idManut['id']);
}

//Deleta o computador. O registro de hitórico deve ser apagado em cascata pelo banco.
$sql = mysqli_query($conn, $queryApagaComputador);
desconecta($conn);
header("Location: ../principal.php?flag=3");