<?php
include '../funcoes/conection.php';
include '../funcoes/validar.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['n']) && !is_null($_POST['n']) && !antiInjection($_POST['n'])){
        $n = $_POST['n'];
        $query = "";

        switch($n){
            case '1':
                $query = "INSERT INTO `problema`(`problema`) VALUES ('".$_POST['problema']."')";
                break;
            default :
                throw new Exception("<h4>Parâmetros inválidos</h4>");
        }

        $conn = conecta();
        $sql = mysqli_query($conn, $query);
        desconecta($conn);
        header("Location: novoServico.php");

    }else{
        $etiqueta = antiInjection($_POST['etiqueta']) != false? "":  $_POST['etiqueta'];
        $dataEntrada  = antiInjection($_POST['dataEntrada']) != false? "":  $_POST['dataEntrada'];
        $dataSaida = antiInjection($_POST['dataSaida']) != false? "":  $_POST['dataSaida'];
        $usuario = antiInjection($_POST['usuario']) != false? "":  $_POST['usuario'];
        $departamento = antiInjection($_POST['departamento']) != false? "":  $_POST['departamento'];
        $procedimento = antiInjection($_POST['procedimento']) != false? "":  $_POST['procedimento'];
        $observacao = antiInjection($_POST['observacao']) != false? "":  $_POST['observacao'];
        $idUsuario = antiInjection($_POST['idUsuario']) != false? "":  $_POST['idUsuario'];

        $conn = conecta();
        //Busca o id do computador para persistir na tabela manutencao
        $idComp = "";
        $queryBuscaComputador = "SELECT id FROM computador WHERE etiqueta = ".$etiqueta." LIMIT 1";
        $sql = mysqli_query($conn, $queryBuscaComputador);
        while($computador = mysqli_fetch_assoc($sql)){
            $idComp = $computador['id'];
        }
        
        //grava na tabela manutencao
        $queryInsereManutencao="INSERT INTO `manutencao`(`procedimento`, `observacao`) VALUES ('".$procedimento."', '".$observacao."')";
        $sql = mysqli_query($conn, $queryInsereManutencao);
        
        //Busca o id em manutencao para persistir na tabela manutencao_problema
        $idManut = "";
        $queryBuscaComputador = "SELECT id FROM manutencao ORDER BY id DESC LIMIT 1";
        $sql = mysqli_query($conn, $queryBuscaComputador);
        while($manutencao = mysqli_fetch_assoc($sql)){
            $idManut = $manutencao['id'];
        }
        
        //grava na tabela manutencao_problema
        $problemasArray = $_POST['prob'];
        for($i = 0; $i < sizeof($problemasArray); $i++){
            $queryInsereEntradaProblema = "INSERT INTO `manutencao_problema`(`idManut`, `idProb`) VALUES ('".$idManut."', '".$problemasArray[$i]."')";
            $sql = mysqli_query($conn, $queryInsereEntradaProblema);
        }
        
        //caso não tenha mudado o usuário e o departamento (campos deixados em branco)
        if(is_null($usuario) && is_null($departamento)){
            //busca os dados da última entrada deste computador
            $queryBuscaHistorico = "SELECT usuario, departamento FROM historico WHERE idComp = ".$idComp." ORDER BY dataEntrada DESC LIMIT 1";
            $sql = mysqli_query($conn, $queryBuscaHistorico);
            while($historico = mysqli_fetch_assoc($sql)){
                $usuario = $historico['usuario'];
                $departamento = $historico['departamento'];
            }
        }
        
        //grava na tabela historico
        $queryInsereHistorico = "INSERT INTO `historico`(`idComp`, `idManut`, `idUsuario`, `usuario`, `departamento`, `dataEntrada`, `dataSaida`, `descricao`) VALUES ('".$idComp."', '".$idManut."', '".$idUsuario."', '".$usuario."', '".$departamento."', '".$dataEntrada."', '".$dataSaida."', '')";
        $sql = mysqli_query($conn, $queryInsereHistorico);
        
        desconecta($conn);
        header("Location: ../principal.php?flag=4");
        //echo "<br/>etiqueta: ".$etiqueta."<br/>dataEntrada: ".$dataEntrada."<br/>dataSaida: ".$dataSaida."<br/>Usuário: ".$usuario."<br/>departamento: ".$departamento;
        //echo "<br/>procedimento: ".$procedimento."<br/>Observação: ".$observacao."<br/>";
        //echo "<br/>idEnt: ".$idEnt;
        //echo "<br/>Problemas: ".implode(", ", $problemasArray);
    }
}