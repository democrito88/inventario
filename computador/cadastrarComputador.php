<?php
include '../funcoes/validar.php';
include './funcoesComputador.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['n']) && !is_null($_POST['n'])){
    $n = $_POST['n'];
    $query = "";
    
    switch($n){
        case '1':
            $queryBusca = "SELECT COUNT(`id`) AS existe FROM `marca` WHERE `nome` LIKE '%".$_POST['nome']."%'";
            $query = "INSERT INTO `marca` (`nome`) VALUES ('".$_POST['nome']."')";
            break;
        case '2':
            $queryBusca = "SELECT COUNT(`id`) AS existe FROM `memoria` WHERE `barramento` LIKE '%".$_POST['barramento']."%' AND `capacidade` = '".$_POST['capacidade']."'";
            $query = "INSERT INTO `memoria` (`barramento`,`capacidade`) VALUES ('".$_POST['barramento']."','".$_POST['capacidade']."')";
            break;
        case '3':
            $queryBusca = "SELECT COUNT(`id`) AS existe FROM `processador` WHERE `fabricante` LIKE '%".$_POST['fabricante']."%' AND `arquitetura` = '".$_POST['arquitetura']."' AND `modelo` LIKE '%".$_POST['modelo']."%'";
            $query = "INSERT INTO `processador` (`arquitetura`,`modelo`,`fabricante`) VALUES ('".$_POST['arquitetura']."','".$_POST['modelo']."','".$_POST['fabricante']."')";
            break;
        case '4':
            $queryBusca = "SELECT COUNT(`id`) AS existe FROM `armazenamento` WHERE `tecnologia` LIKE '%".$_POST['tecnologia']."%' AND `capacidade` = '".$_POST['capacidade']."'";
            $query = "INSERT INTO `armazenamento` (`tecnologia`,`capacidade`) VALUES ('".$_POST['tecnologia']."','".$_POST['capacidade']."')";
            break;
        case '5':
            $queryBusca = "SELECT COUNT(`id`) AS existe FROM `sistema_operacional` WHERE `nome` LIKE '%".$_POST['nome']."%' AND `licenca` = '".$_POST['licenca']."' AND `versao` LIKE '%".$_POST['versao']."%'";
            $query = "INSERT INTO `sistema_operacional` (`nome`,`licenca`,`versao`) VALUES ('".$_POST['nome']."','".$_POST['licenca']."','".$_POST['versao']."')";
            break;
        default :
            throw new Exception("<h4>Parâmetros inválidos</h4>");
    }
    
    $conn = conecta();
    
    //verifica se já existe no banco
    $jaexiste = true;
    $sql = mysqli_query($conn, $queryBusca);
    while($resultado = mysqli_fetch_assoc($sql)){
        $jaexiste = $resultado['existe'];
    }
    if($jaexiste == '0'){//se não existir, persista no banco
        $sql = mysqli_query($conn, $query);
    }
    
    desconecta($conn);
    echo $queryBusca;
    $_POST['id'] === "1" ? header("Location: ../manutencao/novoServico.php") : ( $_POST['id'] === "0" ? header("Location: novoComputador.php") : header("Location: editarComputador.php?id=".$_POST['id']) );
    
}else{
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['tombo']) && $_POST['tombo'] != ""){
            $tombo = antiInjection($_POST['tombo']) != false? "": $_POST['tombo'];
        }else{
            $tombo = 0;
        }
        $alugado  = antiInjection($_POST['alugado']) != false? "":  $_POST['alugado'];
        $marca = antiInjection($_POST['marca']) != false? "":  $_POST['marca'];
        $memoria = antiInjection($_POST['memoria']) != false? "":  $_POST['memoria'];
        $processador = antiInjection($_POST['processador']) != false? "":  $_POST['processador'];
        $armazenamento = antiInjection($_POST['armazenamento']) != false? "":  $_POST['armazenamento'];
        $so = antiInjection($_POST['so']) != false? "":  $_POST['so'];
        $flag = antiInjection($_POST['flag']) != false? "":  $_POST['flag'];
        
        $conn = conecta();
        
        //Só gerar etiqueta se não for alugado
        if($alugado === '0'){
            $querySelecionaMaxId = "SELECT COUNT(etiqueta) AS qtde FROM `computador` WHERE etiqueta NOT LIKE \"0\"";
            $sql = mysqli_query($conn, $querySelecionaMaxId);
            while($retorno = mysqli_fetch_assoc($sql)){
                $qtde = $retorno['qtde'];
            }
            $etiqueta = $qtde + 1;
        }else{
            $etiqueta = 0;
        }
        
        $query="INSERT INTO `computador`(`tombo`, `etiqueta`, `alugado`, `idMarca`, `idMem`, `idArm`, `idSO`, `idProc`) VALUES (".$tombo.", ".$etiqueta.",".$alugado.",".$marca.",".$memoria.",".$armazenamento.",".$so.",".$processador.")";
        mysqli_query($conn, $query);
        
        //consulta qual ID foi cadastrado para a página novoServico.php
        $query = "SELECT id FROM computador ORDER BY id DESC LIMIT 1";
        $sql = mysqli_query($conn, $query);
        $id = "";
        while($retorno = mysqli_fetch_assoc($sql)){
            $id = $retorno['id'];
        }
        
        //echo "Post". var_dump($_POST);
        //echo "Parâmetros: `tombo`, `alugado`, `idMarca`, `idMem`, `idArm`, `idSO`, `idProc`<br/>";
        //echo "valores: ".$tombo.",".$alugado.",".$marca.",".$memoria.",".$armazenamento.",".$so.",".$processador;
        desconecta($conn);
        $flag === "1" ? header("Location: ../manutencao/novoServico.php?etiqueta=".$etiqueta) : ( $flag === "2" ? header("Location: ../historico/novoHistorico.php?etiqueta=".$etiqueta) : header("Location: ../principal.php?flag=1") );
    }
}
