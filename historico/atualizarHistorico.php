<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/validar.php';
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $id = antiInjection($_POST['id']) == false ? $_POST['id']: "";
    $etiqueta = antiInjection($_POST['etiqueta']) == false ? $_POST['etiqueta']: "";
    $usuario = antiInjection($_POST['usuario']) == false ? $_POST['usuario']: "";
    $departamento = antiInjection($_POST['departamento']) == false ? $_POST['departamento']: "";
    $dataEntrada = antiInjection($_POST['dataEntrada']) == false ? $_POST['dataEntrada']: "";
    $dataSaida = antiInjection($_POST['dataSaida']) == false ? $_POST['dataSaida']: "";
    $descricao = antiInjection($_POST['descricao']) == false ? $_POST['descricao']: "";
    $idUsuario = antiInjection($_POST['idUsuario']) == false ? $_POST['idUsuario']: "";
    
    $conn = conecta();
    //Verifica se a etiqueta é válida
    $queryUpdateComputador = "SELECT id FROM computador WHERE etiqueta = ".$etiqueta;
    $sql = mysqli_query($conn, $queryUpdateComputador);
    
    if(mysqli_num_rows($sql) === 0){
        header("Location: editarHistorico.php?id=".$id."&etiqueta=".$etiqueta);
    }else{
        while($resultado = mysqli_fetch_assoc($sql)){
            $idComp = $resultado['id'];
        }
    }
    
    $queryUpdateHistorico = "UPDATE `historico` SET `idComp`='".$idComp."', `idUsuario`='".$idUsuario."', `usuario`='".$usuario."', `departamento`='".$departamento."', `dataEntrada`='".$dataEntrada."',`dataSaida`='".$dataSaida."', `descricao`='".$descricao."' WHERE `id` = ".$id;
    $sql = mysqli_query($conn, $queryUpdateHistorico);
    desconecta($conn);
    
    //echo "etiqueta: ".$etiqueta.", usuario: ".$usuario.", departamento: ".$departamento.", dataEntrada: ".$dataEntrada.", dataSaida: ".$dataSaida.", descricao: ".$descricao.", idUsuario: ".$idUsuario."<br/>";
    //echo "SQL: ".($sql == false? "falso" : "verdadeiro");
    
    header("Location: ../principal.php?flag=8");
}

