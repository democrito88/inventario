<?php
include '../funcoes/conection.php';
include '../funcoes/validar.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $etiqueta = antiInjection($_POST['etiqueta']) == false ? $_POST['etiqueta']: "";
    $usuario = antiInjection($_POST['usuario']) == false ? $_POST['usuario']: "";
    $departamento = antiInjection($_POST['departamento']) == false ? $_POST['departamento']: "";
    $dataEntrada = antiInjection($_POST['dataEntrada']) == false ? $_POST['dataEntrada']: "";
    $dataSaida = antiInjection($_POST['dataSaida']) == false ? $_POST['dataSaida']: "";
    $descricao = antiInjection($_POST['descricao']) == false ? $_POST['descricao']: "";
    $idUsuario = antiInjection($_POST['idUsuario']) == false ? $_POST['idUsuario']: "";
    
    //Busca o id do coputador cuja a etiqueta se sabe
    $queryBuscaComputador = "SELECT id FROM computador WHERE etiqueta = ".$etiqueta." LIMIT 1";
    $conn = conecta();
    $sql = mysqli_query($conn, $queryBuscaComputador);
    while($computador = mysqli_fetch_assoc($sql)){
        $idComp = $computador['id'];
    }
    
    //Inserindo na tabela Histórico. Não insere o campo `idManut` pois não é um serviço de manutenção (assumirá NULL).
    $queryInsereHistorico = "INSERT INTO `historico`(`idComp`, `idUsuario`, `usuario`, `departamento`, `dataEntrada`, `dataSaida`, `descricao`) VALUES ('".$idComp."', '".$idUsuario."', '".$usuario."', '".$departamento."', '".$dataEntrada."', '".$dataSaida."', '".$descricao."')";
    $sql = mysqli_query($conn, $queryInsereHistorico);
    desconecta($conn);
    
    //echo "etiqueta: ".$etiqueta.", usuario: ".$usuario.", departamento: ".$departamento.", dataEntrada: ".$dataEntrada.", dataSaida: ".$dataSaida.", descricao: ".$descricao.", idUsuario: ".$idUsuario."<br/>";
    //echo "SQL: ".($sql == false? "falso" : "verdadeiro");
    header("Location: ../principal.php?flag=7");
}
