<?php
include '../funcoes/Corpo.php';
include '../funcoes/funcoesUteis.php';
include_once './funcoesHistorico.php';
cabecalho();

if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])){
    $id = antiInjection($_GET['id']) == false ? $_GET['id'] : "";
    isset($_GET['etiqueta']) ? avisoHistorico($_GET['etiqueta']) : "";
}
if($id === ""){
    throw new Exception("<h4>Tentativa de inserção de código malicioso detectada</h4>");
}else{
    $conn = conecta();
    $query = "SELECT h.*, c.etiqueta FROM historico h, computador c WHERE h.id = ".$id." AND h.idComp = c.id";
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
}

?>
<section class="sessaoFormulario">
    <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
    <h3>Edite uma atividade</h3>
    <h4>Atividade feita em um computador já cadastrado no sistema</h4>
    <form action="atualizarHistorico.php" method="POST">
        <?php
        while($historico = mysqli_fetch_assoc($sql)){
        ?>
        <label>Etiqueta do Computador</label><br/>
        <p class="busca-pc">
            <input id="etiqueta" type="text" onkeyup='procuraComputador(this.value);' name="etiqueta" value="<?php echo $historico['etiqueta']?>" required="required">
            <span id="descricao" class="busca-pc-right busca-pc-texto" style="visibility: hidden;" onclick="fechaModal('descricao');"></span>
        </p><br/>
        <label>Usuário do computador</label><br/>
        <input type="text" name="usuario" value="<?php echo $historico['usuario'];?>"><br/>
        <label>Departamento onde se encontra agora</label><br/>
        <?php echo selecionaDepartamento($historico['departamento']);?><br/>
        <label>Início</label><br/><input type="date" name="dataEntrada" value="<?php echo $historico['dataEntrada'];?>" required="required"><br/><br/>
        <label>Término</label><br/><input type="date" name="dataSaida" value="<?php echo $historico['dataSaida'];?>" required="required"><br/><br/>
        <label>Descrição do que foi feito</label><br/>
        <textarea name="descricao" cols="80" rows="5"><?php echo $historico['descricao'];?></textarea><br/><br/>
        <label>Realizado por:&nbsp;&nbsp;</label><?php echo selecionaUsuario($historico['idUsuario']);?><br/><br/>
        <input type="text" name="id" value="<?php echo $historico['id'];?>" style="display: none;">
        <input class="btn btn-success" type="submit" value="Feito">
        <?php }?>
    </form>
</section>
<?php
rodape();
