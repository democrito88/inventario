<?php
include_once '../funcoes/Corpo.php';
include_once '../funcoes/validar.php';
include_once '../funcoes/conection.php';
cabecalho();

if($_SERVER['REQUEST_METHOD'] === "GET"){
    $pagAtual = isset($_GET['pag']) && !antiInjection($_GET['pag'])? $_GET['pag'] : 1;
    $search = isset($_GET['search']) && !antiInjection($_GET['search']) ? $_GET['search'] : 0;
    $toggle = isset($_GET['toggle']) && !antiInjection($_GET['toggle']) ? $_GET['toggle'] : 0;
}
//captura o critério de ordenação
switch($search){
    case '1':
        $fimQuery = " c.`etiqueta` ";
        break;
    case '2':
        $fimQuery = " ma.`nome` ";
        break;
    case '3':
        $fimQuery = " c.`tombo` ";
        break;
    case '4':
        $fimQuery = " c.`alugado` ";
        break;
    case '5':
        $fimQuery = " memoria ";
        break;
    case '6':
        $fimQuery = " armazenamento ";
        break;
    case '7':
        $fimQuery = " SO ";
        break;
    case '8':
        $fimQuery = " processador ";
        break;
    default :
        $fimQuery = " c.`id` ";
        break;
}
$fimQuery .= $toggle === '1' ? "DESC " : "ASC ";

$conn = conecta();

//Conta as páginas necessárias para dstribuir o resultados
//Máximo de resultados por página: 50.
$resultadosPPaginas = 25;
$query = "SELECT COUNT(id) AS total FROM computador";
$requisicao = mysqli_query($conn, $query);
while($resultado = mysqli_fetch_assoc($requisicao)){
    $total = $resultado['total'];
}
$paginas = floor($total / $resultadosPPaginas) == 0? 1 : floor($total / $resultadosPPaginas);
//uma página extra para o resto da divisão
$paginas += ($total % $resultadosPPaginas) > 0 && floor($total / $resultadosPPaginas) > 0? 1 : 0 ;
$pagAtual = $pagAtual > $paginas ? $paginas : $pagAtual ;

$query1 = "SELECT c.`id`, c.`etiqueta`, c.`tombo`, c.`alugado`, ma.nome AS marca,
CONCAT_WS(\" \", me.barramento, me.capacidade) AS memoria,
CONCAT_WS(\" \", ar.tecnologia, ar.capacidade) AS armazenamento,
CONCAT_WS(\" \", so.nome, so.versao, IF(so.licenca = '1', '*', '')) AS SO,
CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador
FROM computador c, marca ma , memoria me , armazenamento ar, sistema_operacional so, processador p
WHERE c.idMarca = ma.id AND c.idMem = me.id AND c.idArm = ar.id AND c.idSO = so.id AND c.idProc = p.id
ORDER BY ".$fimQuery." LIMIT ".($resultadosPPaginas*($pagAtual - 1)).", ".$resultadosPPaginas.";";
//echo "Total: ".$total."<br>Por páginas:".$resultadosPPaginas."<br>Páginas: ".$paginas."<br>Pág. atual: ".$pagAtual;
?>
<section style="margin: 5% 8%; text-align: center;">
    <button class="btn btn-primary botaoVoltar" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button>
    <h3>Inventário de máquinas</h3><h4>Consulte computadores cadastrados no sistema</h4>
    <table class="table table-hover principalTabela">
        <thead>
            <tr>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 1;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Etiqueta</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 2;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Marca</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 3;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Tombo</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 4;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Alugado</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 5;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Memória</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 6;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Armaz.</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 7;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">S.O.</th>
                <th onclick="window.location.replace('listarComputadores.php?pag=<?php echo $pagAtual;?>&search=<?php echo 8;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Processador</th>
                <th></th><th></th></tr>
        </thead>
        <tbody>
            <?php

            $requisicao = mysqli_query($conn, $query1);
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    echo "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        echo "<tr><th>".(is_null($tupla['etiqueta']) || $tupla['etiqueta'] === '0'? "Não possui" : $tupla['etiqueta'])."</th><th>".utf8_encode($tupla['marca'])."</th><th>".(($tupla['tombo'] == 0)? "não possui" : $tupla['tombo'])."</th><th>".(($tupla['alugado'] == 0)? "não" : "sim")."</th>"
                                . "<th>".$tupla['memoria']."GB</th><th>".$tupla['armazenamento']."GB</th><th>".$tupla['SO']."</th><th>".$tupla['processador']."bits</th>"
                                . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='computador/editarComputador.php?id=".$tupla['id']."'></a></th>"
                                . "<th>".($_SESSION['id'] == '1'? "<p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='computador/removerComputador.php?id=".$tupla['id']."'>Sim</a></span></p>" : "")."</th></tr>";
                    }
                }
            }else{
                echo "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
            }
            ?>
        </tbody>
        <tfoot><tr><td><button class="btn btn-primary" onclick="window.location.replace('novoComputador.php')"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
    </table>
        
<?php
if($paginas > 1){
    echo "<div class=\"pagination\">
                <a href='listarComputadores.php?pag=".($pagAtual-1)."&search=".$search."&toggle=".$toggle."'>&laquo;</a>";
    
    if($paginas <= 5){
        for($i = 1; $i <= $paginas; $i++){
            if($i == $pagAtual){
                echo "<a  class =\"active\" href=\"listarComputadores.php?pag=".$i."&search=".$search."&toggle=".$toggle."\">".$i."</a>";
            }else{
                echo "<a href=\"listarComputadores.php?pag=".$i."&search=".$search."&toggle=".$toggle."\">".$i."</a>";
            }
            
        }
    }else{
        for($i = ($pagAtual - 2); $i <= ($pagAtual + 2); $i++){
            if($i == $pagAtual){
                echo "<a  class =\"active\" href=\"#\">".$i."</a>";
            }else{
                echo "<a href=\"listarComputadores.php?pag=".$i."&search=".$search."&toggle=".$toggle."\">".$i."</a>";
            }
        }
    }
    
    echo "<a href='listarComputadores.php?pag=".($pagAtual+1)."&search=".$search."&toggle=".$toggle."'>&raquo;</a>"
        . "</div>";
}
?>
</section>
<?php
rodape();
