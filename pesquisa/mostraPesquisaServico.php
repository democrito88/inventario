<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/funcoesUteis.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(isset($_POST['etiqueta'])){
        $fimQuery = " c.etiqueta = ".$_POST['etiqueta'];
    }elseif(isset($_POST['usuario'])){
        $fimQuery = " h.usuario LIKE '%".$_POST['usuario']."%'";
    }elseif (isset ($_POST['departamento'])) {
        $fimQuery = " h.departamento = ".$_POST['departamento'];
    }elseif (isset ($_POST['dataEntradaInicial']) && isset ($_POST['dataEntradaFinal'])) {
        $fimQuery = " h.dataEntrada BETWEEN '".$_POST['dataEntradaInicial']."' AND '".$_POST['dataEntradaFinal']."'";
    }elseif (isset ($_POST['dataSaidaInicial']) && isset ($_POST['dataSaidaFinal'])) {
        $fimQuery = " h.dataSaida BETWEEN '".$_POST['dataSaidaInicial']."' AND '".$_POST['dataSaidaFinal']."'";
    }
}

$resposta = "    
<h3>Serviços</h3>
    <h4>Histórico de serviços encontrados</h4>
<table id=\"tabela\" class=\"table table-hover principalTabela\">
    <thead>
        <tr><th>Etiqueta</th><th>Departamento</th><th>Usuário</th><th>Manutenção</th><th>Entrada</th><th>Saída</th><th></th><th></th><th></th></tr>
    </thead>
    <tbody>";
        
        $query = "SELECT h.id, h.departamento, h.usuario, h.idComp, h.dataEntrada, h.dataSaida,"
                . " IF(h.idManut = '' OR h.idManut = 'NULL', 'Não', 'Sim') AS manutencao,"
                . " c.etiqueta"
                . " FROM historico h"
                . " INNER JOIN computador c ON c.id = h.idComp"
                . " WHERE ".$fimQuery." ORDER BY dataEntrada DESC LIMIT 50";
        $conn = conecta();
        $requisicao = mysqli_query($conn, $query);
        desconecta($conn);
        if($requisicao != FALSE){
            if(mysqli_num_rows($requisicao) == 0){
                $resposta .= "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
            }else{
                while($tupla = mysqli_fetch_assoc($requisicao)){
                    $resposta .= "<tr><th>".$tupla['etiqueta']."</th><th>".nomeDepartamento($tupla['departamento'])."</th><th>".$tupla['usuario']."</th>"
                            . "<th>".$tupla['manutencao']."</th>"
                            . "<th>".date("d/m/Y", strtotime($tupla['dataEntrada']))."</th><th>".date("d/m/Y", strtotime($tupla['dataSaida']))."</th>"
                            . "<th><a title='Detalhes' class='glyphicon glyphicon-info-sign detalhes' onclick='detalheHistorico(".$tupla['id'].", false);'></a></th>"
                            . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='../historico/editarHistorico.php?id=".$tupla['id']."'></a></th>"
                            . "<th><p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='../historico/removerHistorico.php?id=".$tupla['id']."'>Sim</a></span></p></th>"
                            . "</tr>";
                }
            }
        }else{
            $resposta .= "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
        }
        
    $resposta .= "</tbody>
    <tfoot><tr><td><button class=\"btn btn-primary\" onclick=\"window.location.replace('historico/novoHistorico.php')\"><i class=\"glyphicon glyphicon-plus-sign\"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
</table>";
echo $resposta;