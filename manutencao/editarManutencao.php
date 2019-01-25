<?php
include '../funcoes/Corpo.php';
include './funcoesManutencao.php';
include '../funcoes/funcoesUteis.php';
cabecalho();
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(antiInjection($_GET['id'])){throw new Exception("<h4>Tentativa de injeção de código malicioso detectada</h4>");}
    else{ $id = $_GET['id'];}
}else{
    header("Location: ../logout.php");
}

$query = "SELECT h.id, h.idUsuario,"
        . " h.usuario, h.departamento, h.dataEntrada, h.dataSaida,"
        . " m.id AS idManut, m.procedimento, m.observacao"
        . " FROM historico h JOIN manutencao m, usuario u"
        . " WHERE h.idManut = m.id AND h.idUsuario= u.id AND h.id = ".$_GET['id'];
$conn = conecta();
$sql = mysqli_query($conn, $query);
desconecta($conn);
?>
<section class="sessaoManutencao">
    <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
    <?php while($servico = mysqli_fetch_assoc($sql)){?>
    <h3>Editar serviço de manutenção n&ordm;&nbsp;#<?php echo $servico['idManut'];?></h3>
    <form action="atualizarManutencao.php" method="POST">
        <div class="col-sm-6">
            <label>Problemas</label>
            <?php echo selecionaProblemas();?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modalManutencao(1);"></i> <br/>
            <table id="problemas">
                <thead><tr><th>Problema(s)</th><th></th><th></th></tr></thead>
                <tbody id="problemasBody">
                    <?php echo insereLinhasProblemas($servico['idManut'])?>
                </tbody>
            </table><br/><br/>
            <label>Procedimento</label><br/>
            <textarea name="procedimento" cols="80" rows="5"><?php echo $servico['procedimento']?></textarea><br/><br/>
            <label>Observação</label><br/>
            <textarea name="observacao" cols="80" rows="5"><?php echo $servico['observacao']?></textarea><br/><br/>
            <label>Técnico</label>&nbsp;&nbsp;
            <?php echo selecionaUsuario($servico['idUsuario']);?><br/><br/>
        </div>
        <div class="col-sm-6" style="height: inherit;">
            <label>Entrada</label>&nbsp;&nbsp;
            <input type="date" name="dataEntrada" value="<?php echo $servico['dataEntrada'];?>"><br/><br/>
            <label>Saída</label>&nbsp;&nbsp;
            <input type="date" name="dataSaida" value="<?php echo $servico['dataSaida'];?>"><br/><br/>
            <label>Usuário do Computador</label><br/>
            <input type="text" name="usuario" value="<?php echo $servico['usuario'];?>"><br/><br/>
            <label>Departamento</label><br/>
            <?php echo selecionaDepartamento($servico['departamento']);?><br/><br/><br/>
            <input type="text" name="idManut" value="<?php echo $servico['idManut'];?>" style="display: none;">
            <input type="text" name="id" value="<?php echo $_GET['id'];?>" style="display: none;">
        </div>
        <canvas></canvas><br/>
        <input class="btn btn-success" type="submit" value="Feito">
    </form>
    <?php }?>
</section>
<?php
rodape();