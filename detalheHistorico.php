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
$query = "SELECT * 
FROM ( 
     SELECT h.id, h.usuario, h.departamento, h.dataEntrada, h.dataSaida, h.descricao,
     c.tombo, c.etiqueta, c.alugado,
     mar.nome AS marca,
     CONCAT_WS(\" \", mem.barramento, mem.capacidade) AS memoria,
     CONCAT_WS(\" \", a.tecnologia, a.capacidade) AS armazenamento,
     CONCAT_WS(\" \", so.nome, so.versao) AS SO,
     CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador,
     u.nome AS tecnico
     FROM historico h
     INNER JOIN computador c ON c.id = h.idComp
     INNER JOIN marca mar ON c.idMarca = mar.id
     INNER JOIN memoria mem ON c.idMem = mem.id
     INNER JOIN armazenamento a ON c.idArm = a.id
     INNER JOIN sistema_operacional so ON c.idSO = so.id
     INNER JOIN processador p ON c.idProc = p.id,
     usuario u 
     WHERE h.id = ".$id." AND h.idUsuario = u.id
     ) AS A
LEFT JOIN (
    SELECT h.id, h.idManut,
    IF(h.idManut IS NULL, \"Fora da Manutenção\", \"Manutenção\") AS tipo,
    IF(h.idMAnut IS NULL, \" \", manut.procedimento) AS procedimento,
    GROUP_CONCAT(DISTINCT IF(h.idMAnut IS NULL, \" \", prob.problema) SEPARATOR ', ') AS problema
    FROM historico h
    LEFT JOIN manutencao manut ON h.idManut = manut.id
    LEFT JOIN manutencao_problema mp ON mp.idManut = manut.id
    LEFT JOIN problema prob ON prob.id = mp.idProb
    WHERE h.id = ".$id."
) AS B
ON A.id=B.id;";
$sql = mysqli_query($conn, $query);
desconecta($conn);
$painel = "<p class=\"fechar\" onclick=\"fechaModal('modalPrincipal');\">&times;</p>
    <div class=\"panel panel-primary modalPrincipal\">
        <div class=\"panel-heading\">Detalhes de serviço</div>
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
            .'</div><div class="col-sm-6"><canvas width="1"></canvas><h4>Serviço feito</h4><br/>'
            .'<p><strong>Entrada: </strong>'.date("d/m/Y", strtotime($resultado['dataEntrada'])).'</p>'
            .'<p><strong>Saída: </strong>'.date("d/m/Y", strtotime($resultado['dataSaida'])).'</p>'
            .'<p><strong>Tipo de serviço: </strong>'.$resultado['tipo'].'</p>';
            if($resultado['tipo'] == "Manutenção"){
                $painel .= '<p><strong>Problema: </strong>'.$resultado['problema'].'</p>';
            }
            $painel .= '<p><strong>Descrição: </strong>'.$resultado['descricao'].' '.$resultado['procedimento'].'</p>'
            .'<p><strong>Realizado por: </strong>'.utf8_encode($resultado['tecnico']).'</p>'
            .'</div>';
        }
        
$painel .=
      "</div>
    </div>";

echo $painel;