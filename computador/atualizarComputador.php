<?php
include '../funcoes/conection.php';
include '../funcoes/validar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = antiInjection($_POST['id']) != false? "": $_POST['id'];
    $tombo = antiInjection($_POST['tombo']) != false? "":  $_POST['tombo'];
    $alugado = antiInjection($_POST['alugado']) != false? "":  $_POST['alugado'];
    $marca = antiInjection($_POST['marca']) != false? "":  $_POST['marca'];
    $memoria = antiInjection($_POST['memoria']) != false? "":  $_POST['memoria'];
    $processador = antiInjection($_POST['processador']) != false? "":  $_POST['processador'];
    $armazenamento = antiInjection($_POST['armazenamento']) != false? "":  $_POST['armazenamento'];
    $so = antiInjection($_POST['so']) != false? "":  $_POST['so'];

    $conn = conecta();
    $query="UPDATE `computador` SET `tombo`=".$tombo.",`alugado`=".$alugado.",`idMarca`=".$marca.",`idMem`=".$memoria.",`idArm`=".$armazenamento.",`idSO`=".$so.",`idProc`=".$processador." WHERE id = ".$id;
    mysqli_query($conn, $query);
    //echo "Post". var_dump($_POST);
    //echo "Parâmetros: `tombo`, `alugado`, `idMarca`, `idMem`, `idArm`, `idSO`, `idProc`<br/>";
    //echo "valores: ".$tombo.",".$alugado.",".$marca.",".$memoria.",".$armazenamento.",".$so.",".$processador;
    desconecta($conn);
    header("Location: ../principal.php?flag=2");
}