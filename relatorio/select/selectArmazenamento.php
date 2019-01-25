<?php
include_once '../../funcoes/conection.php';

$query = "SELECT * FROM armazenamento";
$conn = conecta();
$sql = mysqli_query($conn, $query);
desconecta($conn);
$select = "<select name=\"armazenamento\">";
    while($tupla = mysqli_fetch_assoc($sql)){
        if($tupla['id'] !== '1'){
            $select .= "<option value='".$tupla['id']."'>".$tupla['tecnologia']." - ".$tupla['capacidade']."GB</option>";
        }else{
            $select .= "<option value='".$tupla['id']."'>".utf8_encode($tupla['tecnologia']." ".$tupla['capacidade'])."</option>";
        }
        
    }
$select .= "</select>";

echo $select;

