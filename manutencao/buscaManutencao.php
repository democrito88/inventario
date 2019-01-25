<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/validar.php';
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])){
    if(antiInjection($_GET['id'])){
        throw new Exception("<h4>Tentativa de injeção de código malicioso detectada</h4>");
    }
    $span = "<p class=\"fechar\" onclick=\"fechaModal('modalManutencao');\">&times;</p>
            <div class=\"panel panel-primary modalCadastro\">
                <div class=\"panel-heading\">Serviço de manutenção</div>
                <div class=\"panel-body\"><br/>";
    $conn = conecta();
    $query = "SELECT * FROM `entrada` WHERE `id` = ".$_GET['id'];
    $sql = mysqli_query($conn, $query);
    while ($servico = mysqli_fetch_assoc($sql)){
        $span .= "<strong>Data de Entrada: </strong>".date("d/m/Y", strtotime($servico['dataEntrada']))."<br/>"
                ."<strong>Data de Saída: </strong>".date("d/m/Y", strtotime($servico['dataSaida']))."<br/>"
                ."<strong>Usuário: </strong>".$servico['usuario']."<br/>"
                ."<strong>Departamento: </strong>".$servico['departamento']."<br/>"
                ."<strong>Procedimento: </strong>".$servico['procedimento']."<br/>"
                ."<strong>Observação: </strong>".$servico['observacao']."<br/>";
    }
    desconecta($conn);
    
    $span .= "</div>
            </div>";
    echo $span;
}else{
    throw new Exception("<h4>Parâmetros inválidos</h4>");
}