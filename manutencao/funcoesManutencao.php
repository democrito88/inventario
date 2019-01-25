<?php
function selecionaProblemas(){
    $conn = conecta();
    $query= "SELECT * FROM problema";
    $requisicao = mysqli_query($conn, $query);
    $select = "<select id='selectProblemas' name='problema' onchange='adicionaProblema();'>";
    $select .= "<option value='0' selected>Selecione um problema</option>";
    while($problema = mysqli_fetch_assoc($requisicao)){
        $select .= "<option value='".$problema['id']."' ";
        $select .= ">".$problema['problema']."</option>";
    }
    $select .= "</select>";
    
    desconecta($conn);
    
    return $select;
}

function insereLinhasProblemas($id){
    $conn = conecta();
    $query = "SELECT p.id, p.problema FROM problema p, manutencao_problema mp WHERE mp.idProb = p.id AND mp.idManut = ".$id;
    $requisicao = mysqli_query($conn, $query);
    $linhas = "";
    while($problema = mysqli_fetch_assoc($requisicao)){
        $linhas .= "<tr id='".$problema['id']."'><td>".$problema['problema']."&nbsp;&nbsp;</td>"
                . "<td style=\"display: none;\"><input value=\"".$problema['id']."\" name=\"prob[]\" type=\"text\"></td>"
                . "<td><a><i class='glyphicon glyphicon-remove remover' onclick='excluiProblema(".$problema['id'].");'></i></a></td></tr>";
    }
    
    desconecta($conn);
    return $linhas;
}