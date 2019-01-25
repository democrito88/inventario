<?php
function conecta(){
    $conn = mysqli_connect("localhost", "root", "", "inventario");
    if($conn != false){
        return $conn;
    }else{
        throw new Exception("<br>N&atilde;o foi poss&iacute;vel estabelecer conex&atilde;o<br>");
    }
}

function conectaGLPI(){
    $conn = mysqli_connect("localhost", "root", "", "glpi");
    if($conn != false){
        return $conn;
    }else{
        throw new Exception("<br>N&atilde;o foi poss&iacute;vel estabelecer conex&atilde;o<br>");
    }
}

function desconecta($conn){
    return mysqli_close($conn);
}