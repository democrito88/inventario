<?php
include_once '../../funcoes/conection.php';
include_once '../../funcoes/validar.php';
include_once '../../funcoes/funcoesUteis.php';

if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])){
    $id = !antiInjection($_GET['id'])? $_GET['id'] : "";
    $nome = ($id == '1')? "departamentoM" : (($id == '2')? "departamentoH" : "");
    if($nome === ""){
        throw new Exception("<h4>Parâmetros inválidos: ".$_GET['opcao']."</h4>");
    }
    
    $conn = conectaGLPI();
    $query= "SELECT `id`, TRIM('Root entity > P.M.O. > ' FROM `completename`) as nome FROM `glpi_entities` WHERE `id` <> '0' AND `id` <> '22' ORDER BY `completename`";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select name='".$nome."' required>";
    $select .= "<option value='' selected>Selecione um departamento</option>";
    while($departamento = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$departamento['id']."'>".utf8_encode($departamento['nome'])."</option>";
    }
    $select .= "</select>";
    
    desconecta($conn);
    
    echo $select;
}