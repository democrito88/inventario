<?php
include '../funcoes/Corpo.php';
include 'funcoesComputador.php';
cabecalho();
?>

        <div id="modalCadastro" class="modalFundo"></div>
        <section class="sessaoFormulario">
            <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
            <h3>Cadastre um novo computador</h3>
            <form id="cadastroComputador" action="cadastrarComputador.php" method="post">
                <label>Tombo</label>
                <input type="text" name="tombo" onkeyup="marcaNao();"><br/>
                <label>Alugado?</label>&nbsp;
                <input type="radio" name="alugado" value="1" onclick="desabilitaTombo();"> Sim&nbsp;
                <input id="nao" type="radio" name="alugado" value="0" onclick="habilitaTombo();"> Não <br/><br/>
                <label>Marca</label>
                <?php echo selecionaMarcas("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modal(1, 0);"></i><br/>
                <label>Memória</label>
                <?php echo selecionaMemoria("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar nova" onclick="modal(2, 0)"></i><br/>
                <label>Processador</label>
                <?php echo selecionaProcessador("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(3, 0);"></i><br/>
                <label>Armazenamento</label>
                <?php echo selecionaArmazenamento("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(4, 0);"></i><br/>
                <label>Sistema Operacional</label>
                <?php echo selecionaSO("");?>&nbsp;<i class="glyphicon glyphicon-plus-sign" title="adicionar novo" onclick="modal(5, 0)"></i><br/>
                <input name="flag" value="0" style="display: none;">
                <input class="btn btn-success" type="submit" value="Cadastrar">
            </form>
        </section>
<?php
rodape();