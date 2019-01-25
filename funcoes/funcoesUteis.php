<?php
include_once 'conection.php';
//métodos usados em diversos formulários
function selecionaUsuario($id){
    $conn = conecta();
    $query= "SELECT id, nome FROM usuario WHERE login NOT LIKE 'admin' ORDER BY nome";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select id='selectUsuario' name='idUsuario' required>";
    $select .= "<option value=''>Selecione um usuário</option>";
    while($usuario = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$usuario['id']."' ";
        $select .= "".($usuario['id'] == $id ? "selected>" : ">" ).utf8_encode($usuario['nome'])."</option>";
    }
    $select .= "</select>";
    
    desconecta($conn);
    
    return $select;
}

function selecionaDepartamento($id){
    $conn = conectaGLPI();
    $query= "SELECT `id`, TRIM('Root entity > P.M.O. > ' FROM `completename`) as nome FROM `glpi_entities` WHERE `id` <> '0' AND `id` <> '22'  ORDER BY `completename`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='departamento' required>";
    $select .= "<option value=''>Selecione um departamento</option>";
    while($departamento = mysqli_fetch_assoc($requisicao)){
        if($departamento['id'] !== "0"){
            $select .= "<option value='".$departamento['id']."' ";
            $select .= ($departamento['id'] == $id? "selected>": ">").utf8_encode($departamento['nome'])."</option>";
        }
    }
    $select .= "</select>";
    
    desconecta($conn);
    
    return $select;
}

function nomeDepartamento($id){
    $conn = conectaGLPI();
    $query= "SELECT TRIM('Root entity > P.M.O. > ' FROM `completename`) as nome FROM `glpi_entities` WHERE `id` = ".$id;
    $requisicao = mysqli_query($conn, $query);
    $nome = "";
    if($requisicao){
        while($departamento = mysqli_fetch_assoc($requisicao)){
            $nome .= utf8_encode($departamento['nome']);
        }
    }
    
    desconecta($conn);
    
    return $nome;
}

