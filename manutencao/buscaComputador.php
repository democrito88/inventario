<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/validar.php';
include_once '../funcoes/funcoesUteis.php';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['etiqueta'])){
    if(antiInjection($_GET['etiqueta'])){
        throw new Exception("<h4>Tentativa de injeção de código malicioso detectada</h4>");
    }
    $span = "";
    $conn = conecta();
    $query0 = "SELECT h.idComp FROM historico h "
            . "INNER JOIN computador c ON c.id = h.idComp "
            . "WHERE c.etiqueta = ".$_GET['etiqueta'];
    $sql = mysqli_query($conn, $query0);
    if($sql != FALSE){
        if(mysqli_num_rows($sql) === 0){
            $query1 = "SELECT c.`tombo`, c.`alugado`, ma.nome AS marca,
                CONCAT_WS(\" \", me.barramento, me.capacidade) AS memoria,
                CONCAT_WS(\" \", ar.tecnologia, ar.capacidade) AS armazenameto,
                CONCAT_WS(\" \", so.nome, so.versao) AS SO,
                CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador
                FROM computador c
                INNER JOIN marca ma ON c.idMarca = ma.id
                INNER JOIN memoria me ON c.idMem = me.id
                INNER JOIN armazenamento ar ON c.idArm = ar.id
                INNER JOIN sistema_operacional so ON c.idSO = so.id
                INNER JOIN processador p ON c.idProc = p.id
                WHERE  c.etiqueta = ".$_GET['etiqueta']."
                LIMIT 1;";
        }else{
            $query1 = "SELECT c.`tombo`, c.`alugado`, ma.nome AS marca,
                CONCAT_WS(\" \", me.barramento, me.capacidade) AS memoria,
                CONCAT_WS(\" \", ar.tecnologia, ar.capacidade) AS armazenameto,
                CONCAT_WS(\" \", so.nome, so.versao) AS SO,
                CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador,
                h.usuario, h.departamento
                FROM computador c
                INNER JOIN marca ma ON c.idMarca = ma.id
                INNER JOIN memoria me ON c.idMem = me.id
                INNER JOIN armazenamento ar ON c.idArm = ar.id
                INNER JOIN sistema_operacional so ON c.idSO = so.id
                INNER JOIN processador p ON c.idProc = p.id
                INNER JOIN historico h ON c.id = h.idComp
                WHERE  c.etiqueta = ".$_GET['etiqueta']."
                ORDER BY h.dataEntrada DESC LIMIT 1;";
        }
    }
    
    if(isset($query1)){
        $sql = mysqli_query($conn, $query1);
        while ($servico = mysqli_fetch_assoc($sql)){
            $span .= "<strong>Marca: </strong>".$servico['marca']."<br/>"
                    ."<strong>Tombo: </strong>".($servico['tombo'] == "" || $servico['tombo'] == '0'? "Não Possui": $servico['tombo'])."<br/>"
                    ."<strong>Alugado: </strong>".($servico['alugado'] == 1 ? "Sim": "Não")."<br/>"
                    ."<strong>Memória: </strong>".$servico['memoria']."GB<br/>"
                    ."<strong>Armazenamento: </strong>".$servico['armazenameto']."GB<br/>"
                    ."<strong>S.O.: </strong>".$servico['SO']."<br/>"
                    ."<strong>Processador: </strong>".$servico['processador']."bits<br/>";
            if(isset($servico['usuario'])){
                $span .= "<strong>Usuário: </strong>".$servico['usuario']."<br/>"
                    ."<strong>Departamento: </strong>".nomeDepartamento($servico['departamento'])."<br/>";
            }
        }
    }
    
    desconecta($conn);
    
    echo $span;
}else{
    throw new Exception("<h4>Parâmetros inválidos</h4>");
}