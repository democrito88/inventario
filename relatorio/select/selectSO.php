<?php
include_once '../../funcoes/conection.php';

$query = "SELECT * FROM sistema_operacional";
$conn = conecta();
$sql = mysqli_query($conn, $query);
desconecta($conn);
$select = "<select name=\"SO\">";
    while($tupla = mysqli_fetch_assoc($sql)){
        if($tupla['id'] !== '1'){
            $select .= "<option value='".$tupla['id']."'>".$tupla['nome']." ".$tupla['versao'].($tupla['licenca'] === '1'? "*" : "")."</option>";
        }else{
            $select .= "<option value='".$tupla['id']."'>".utf8_encode($tupla['nome']." ".$tupla['versao'].($tupla['licenca'] === '1'? "*" : ""))."</option>";
        }
        
    }
$select .= "</select>";

echo $select;

