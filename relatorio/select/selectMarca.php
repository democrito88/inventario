<?php
include_once '../../funcoes/conection.php';

$query = "SELECT * FROM marca";
$conn = conecta();
$sql = mysqli_query($conn, $query);
desconecta($conn);
$select = "<select name=\"marca\">";
    while($tupla = mysqli_fetch_assoc($sql)){
        $select .= "<option value='".$tupla['id']."'>".utf8_encode($tupla['nome'])."</option>";
    }
$select .= "</select>";

echo $select;

