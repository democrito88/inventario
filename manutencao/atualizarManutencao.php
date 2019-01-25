<?php
include '../funcoes/validar.php';
include_once '../funcoes/conection.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $id = antiInjection($_POST['id']) == false? $_POST['id']: "";
    $idManut = antiInjection($_POST['idManut']) == false? $_POST['idManut']: "";
    $procedimento = antiInjection($_POST['procedimento']) == false? $_POST['procedimento']: "";
    $observacao = antiInjection($_POST['observacao']) == false? $_POST['observacao']: "";
    $idUsuario = antiInjection($_POST['idUsuario']) == false? $_POST['idUsuario']: "";
    $dataEntrada = antiInjection($_POST['dataEntrada']) == false? $_POST['dataEntrada']: "";
    $dataSaida = antiInjection($_POST['dataSaida']) == false? $_POST['dataSaida']: "";
    $usuario = antiInjection($_POST['usuario']) == false? $_POST['usuario']: "";
    $departamento = antiInjection($_POST['departamento']) == false? $_POST['departamento']: "";
    $problemasArray = isset($_POST['prob']) ? $_POST['prob']: null;
    
    $conn = conecta();
    
    //Atualiza a tabela manutenção. Sem mudar o campo id
    $queryUpdateManutencao = "UPDATE `manutencao` SET `procedimento`='".$procedimento."', `observacao`='".$observacao."' WHERE id = ".$idManut;
    $up1 = mysqli_query($conn, $queryUpdateManutencao);
    
    //Atualiza a tabela histórico. Sem mudar os campos id, idComp, idManut
    $queryUpdateHistorico = "UPDATE `historico` "
            . "SET `idUsuario`='".$idUsuario."', `usuario`='".$usuario."', `departamento`='".$departamento."', `dataEntrada`='".$dataEntrada."', "
            . "`dataSaida`='".$dataSaida."', `descricao`= ''"
            . " WHERE id = ".$id;
    $up2 = mysqli_query($conn, $queryUpdateHistorico);
    
    //Atualiza a tabela manutencao_problema. Sem mudar o campo id
    //Primeiro, remove as entrdas antigas
    $queryRemoveManutencaoProblema = "DELETE FROM `manutencao_problema` WHERE idManut = ".$idManut;
    $up3 = mysqli_query($conn, $queryRemoveManutencaoProblema);
    
    //Depois, insere as novas entradas
    if($problemasArray != null){
        for($i = 0; $i < sizeof($problemasArray); $i++){
            $queryInsereManutencaoProblema = "INSERT INTO `manutencao_problema`(`idManut`, `idProb`) VALUES ('".$idManut."', '".$problemasArray[$i]."')";
            $up4 = mysqli_query($conn, $queryInsereManutencaoProblema);
        }
    }
    
    desconecta($conn);
    //echo "id: ".$id.", idManut: ".$idManut.", procedimento:".$procedimento.", observação:".$observacao.", idUsuario:".$idUsuario." dataEntrada: ".$dataEntrada.", dataSaida: ".$dataSaida.", usuario: ".$usuario.", departamento:".$departamento."<br>";
    //echo var_dump($problemasArray);
    //echo "<br>up1: ".($up1 === false? "falso":"verdadeiro").", up2: ".($up2 === false? "falso":"verdadeiro").", up3: ".($up3 === false? "falso":"verdadeiro").", up4: ".($up4 === false? "falso":"verdadeiro");
    header("Location: ../principal.php?flag=5");
}else{
    throw new Exception("<h4>Tentativa de injeção maliciosa detectada</h4>");
}
