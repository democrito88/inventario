<?php
include_once '../funcoes/conection.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['tombo'])){
        if($_POST['tombo'] === '*'){
            $fimQuery = " c.tombo NOT LIKE '0'";
        }else{
            $fimQuery = " c.tombo = '".$_POST['tombo']."'";
        }
    }elseif (isset($_POST['etiqueta'])) {
        $fimQuery = " c.etiqueta = '".$_POST['etiqueta']."'";
        
    }elseif (isset($_POST['alugado'])) {
        $fimQuery = " c.alugado = '".$_POST['alugado']."'";
        
    }elseif (isset ($_POST['tecnologia'])) {
        $fimQuery = $_POST['tecnologia'] != ""? " ar.tecnologia = '".$_POST['tecnologia']."'" : " 1 ";
        $fimQuery .= isset($_POST['armcapacidade']) && $_POST['armcapacidade'] != "" ? " AND ar.capacidade = '".$_POST['armcapacidade']."'" : "";
        
    }elseif (isset ($_POST['armcapacidade'])) {
        $fimQuery = " ar.capacidade = '".$_POST['armcapacidade']."'";
        
    }elseif (isset ($_POST['idmarca'])) {
        $fimQuery = " ma.id = '".$_POST['idmarca']."'";
        
    }elseif (isset ($_POST['barramento'])) {
        $fimQuery = $_POST['barramento'] != ""?  " me.barramento = '".$_POST['barramento']."'" : " 1 ";
        $fimQuery .= isset($_POST['memcapacidade']) && $_POST['memcapacidade'] != "" ? " AND me.capacidade = '".$_POST['memcapacidade']."'" : "";
        
    }elseif (isset ($_POST['memcapacidade'])) {
        $fimQuery = " me.capacidade = '".$_POST['memcapacidade']."'";
        
    }elseif (isset ($_POST['sonome'])) {
        $fimQuery = $_POST['sonome']!= ""? " so.nome = '".$_POST['sonome']."'" : " 1 ";
        $fimQuery .= isset($_POST['licenca']) && $_POST['licenca'] != ""? " AND so.licenca = '".$_POST['licenca']."'" : "";
    }elseif (isset ($_POST['licenca'])) {
        $fimQuery = " so.licenca = '".$_POST['licenca']."'";
        
    }elseif (isset ($_POST['procnome'])) {
        $fimQuery = $_POST['procnome'] != ""? " p.nome = '".$_POST['procnome']."'" : " 1 ";
        $fimQuery .= isset($_POST['arquitetura']) && $_POST['arquitetura'] != "" ? " AND p.arquitetura = '".$_POST['arquitetura']."'" : "";
    }elseif (isset ($_POST['arquitetura'])) {
        $fimQuery = " p.arquitetura = '".$_POST['arquitetura']."'";
    }
}else{
    $fimQuery = " 1 ";
}

$query = "SELECT c.`id`, c.`etiqueta`,
IF(c.`tombo` = 0, \"Não possui\", c.`tombo`) AS tombo,
IF(c.`alugado` = '0', \"Não\", \"Sim\") AS alugado,
ma.nome AS marca,
CONCAT_WS(\" \", me.barramento, me.capacidade) AS memoria,
CONCAT_WS(\" \", ar.tecnologia, ar.capacidade) AS armazenamento,
CONCAT_WS(\" \", so.nome, so.versao, IF(licenca = '1', '*', '')) AS SO,
CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador
FROM computador c
INNER JOIN marca ma ON c.idMarca = ma.id
INNER JOIN memoria me ON c.idMem = me.id
INNER JOIN armazenamento ar ON c.idArm = ar.id
INNER JOIN sistema_operacional so ON c.idSO = so.id
INNER JOIN processador p ON c.idProc = p.id
WHERE ".$fimQuery."
 ORDER BY c.id DESC LIMIT 10";

$conn = conecta();
$requisicao = mysqli_query($conn, $query);
desconecta($conn);

$resposta = "     
<div>
    <h4>Computadores encontrados</h4>
    <table class=\"table table-hover principalTabela\">
        <thead>
            <tr><th>Etiqueta</th><th>Marca</th><th>Tombo</th><th>Alugado</th><th>Memória</th><th>Armaz.</th><th>S.O.</th><th>Processador</th><th></th><th></th></tr>
        </thead>
        <tbody>";
            
            
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    $resposta .= "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        $resposta .= "<tr><th>".(is_null($tupla['etiqueta']) ? "Não possui" : $tupla['etiqueta'])."</th><th>".utf8_encode($tupla['marca'])."</th><th>".(($tupla['tombo'] == 0)? "não possui" : $tupla['tombo'])."</th><th>".$tupla['alugado']."</th>"
                                . "<th>".$tupla['memoria']."GB</th><th>".$tupla['armazenamento']."GB</th><th>".$tupla['SO']."</th><th>".$tupla['processador']."bits</th>"
                                . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='../computador/editarComputador.php?id=".$tupla['id']."'></a></th>"
                                . "<th><p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='../historico/removerHistorico.php?id=".$tupla['id']."'>Sim</a></span></p></th>"
                                . "</tr>";
                    }
                }
            }else{
                $resposta .= "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
            }
            
            
$resposta .=        "</tbody>
        <tfoot><tr><td></td></tr></tfoot>
    </table>
</div>";
echo $resposta;
