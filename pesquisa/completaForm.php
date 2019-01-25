<?php
include_once '../funcoes/validar.php';
include_once '../funcoes/conection.php';
include_once '../funcoes/funcoesUteis.php';

if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['select']) ){
    $select = antiInjection($_GET['select']) === false? $_GET['select'] : "";
}else{
    throw new Exception("<h4>Parâmetros inválidos</h4>");
}

$conn = conecta();

switch ($select){
    case '1': 
        $formulario ="<p>Tombo:&nbsp;<input type='text' name='tombo'></p><br/>";
        echo $formulario;
        break;
    
    case '2':
        $formulario ="<p>Etiqueta:&nbsp;<input type='text' name='etiqueta'></p><br/>";
        echo $formulario;
        break;
    
    case '3':
        $formulario ="<label>Alugado? </label>&nbsp;
                <input type=\"radio\" name=\"alugado\" value=\"1\"> Sim&nbsp;
                <input type=\"radio\" name=\"alugado\" value=\"0\"> Não";
        echo $formulario;
        break;
    
    case '4': 
        $query = "SELECT id, capacidade FROM armazenamento GROUP BY capacidade ORDER BY capacidade";
        $query1 = "SELECT id, tecnologia FROM armazenamento GROUP BY tecnologia ORDER BY tecnologia";
        
        $sql = mysqli_query($conn, $query);
        $sql1 = mysqli_query($conn, $query1);
        
        $capacidade = "<p>Capacidade: <select name='armcapacidade'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql)){
            $capacidade .= "<option value=".$option['capacidade'].">".$option['capacidade']." GB</option>";
        }
        
        $tecnologia = "<p>Tecnologia: <select name='tecnologia'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql1)){
            $tecnologia .= "<option value=".$option['tecnologia'].">".$option['tecnologia']."</option>";
        }
        
        $capacidade .= "</select></p><br/>";
        $tecnologia .= "</select></p><br/>";
        
        echo $tecnologia."&nbsp;&nbsp;".$capacidade;
        break;
        
    case '5': $query = "SELECT id, nome FROM marca";
        $sql = mysqli_query($conn, $query);
        $nome = "<p>Marca: <select name='idmarca'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql)){
            $nome .= "<option value=".$option['id'].">".$option['nome']."</option>";
        }
        
        $nome .= "</select></p><br/>";
        
        echo $nome;
        break;
        
    case '6': 
        $query = "SELECT id, barramento FROM memoria GROUP BY barramento";
        $query1 = "SELECT id, capacidade FROM memoria GROUP BY capacidade";
        
        $sql = mysqli_query($conn, $query);
        $sql1 = mysqli_query($conn, $query1);
        
        $barramento = "<p>Barramento: <select name='barramento'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql)){
            $barramento .= "<option value=".$option['barramento'].">".$option['barramento']."</option>";
        }
        
        $capacidade = "<p>Capacidade: <select name='capacidade'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql1)){
            $capacidade .= "<option value=".$option['capacidade'].">".$option['capacidade']." GB</option>";
        }
        
        $barramento .= "</select></p><br/>";
        $capacidade .= "</select></p><br/>";
        
        echo $barramento."&nbsp;&nbsp;".$capacidade;
        break;
    
    case '7': 
        $query = "SELECT id, nome, CONCAT_WS(\" \", nome, versao) AS nomecompl FROM sistema_operacional";
        $query1 = "SELECT licenca, IF(licenca = '0', \"Não precisa\", IF(licenca = '1', 'Não possui', 'Possui')) AS licenciado FROM sistema_operacional GROUP BY licenca";
        $sql = mysqli_query($conn, $query);
        $sql1 = mysqli_query($conn, $query1);
        
        $nome = "<p>Nome: <select name='nome'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql)){
            $nome .= "<option value=".$option['nome'].">".$option['nomecompl']."</option>";
        }
        
        $licenca = "<p>Licença: <select name='licenca'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql1)){
            $licenca .= "<option value=".$option['licenca'].">".$option['licenciado']."</option>";
        }
        
        $nome .= "</select></p><br/>";
        $licenca .= "</select></p><br/>";
        
        echo $nome."&nbsp;&nbsp;".$licenca;
        break;
        
    case '8': $query = "SELECT id, modelo, CONCAT_WS( \" \", fabricante, modelo) AS nome, arquitetura FROM processador";
        $sql = mysqli_query($conn, $query);
        
        $nome = "<p>Nome: <select name='nome'><option value=''>escolha...</option>";
        $arquitetura = "<p>Arquitetura: <select name='arquitetura'><option value=''>escolha...</option>";
        while($option = mysqli_fetch_assoc($sql)){
            $nome .= "<option value='".$option['modelo']."'>".$option['nome']."</option>";
            if($option['arquitetura'] != "" || !is_null($option['arquitetura']) ){
                $arquitetura .= "<option value='".$option['arquitetura']."'>".$option['arquitetura']." bits</option>";
            }
        }
        
        $nome .= "</select></p><br/>";
        $arquitetura .= "</select></p><br/>";
        
        echo $nome."&nbsp;&nbsp;".$arquitetura;
        break;
    case '9':
        $formulario ="<p>Etiqueta do computador:&nbsp;<input type='text' name='etiqueta'></p><br/>";
        echo $formulario;
        break;
    case '10':
        $formulario ="<p>Usuário:&nbsp;<input type='text' name='usuario'></p><br/>";
        echo $formulario;
        break;
    case '11': 
        $formulario ="<p>Departamento:&nbsp;". selecionaDepartamento(0)."</p><br/>";
        echo $formulario;
        break;
    case '12': 
        $formulario ="<p>Data de Entrada</p><br/>de:&nbsp;<input type='date' name='dataEntradaInicial'><br/>"
            . "até:&nbsp;<input type='date' name='dataEntradaFinal'><br/>";
        echo $formulario;
        break;
    case '13': 
        $formulario ="<p>Data de Saída</p><br/>de:&nbsp;<input type='date' name='dataSaidaInicial'><br/>"
            . "até:&nbsp;<input type='date' name='dataSaidaFinal'><br/>";
        echo $formulario;
        break;
    default :
        break;
}

desconecta($conn);