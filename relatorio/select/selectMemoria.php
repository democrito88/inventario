<?php
include_once '../../funcoes/conection.php';

$query = "SELECT * FROM memoria";
$conn = conecta();
$sql = mysqli_query($conn, $query);
desconecta($conn);
$select = "<select name=\"memoria\">";
    while($tupla = mysqli_fetch_assoc($sql)){
        if($tupla['id'] !== '1'){
            $select .= "<option value='".$tupla['id']."'>".$tupla['barramento']." - ".$tupla['capacidade']."GB</option>";
        }else{
            $select .= "<option value='".$tupla['id']."'>".utf8_encode($tupla['barramento']." ".$tupla['capacidade'])."</option>";
        }
    }
$select .= "</select>";

echo $select;

