<?php
include_once '../funcoes/validar.php';
include_once '../funcoes/conection.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $nome = (!is_null($_POST['nome']) && !antiInjection($_POST['nome']))? $_POST['nome']: false;
    $login = (!is_null($_POST['login']) && !antiInjection($_POST['login']))? $_POST['login']: false;
    $senha = (isset($_POST['senha']) && !antiInjection($_POST['senha']))? $_POST['senha']: false;
    
    if(!is_bool($nome) && !is_bool($login)){
        if(!$senha){
            $query = "UPDATE `usuario` SET `nome`='".utf8_decode($nome)."',`login`='".$login."' WHERE id=".$_POST['id'];
        }else{
            $query = "UPDATE `usuario` SET `nome`='".$nome."',`login`='".$login."',`senha`=SHA1('".$senha."') WHERE id=".$_POST['id'];
        }
        $conn = conecta();
        $sql = mysqli_query($conn, $query);
        desconecta($conn);
        $_SESSION['login'] = $nome;
        
        $_POST['adm'] === "1"? header("Location: listarUsuarios.php") : header("Location: ../principal.php?flag=11");
    }else{
        throw new Exception("<h4>Parâmetros inválidos</h4>");
    }
}
