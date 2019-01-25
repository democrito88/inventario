<?php
include_once '../funcoes/Corpo.php';
cabecalho();
unset($_POST);
?>
<script src="../js/relatorio.js"></script>
<section style="padding: 5% 0%; text-align: center; color: #555; min-height: 600px;">
    <button class="btn btn-primary" onclick="window.location.replace('../principal.php')" style="float: left; margin-left: 5%;"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
    <h3>Relatório do Inventário</h3>
    <h4>gere relatórios com tabelas e gráficos</h4>
    <form id="formularioRelatorio" action="gerarRelatorio.php" method="POST">
        <div class="row" style="min-height: 30px;">
            <div class="col-lg-6">
                <label>Computadores</label><input type="checkbox" onclick="habilitaSelect(1);"/><br>
                <select id="selectComputador" class="selectRelatorio" name="computador" onchange="inputComputador(this.value);">
                    <option value="0" selected>Ordenar por...</option>
                    <option value="1">Etiqueta</option>
                    <option value="2">Marca</option>
                    <option value="3">Tombo</option>
                    <option value="4">Alugado</option>
                    <option value="5">Memória</option>
                    <option value="6">Armazenamento</option>
                    <option value="7">Sistema Operacional</option>
                    <option value="8">Processador</option>
                </select>
                <div id="opcaoComp" style="margin: 2%;">

                </div>
            </div>
            <div class="col-lg-6">
                <label>Serviço de Manutenção</label><input type="checkbox" onclick="habilitaSelect(2);"/><br>
                <select id="selectManutencao" class="selectRelatorio" name="manutencao" onchange="escolhaDeTabela(1, this.value);">
                    <option value="" selected>Filtrar por...</option>
                    <option value="1">Etiqueta do Computador</option>
                    <option value="2">Usuario</option>
                    <option value="3">Departamento</option>
                    <option value="4">Data de Entrada</option>
                    <option value="5">Data de Saída</option>
                </select>
                <div id="opcaoManut" style="margin: 2%;">

                </div>
            </div>
        </div>
        <div class="row" style="min-height: 30px;">
            <div class="col-lg-6">
                <label>Serviços em geral</label><input type="checkbox" onclick="habilitaSelect(3);"/><br>
                <select id="selectHistorico" class="selectRelatorio" name="servico" onchange="escolhaDeTabela(2, this.value);">
                    <option value="" selected>Filtrar por...</option>
                    <option value="1">Etiqueta do Computador</option>
                    <option value="2">Usuario</option>
                    <option value="3">Departamento</option>
                    <option value="4">Data de Entrada</option>
                    <option value="5">Data de Saída</option>
                </select>
                <div id="opcaoHist" style="margin: 2%;">

                </div>
            </div>
            <div class="col-lg-6">
                <label>Gráficos</label><input type="checkbox" onclick="habilitaSelect(4);"/><br>
                <ul id="listaGrafico" class="selectRelatorio listaGraficos">
                    <li><input type="checkbox" name="graficos[]" value="0" id="todos" onclick="selecionaTodos();" />&nbsp;&nbsp;Todos</li>
                    <li><input type="checkbox" name="graficos[]" value="1"/>&nbsp;&nbsp;Computador - Propriedade</li>
                    <li><input type="checkbox" name="graficos[]" value="2"/>&nbsp;&nbsp;Computador - Marca</li>
                    <li><input type="checkbox" name="graficos[]" value="3"/>&nbsp;&nbsp;Memória - Capacidade</li>
                    <li><input type="checkbox" name="graficos[]" value="4"/>&nbsp;&nbsp;Memória - Barramento</li>
                    <li><input type="checkbox" name="graficos[]" value="5"/>&nbsp;&nbsp;Armazenamento - Capacidade</li>
                    <li><input type="checkbox" name="graficos[]" value="6"/>&nbsp;&nbsp;Armazenamento - Tecnologia</li>
                    <li><input type="checkbox" name="graficos[]" value="7"/>&nbsp;&nbsp;Sistema Operacional - Nome</li>
                    <li><input type="checkbox" name="graficos[]" value="8"/>&nbsp;&nbsp;Sistema Operacional - Licença</li>
                    <li><input type="checkbox" name="graficos[]" value="9"/>&nbsp;&nbsp;Processador - Arquitetura</li>
                    <li><input type="checkbox" name="graficos[]" value="10"/>&nbsp;&nbsp;Processador - Modelo</li>
                </ul>
            </div>
        </div>
        <button class="btn btn-success" type="submit" style="margin: auto;">Gerar</button>
    </form>
</section>
<?php
rodape();