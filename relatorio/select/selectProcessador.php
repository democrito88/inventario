<?php
include_once '../../funcoes/conection.php';

$query = "SELECT * FROM processador";
$conn = conecta();
$sql = mysqli_query($conn, $query);
desconecta($conn);
$select = "<select name=\"processador\">";
    while($tupla = mysqli_fetch_assoc($sql)){
        if($tupla['id'] !== '1'){
            $select .= "<option value='".$tupla['id']."'>".$tupla['fabricante']." ".$tupla['modelo']." - ".$tupla['arquitetura']." bits</option>";
        }else{
            $select .= "<option value='".$tupla['id']."'>".utf8_encode($tupla['fabricante']." ".$tupla['modelo']." ".$tupla['arquitetura'])."</option>";
        }
        
    }
$select .= "</select>";

echo $select;

