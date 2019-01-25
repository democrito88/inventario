<?php
include "./funcoes/conection.php";
include './funcoes/validar.php';
include './funcoes/funcoesUteis.php';
$conn = conecta();

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    antiInjection($_GET['id']) === true ? header("Location: index.php") : $id = $_GET['id'];
}else{
    throw new Exception("<h4>Parâmetros Inválidos</h4>");
}
$query = "SELECT h.usuario, h.departamento, h.dataEntrada, h.dataSaida,
        c.tombo, c.etiqueta, c.alugado,
        mar.nome AS marca,
        CONCAT_WS(\" \", mem.barramento, mem.capacidade) AS memoria,
        CONCAT_WS(\" \",a.tecnologia, a.capacidade) AS armazenamento,
        CONCAT_WS(\" \", so.nome, so.versao) AS SO,
        CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador,
        m.procedimento, m.observacao,
        GROUP_CONCAT(DISTINCT prob.problema SEPARATOR ', ') AS problema,
        u.nome AS tecnico
        FROM historico h INNER JOIN computador c ON h.idComp = c.id
        INNER JOIN manutencao m ON h.idManut = m.id
        INNER JOIN manutencao_problema mp ON m.id = mp.idManut
        INNER JOIN problema prob ON mp.idProb = prob.id
        INNER JOIN marca mar ON c.idMarca = mar.id
        INNER JOIN memoria mem ON c.idMem = mem.id
        INNER JOIN armazenamento a ON c.idArm = a.id
        INNER JOIN sistema_operacional so ON c.idSO = so.id
        INNER JOIN processador p ON c.idProc = p.id,
        usuario u WHERE h.id = ".$id." AND h.idUsuario = u.id;";
$sql = mysqli_query($conn, $query);
desconecta($conn);
$painel = "<p class=\"fechar\" onclick=\"fechaModal('modalPrincipal');\">&times;</p>
    <div class=\"panel panel-primary modalPrincipal\">
        <div class=\"panel-heading\">Detalhes de manutenção</div>
        <div class=\"panel-body\" style=\"padding: 5%;\">";
       
        while ($resultado = mysqli_fetch_assoc($sql)){
            $painel .= '<div class="col-sm-6"><h4>Dados do Computador</h4><br/>'
            .'<p><strong>Tombo: </strong>'.(($resultado['tombo'] === '0' || $resultado['tombo'] === null) ? 'não possui': $resultado['tombo']).'</p>'
            .'<p><strong>Etiqueta: </strong>'.$resultado['etiqueta'].'</p>'
            .'<p><strong>Alugado: </strong>'.($resultado['alugado'] === '0'? 'Não' : 'Sim').'</p>'
            .'<p><strong>Marca: </strong>'.$resultado['marca'].'</p>'
            .'<p><strong>Memória: </strong>'.$resultado['memoria'].'GB</p>'
            .'<p><strong>Armazenamento: </strong>'.$resultado['armazenamento'].'GB</p>'
            .'<p><strong>Sistema Operacional: </strong>'.$resultado['SO'].'</p>'
            .'<p><strong>Processador: </strong>'.$resultado['processador'].'bits</p><br/>'
            .'<h4>Usuário</h4><br/>'
            .'<p><strong>Nome: </strong>'.$resultado['usuario'].'</p>'
            .'<p><strong>Departamento: </strong>'.nomeDepartamento($resultado['departamento']).'</p>'
            .''
            .'</div><div class="col-sm-6"><canvas width="1"></canvas><h4>Serviço de Manutenção</h4><br/>'
            .'<p><strong>Entrada: </strong>'.date("d/m/Y", strtotime($resultado['dataEntrada'])).'</p>'
            .'<p><strong>Saída: </strong>'.date("d/m/Y", strtotime($resultado['dataSaida'])).'</p>'
            .'<p><strong>Problema: </strong>'.$resultado['problema'].'</p>'
            .'<p><strong>Procedimento: </strong>'.$resultado['procedimento'].'</p>'
            .'<p><strong>Observação: </strong>'.$resultado['observacao'].'</p>'
            .'<p><strong>Realizado por: </strong>'.utf8_encode($resultado['tecnico']).'</p>'
            .'</div>';
        }
        
$painel .=
      "</div>
    </div>";

echo $painel;