<?php
include '../funcoes/Corpo.php';
include_once '../funcoes/validar.php';
include 'funcoesComputador.php';
cabecalho();
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    antiInjection($_GET['id']) ? header("Location: index.php") : $id = $_GET['id'];
}
$conn = conecta();
$query = "SELECT * FROM computador WHERE id = ".$id;
$sql = mysqli_query($conn, $query);
desconecta($conn);
?>
<div id="modalCadastro" class="modalFundo"></div>
<section class="sessaoFormulario">
    <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
    <h3>Edite um computador</h3>
    <form id="cadastroComputador" action="atualizarComputador.php" method="post">
        <?php
        while($computador = mysqli_fetch_assoc($sql)){
        ?>
        <input name="id" value="<?php echo $computador['id'];?>" style="display: none;">
        <label>Tombo</label>
        <input type="text" name="tombo" value="<?php echo $computador['tombo'];?>" onkeyup="marcaNao();"><br/>
        <label>Alugado?</label>&nbsp;
        <input type="radio" name="alugado" value="1" <?php echo $computador['alugado'] === "1"? "checked": "";?> onclick="desabilitaTombo();"> Sim&nbsp;
        <input id="nao" type="radio" name="alugado" value="0" <?php echo $computador['alugado'] === "0"? "checked": "";?> onclick="habilitaTombo();"> Não <br/><br/>
        <label>Marca</label>
        <?php echo selecionaMarcas($computador['idMarca']);?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modal(1, <?php echo $computador['id'];?>);"></i><br/>
        <label>Memória</label>
        <?php echo selecionaMemoria($computador['idMem']);?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modal(2, <?php echo $computador['id'];?>)"></i><br/>
        <label>Processador</label>
        <?php echo selecionaProcessador($computador['idProc']);?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(3, <?php echo $computador['id'];?>);"></i><br/>
        <label>Armazenamento</label>
        <?php echo selecionaArmazenamento($computador['idArm']);?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(4, <?php echo $computador['id'];?>);"></i><br/>
        <label>Sistema Operacional</label>
        <?php echo selecionaSO($computador['idSO']);?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(5, <?php echo $computador['id'];?>);"></i><br/>
        <input class="btn btn-success" type="submit" value="Atualizar">
        <?php
        }
        ?>
    </form>
</section>
<?php
rodape();

