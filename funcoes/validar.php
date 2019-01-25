<?php
session_start();
function antiInjection($string){
    $lista = array("<script>",";","SELECT", "DROP", "DELETE", "ALTER", "SHOW", "UPDATE", "INSERT");
    $flag = false;
    for($i = 0; $i < 9; $i++){
        if(strpos($string, $lista[$i]) != FALSE){
            $flag = true;
        }
    }
    return $flag;
}

function sessao(){
    if(!isset($_SESSION['login'])){
        header("Location: index.php");
    }
}