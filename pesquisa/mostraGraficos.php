<?php
include_once '../funcoes/Corpo.php';
include_once '../funcoes/validar.php';
include_once './graficos.php';

cabecalho();
?>
<script src="../js/pesquisa.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php isset($_GET['grafico']) ? selecionaGrafico($_GET['grafico']) : "";?>
<section id="sessaoSelecao" class="sessaoSelecao" onload="pesquisarGrafico();">
    <h3>Gerador de gráficos</h3><br><br>
    <button class="btn btn-default botaoVoltar" onclick="window.location.replace('pesquisar.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button>
    <select id="selectGraficoPor" onchange="mostraGrafico();">
        <option selected>gerar por...</option>
        <option value="1">Computador - Propriedade</option>
        <option value="2">Computador - Marca</option>
        <option value="3">Memória - Capacidade</option>
        <option value="4">Memória - Barramento</option>
        <option value="5">Armazenamento - Capacidade</option>
        <option value="6">Armazenamento - Tecnologia</option>
        <option value="7">Sistema Operacional - Nome</option>
        <option value="8">Sistema Operacional - Licença</option>
        <option value="9">Processador - Arquitetura</option>
        <option value="10">Processador - Modelo</option>
        <option value="11">Todos</option>
    </select>
</section>
<section id="sessaoGrafico" style="width: 100%; height: 90%; padding: 5%; align-content: center; text-align: center; display: inline-block !important;">
    
</section>
<?php
rodape();