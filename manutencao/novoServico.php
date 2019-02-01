<?php
include '../funcoes/Corpo.php';
include '../computador/funcoesComputador.php';
include './funcoesManutencao.php';
include '../funcoes/funcoesAvisos.php';
include '../funcoes/funcoesUteis.php';
cabecalho();
isset($_GET['etiqueta'])? mostraEtiqueta($_GET['etiqueta']): "";
?>
<script>
function limitaComeco(data){
  $("#dataSaida").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: data.toString(),
        minuteStep: 10
    })
}
$( "#dataSaida" ).click(
  $("#dataEntrada").datepicker({ minDate: 0, maxDate: "+3D" })
);
</script>
<div id="modalCadastro" class="modalFundo"></div>
<div id="modalManutencao" class="modalFundo"></div>
<section class="sessaoFormulario">
    <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
    <div class="formularios">
        <h3>Novo serviço de manutenção</h3><br><br>
        
        <h4>O computador já está cadastrado no sistema?&nbsp;<input type="checkbox" checked onmousedown="mudaForm();" class="check-form"></h4><br/><br/>

        <form id="cadastroComputador" action="../computador/cadastrarComputador.php" method="POST" style="display: none;" class="">
            <canvas></canvas>
            <h4>Cadastre o computador</h4><br/>
            <label>Tombo</label>
            <input type="text" name="tombo" onkeyup="marcaNao();"><br/><br/>
            <label>Alugado?</label>&nbsp;
            <input type="radio" name="alugado" value="1" onclick="desabilitaTombo();"> Sim&nbsp;
            <input id="nao" type="radio" name="alugado" value="0" onclick="habilitaTombo();"> Não <br/><br/>
            <label>Marca</label>
            <?php echo selecionaMarcas("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modal(1, 1);"></i><br/><br/>
            <label>Memória</label>
            <?php echo selecionaMemoria("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modal(2, 1)"></i><br/><br/>
            <label>Processador</label>
            <?php echo selecionaProcessador("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(3, 1);"></i><br/><br/>
            <label>Armazenamento</label>
            <?php echo selecionaArmazenamento("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(4, 1);"></i><br/><br/>
            <label>Sistema Operacional</label>
            <?php echo selecionaSO("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(5, 1)"></i><br/><br/>
            <input name="flag" value="1" style="display: none;"><br/><br/>
            <input class="btn btn-success" type="submit" value="Cadastrar">
        </form>
        <form id="cadastroServico" action="cadastrarManutencao.php" method="POST" class="col-lg-12">
            <h4>Descrição do serviço</h4>
            <label>Etiqueta do computador</label>
            <p class="busca-pc"><input id="etiqueta" type="text" onkeyup='procuraComputador(this.value);' name="etiqueta" <?php echo isset($_GET['etiqueta']) && !antiInjection($_GET['etiqueta'])? "value=\"".$_GET['etiqueta']."\"": "";?> required="required">
            <span id="descricao" class="busca-pc-right busca-pc-texto" style="visibility: hidden;" onclick="fechaModal('descricao');"></span></p>
            <br/>
            <label>Usuário do Computador</label><br/><input type="text" name="usuario"><br/><br/>
            <label>Departamento</label><br/><?php echo selecionaDepartamento("");?><br/><br/>
            <label>Entrada</label><br/><input type="date" name="dataEntrada" required="required" onchange="limitaComeco(this.value);"><br/><br/>
            <label>Saída</label><br/><input type="date" name="dataSaida" required="required"><br/><br/>
            <label>Problema</label><br/>
            <?php echo selecionaProblemas();?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modalManutencao(1);"></i> <br/><br/>
            <table id="problemas" style="visibility: hidden;">
                <thead><tr><th>Problema(s)</th><th></th><th></th></tr></thead>
                <tbody id="problemasBody"></tbody>
            </table><br/><br/>
            <label>Procedimento</label><br/><textarea name="procedimento" cols="80" rows="5"></textarea><br/><br/>
            <label>Observação (opcional)</label><br/><textarea name="observacao" cols="80" rows="5"></textarea>
            <br/><br/>
            <label>Realizado por:&nbsp;&nbsp;</label><?php echo selecionaUsuario("");?><br/><br/>
            <input type="submit" class="btn btn-success" value="Feito">
        </form>
    </div>
    
    <!--div id="computador" style="display: none;" class="">
        
    </div>
    <div id="servico" class="col-lg-12">
        
    </div-->
</section>
<?php
rodape();