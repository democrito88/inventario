<?php
include_once './conection.php';

if($_SERVER['REQUEST_METHOD'] === "GET" && $_GET['etiqueta']){
    $query = "SELECT h.usuario, h.departamento FROM historico h INNER JOIN computador c ON c.id = h.idComp WHERE c.etiqueta = ".$_GET['etiqueta']." ORDER BY h.dataEntrada LIMIT 1";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    $vetor = array('','');
    while($tupla = mysqli_fetch_assoc($sql)){
        $vetor = array($tupla['usuario'],$tupla['departamento']);
    }
    desconecta($conn);
    
    echo json_encode($vetor);
}
