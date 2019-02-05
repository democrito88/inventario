<?php
include '../funcoes/Corpo.php';
include '../funcoes/funcoesUteis.php';
include '../computador/funcoesComputador.php';
include '../funcoes/funcoesAvisos.php';
cabecalho();
?>
<section class="sessaoFormulario">
    <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/><br/><br/>
    <div class="formHistorico">
        <h3>Cadastre uma nova atividade</h3>
        <h4>O computador já está cadastrado no sistema?&nbsp;<input type="checkbox" checked onmousedown="mudaForm();" class="check-form"></h4><br/><br/>
        <form id="cadastroComputador" action="../computador/cadastrarComputador.php" method="POST" style="display: none;" class="">
            <!--canvas></canvas -->
            <canvas class="divisoriaHistorico"></canvas>
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
            <input name="flag" value="2" style="display: none;">
            <input class="btn btn-success" type="submit" value="Cadastrar">
        </form>
        <form id="cadastroServico" action="cadastrarHistorico.php" method="POST" class="col-lg-12">
            <label>Etiqueta do Computador</label><br/>
            <p class="busca-pc">
                <input id="etiqueta" type="text" onkeyup='procuraComputador(this.value);' name="etiqueta" required="required">
                <span id="descricao" class="busca-pc-right busca-pc-texto" style="visibility: hidden;" onclick="fechaModal('descricao');"></span>
            </p><br/>
            <label>Usuário do computador</label><br/>
            <input type="text" name="usuario"><br/>
            <label>Departamento onde se encontra agora</label><br/>
            <?php echo selecionaDepartamento("");?><br/><br/>
            <label>Início</label><br/><input type="date" name="dataEntrada" required="required"><br/><br/>
            <label>Término</label><br/><input type="date" name="dataSaida" required="required"><br/><br/>
            <label>Descrição do que foi feito</label><br/>
            <textarea name="descricao" cols="80" rows="5"></textarea><br/><br/>
            <label>Realizado por:&nbsp;&nbsp;</label><?php echo selecionaUsuario("");?><br/><br/>
            <input class="btn btn-success" type="submit" value="Feito">
        </form>
    </div>
</section>
<?php
rodape();