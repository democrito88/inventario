<?php
include './funcoes/conection.php';
include './funcoes/Corpo.php';
include './funcoes/funcoesUteis.php';
include './funcoes/funcoesAvisos.php';
cabecalho();
if(isset($_GET['flag'])){
    mostraAviso($_GET['flag']);
}
?>
<aside onload="menuDropdown();">
    <a href="computador/listarComputadores.php?pag=1">Computadores</a>
    <canvas></canvas>
    <a href="historico/listarServico.php?pag=1">Serviços Gerais</a>
    <canvas></canvas>
    <a href="manutencao/listarManutencao.php?pag=1">Manutenções</a>
    <canvas></canvas>
    <a href='pesquisa/pesquisar.php'>Pesquisar</a>
    <canvas></canvas>
    <a href='relatorio/novoRelatorio.php'>Relatório</a>
</aside>
<section class="principalSessao">
    <h3>Inventário de máquinas</h3><h4>Consulte computadores cadastrados no sistema</h4>
    <table class="table table-hover principalTabela">
        <thead>
            <tr><th>Etiqueta</th><th>Marca</th><th>Tombo</th><th>Alugado</th><th>Memória</th><th>Armaz.</th><th>S.O.</th><th>Processador</th><th></th><th></th></tr>
        </thead>
        <tbody>
            <?php
            $conn = conecta();
            $query = "SELECT c.`id`, c.`etiqueta`, c.`tombo`, c.`alugado`, ma.nome AS marca,
CONCAT_WS(\" \", me.barramento, me.capacidade) AS memoria,
CONCAT_WS(\" \", ar.tecnologia, ar.capacidade) AS armazenamento,
CONCAT_WS(\" \", so.nome, so.versao, IF(so.licenca = '1', '*', '')) AS SO,
CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador
FROM computador c, marca ma , memoria me , armazenamento ar, sistema_operacional so, processador p
WHERE c.idMarca = ma.id AND c.idMem = me.id AND c.idArm = ar.id AND c.idSO = so.id AND c.idProc = p.id
ORDER BY c.id DESC LIMIT 10";
            $requisicao = mysqli_query($conn, $query);
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    echo "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        echo "<tr><th>".(is_null($tupla['etiqueta']) || $tupla['etiqueta'] === '0'? "Não possui" : $tupla['etiqueta'])."</th><th>".utf8_encode($tupla['marca'])."</th><th>".(($tupla['tombo'] == 0)? "não possui" : $tupla['tombo'])."</th><th>".(($tupla['alugado'] == 0)? "não" : "sim")."</th>"
                                . "<th>".$tupla['memoria']."GB</th><th>".$tupla['armazenamento']."GB</th><th>".$tupla['SO']."</th><th>".$tupla['processador']."bits</th>"
                                . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='computador/editarComputador.php?id=".$tupla['id']."'></a></th>"
                                . "<th>".($_SESSION['id'] == '1'? "<p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='computador/removerComputador.php?id=".$tupla['id']."'>Sim</a></span></p>" : "")."</th></tr>";
                    }
                }
            }else{
                echo "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
            }
            ?>
        </tbody>
        <tfoot><tr><td><button class="btn btn-primary" onclick="window.location.replace('computador/novoComputador.php')"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
    </table>
</section>
<section class="principalSessao">
    <h3>Manutenção</h3><h4>Consulte computadores que receberam manutenção</h4>
    <table class="table table-hover principalTabela">
        <thead>
            <tr><th>Etiqueta</th><th>Usuário</th><th>Departamento</th><th>Entrada</th><th>Saída</th><th>Proced.</th><th></th><th></th><th></th></tr>
        </thead>
        <tbody>
            <?php

            $query = "SELECT h.id, h.idComp, h.idManut, c.etiqueta, h.usuario, h.departamento, h.dataEntrada, h.dataSaida, SUBSTR(m.procedimento , 1, 10) AS proc FROM historico h, manutencao m, computador c WHERE h.idManut = m.id AND h.idComp = c.id ORDER BY dataEntrada DESC LIMIT 10;";
            $requisicao = mysqli_query($conn, $query);
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    echo "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        echo "<tr><th>".$tupla['etiqueta']."</th><th>".$tupla['usuario']."</th><th>".nomeDepartamento($tupla['departamento'])."</th>"
                                . "<th>".date("d/m/Y", strtotime($tupla['dataEntrada']))."</th><th>".date("d/m/Y", strtotime($tupla['dataSaida']))."</th>"
                                ."<th>".$tupla['proc']."...</th>"
                                . "<th><a title='Detalhes' class='glyphicon glyphicon-info-sign detalhes' onclick='detalheManutencao(".$tupla['id'].", true);'></a></th>"
                                . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='manutencao/editarManutencao.php?id=".$tupla['id']."'></a></th>"
                                . "<th>".($_SESSION['id'] == '1'? "<p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='manutencao/removerManutencao.php?id=".$tupla['idManut']."'>Sim</a></span></p>" : "")."</th></tr>";
                    }
                }
            }else{
                echo "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
            }

            ?>
        </tbody>
        <tfoot><tr><td><button class="btn btn-primary" onclick="window.location.replace('manutencao/novoServico.php')"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
    </table>
</section>
<section class="principalSessao">
    <h3>Serviços</h3><h4>Histórico de serviços em computadores</h4>
    <table class="table table-hover principalTabela">
        <thead>
            <tr><th>Etiqueta</th><th>Departamento</th><th>Usuário</th><th>Entrada</th><th>Saída</th><th></th><th></th><th></th></tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT h.id, h.departamento, h.usuario, h.idComp, h.dataEntrada, h.dataSaida, c.etiqueta FROM historico h, computador c WHERE c.id = h.idComp ORDER BY dataEntrada DESC LIMIT 10";
            $requisicao = mysqli_query($conn, $query);
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    echo "<tr><th><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></th></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        echo "<tr><th>".$tupla['etiqueta']."</th><th>".nomeDepartamento($tupla['departamento'])."</th><th>".$tupla['usuario']."</th>"
                                . "<th>".date("d/m/Y", strtotime($tupla['dataEntrada']))."</th><th>".date("d/m/Y", strtotime($tupla['dataSaida']))."</th>"
                                . "<th><a title='Detalhes' class='glyphicon glyphicon-info-sign detalhes' onclick='detalheHistorico(".$tupla['id'].", true);'></a></th>"
                                . "<th><a title='Editar' class='glyphicon glyphicon-edit editar' href='historico/editarHistorico.php?id=".$tupla['id']."'></a></th>"
                                . "<th>".($_SESSION['id'] == '1'? "<p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='historico/removerHistorico.php?id=".$tupla['id']."'>Sim</a></span></p>" : "")."</th></tr>";
                    }
                }
            }else{
                echo "<tr><th><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></th></tr>";
            }
            desconecta($conn);
            ?>
        </tbody>
        <tfoot><tr><td><button class="btn btn-primary" onclick="window.location.replace('historico/novoHistorico.php')"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
    </table>
</section>
<?php
rodape();
