<?php
include_once '../funcoes/Corpo.php';
include_once '../funcoes/validar.php';
include_once '../funcoes/conection.php';
include_once '../funcoes/funcoesUteis.php';
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
        $fimQuery = " h.departamento ";
        break;
    case '3':
        $fimQuery = " h.usuario ";
        break;
    case '4':
        $fimQuery = " h.dataEntrada ";
        break;
    case '5':
        $fimQuery = " h.dataSaida ";
        break;
    default :
        $fimQuery = " h.dataEntrada ";
        break;
}
$fimQuery .= $toggle === '1' ? "DESC " : "ASC ";


$conn = conecta();

//Conta as páginas necessárias para dstribuir o resultados
//Máximo de resultados por página: 50.
$resultadosPPaginas = 25;
$query = "SELECT COUNT(id) AS total FROM historico";
$requisicao = mysqli_query($conn, $query);
while($resultado = mysqli_fetch_assoc($requisicao)){
    $total = $resultado['total'];
}
$paginas = floor($total / $resultadosPPaginas) == 0? 1 : floor($total / $resultadosPPaginas);
//uma página extra para o resto da divisão
$paginas += ($total % $resultadosPPaginas) > 0 && floor($total / $resultadosPPaginas) > 0? 1 : 0 ;
$pagAtual = $pagAtual > $paginas ? $paginas : $pagAtual ;

$query1 = "SELECT h.id, h.departamento, h.usuario, h.idComp, h.dataEntrada, h.dataSaida,"
        . " c.etiqueta"
        . " FROM historico h"
        . " INNER JOIN computador c ON  c.id = h.idComp "
        . " ORDER BY ".$fimQuery." LIMIT ".($resultadosPPaginas*($pagAtual - 1)).", ".$resultadosPPaginas.";";

?>
<section style="margin: 5% 8%; text-align: center;">
    <button class="btn btn-primary botaoVoltar" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button>
    <h3>Serviços</h3><h4>Histórico de serviços em computadores</h4>
    <table class="table table-hover principalTabela">
        <thead>
            <tr>
                <th onclick="window.location.replace('listarServico.php?pag=<?php echo $pagAtual;?>&search=<?php echo 1;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Etiqueta</th>
                <th onclick="window.location.replace('listarServico.php?pag=<?php echo $pagAtual;?>&search=<?php echo 2;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Departamento</th>
                <th onclick="window.location.replace('listarServico.php?pag=<?php echo $pagAtual;?>&search=<?php echo 3;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Usuário</th>
                <th onclick="window.location.replace('listarServico.php?pag=<?php echo $pagAtual;?>&search=<?php echo 4;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Entrada</th>
                <th onclick="window.location.replace('listarServico.php?pag=<?php echo $pagAtual;?>&search=<?php echo 5;?>&toggle=<?php echo $toggle == 0? 1: 0; ?>');">Saída</th>
                <th></th><th></th><th></th></tr>
        </thead>
        <tbody>
            <?php
            $requisicao = mysqli_query($conn, $query1);
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    echo "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        echo "<tr><th>".$tupla['etiqueta']."</th><th>".nomeDepartamento($tupla['departamento'])."</th><th>".$tupla['usuario']."</th>"
                                . "<th>".date("d/m/Y", strtotime($tupla['dataEntrada']))."</th><th>".date("d/m/Y", strtotime($tupla['dataSaida']))."</th>"
                                . "<th><a title='Detalhes' class='glyphicon glyphicon-info-sign detalhes' onclick='detalheHistorico(".$tupla['id'].", false);'></a></th>"
                                . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='editarHistorico.php?id=".$tupla['id']."'></a></th>"
                                . "<th>".($_SESSION['id'] == '1'? "<p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='computador/removerComputador.php?id=".$tupla['id']."'>Sim</a></span></p>" : "")."</th></tr>";
                    }
                }
            }else{
                echo "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
            }
            desconecta($conn);
            ?>
        </tbody>
        <tfoot><tr><td><button class="btn btn-primary" onclick="window.location.replace('novoHistorico.php')"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
    </table>
        
<?php
if($paginas > 1){
    echo "<div class=\"pagination\">
                <a href='listarServico.php?pag=".($pagAtual-1)."&search=".$search."&toggle=".$toggle."'>&laquo;</a>";
    
    if($paginas <= 5){
        for($i = 1; $i <= $paginas; $i++){
            if($i == $pagAtual){
                echo "<a  class =\"active\" href=\"listarServico.php?pag=".$i."&search=".$search."&toggle=".$toggle."\">".$i."</a>";
            }else{
                echo "<a href=\"listarServico.php?pag=".$i."&search=".$search."&toggle=".$toggle."\">".$i."</a>";
            }
            
        }
    }else{
        for($i = ($pagAtual - 2); $i <= ($pagAtual + 2); $i++){
            if($i == $pagAtual){
                echo "<a  class =\"active\" href=\"#\">".$i."</a>";
            }else{
                echo "<a href=\"listarServico.php?pag=".$i."&search=".$search."&toggle=".$toggle."\">".$i."</a>";
            }
        }
    }
    
    echo "<a href='listarServico.php?pag=".($pagAtual+1)."&search=".$search."&toggle=".$toggle."'>&raquo;</a>"
        . "</div>";
}
?>
</section>
<?php
rodape();
