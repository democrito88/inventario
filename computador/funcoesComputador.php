<?php
include_once '../funcoes/conection.php';
function selecionaMarcas($id){
    $conn = conecta();
    $query= "SELECT * FROM marca ORDER BY `nome`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='marca' form='cadastroComputador'>";
    while($marca = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$marca['id']."' ";
        if($id === $marca['id']){$select .= " selected";}
        $select .= ">".utf8_encode($marca['nome'])."</option>";
    }
    $select .= "</select>";
    
    desconecta($conn);
    
    return $select;
}

function selecionaMemoria($id){
    $conn = conecta();
    $query= "SELECT * FROM memoria ORDER BY `barramento`, `capacidade`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='memoria' form='cadastroComputador'>";
    while($memoria = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$memoria['id']."'";
        if($id === $memoria['id']){$select .= " selected";}
        $select .= ">".utf8_encode($memoria['barramento']).(is_null($memoria['capacidade'])? "": " - ".$memoria['capacidade']."GB")."</option>";
    }
    $select .= "</select>";
    desconecta($conn);
    
    return $select;
}

function selecionaProcessador($id){
    $conn = conecta();
    $query= "SELECT * FROM processador ORDER BY `fabricante`, `modelo`, `arquitetura`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='processador' form='cadastroComputador'>";
    while($processador = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$processador['id']."'";
        if($id === $processador['id']){$select .= " selected";}
        $select .= ">".(is_null($processador['fabricante'])? "": $processador['fabricante']." - ").utf8_encode($processador['modelo'])
                .(is_null($processador['arquitetura'])? "" : " - ".$processador['arquitetura']."bits")."</option>";
    }
    $select .= "</select>";
    desconecta($conn);
    
    return $select;
}

function selecionaArmazenamento($id){
    $conn = conecta();
    $query= "SELECT * FROM armazenamento ORDER BY `tecnologia`, `capacidade`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='armazenamento' form='cadastroComputador'>";
    while($armaz = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$armaz['id']."'";
        if($id === $armaz['id']){$select .= " selected";}
        $select .= ">".utf8_encode($armaz['tecnologia']).(is_null($armaz['capacidade'])? "" : " - ".$armaz['capacidade']."GB")."</option>";
    }
    $select .= "</select>";
    desconecta($conn);
    
    return $select;
}

function selecionaSO($id){
    $conn = conecta();
    $query= "SELECT id, nome, versao, IF(licenca = '1', '(sem licença)', '') AS licenca FROM sistema_operacional ORDER BY `nome`, `versao`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='so' form='cadastroComputador'>";
    while($sistema = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$sistema['id']."'";
        if($id === $sistema['id']){$select .= " selected";}
        $select .= ">".utf8_encode($sistema['nome']).(is_null($sistema['versao'])? "" : " - ".$sistema['versao'])." ".$sistema['licenca']."</option>";
    }
    $select .= "</select>";
    desconecta($conn);
    
    return $select;
}

function gerarEtiqueta($id){
    return dechex($id + 1);
}