<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/validar.php';

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['grafico']) ){
    $grafico = antiInjection($_GET['grafico'])? "" : $_GET['grafico'];
}

function selecionaGrafico($grafico){
    switch ($grafico){
        case '1':
            echo graficoPropriedade();
            break;
        case '2':
            echo graficoMarca();
            break;
        case '3':
            echo graficoMemoriaCapacidade();
            break;
        case '4':
            echo graficoMemoriaBarramento();
            break;
        case '5':
            echo graficoArmazenamentoCapacidade();
            break;
        case '6':
            echo graficoArmazenamentoTecnologia();
            break;
        case '7':
            echo graficoSOnome();
            break;
        case '8':
            echo graficoSOlicenca();
            break;
        case '9':
            echo graficoProcessadorArquitetura();
            break;
        case '10':
            echo graficoProcessadorModelo();
            break;
        case '11':
            echo graficoPropriedade();
            echo graficoMarca();
            echo graficoMemoriaCapacidade();
            echo graficoMemoriaBarramento();
            echo graficoArmazenamentoCapacidade();
            echo graficoArmazenamentoTecnologia();
            echo graficoSOnome();
            echo graficoSOlicenca();
            echo graficoProcessadorArquitetura();
            echo graficoProcessadorModelo();
            break;
        default :
            break;
        
    }
}

//Pizza
function graficoPropriedade(){
    $query = "SELECT SUM(IF(tombo NOT LIKE '0', 1, 0)) AS comTombo, SUM(IF(tombo LIKE '0' AND alugado LIKE '0', 1, 0)) AS semTombo, SUM(IF(alugado NOT LIKE '0', 1, 0)) AS alugel FROM `computador`";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Propriedade','Quantidade'],";
    while ($memoria = mysqli_fetch_assoc($sql)){
        $script .= "['Com Tombo', ".$memoria['comTombo']."], ['Sem Tombo', ".$memoria['semTombo']."], ['Alugado', ".$memoria['alugel']."] ";
    }
          $script .="
        ]);

        var options = {
          title: 'Propriedade dos Computadores'
        };
        
        var div = window.document.createElement('div');
        div.style = 'float:left; margin: 1%;';
        var chart = new google.visualization.PieChart(div);
        var sessao = document.getElementById('sessaoGrafico');
        sessao.appendChild(div);

        chart.draw(data, options);
      }
    </script>
";
    return $script;
}

//Barras Horizontais
function graficoMarca(){
    $query = "SELECT m.nome, COUNT(c.idMarca) AS quantidade FROM marca m JOIN computador c ON c.idMarca = m.id GROUP BY m.nome ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "
<script type=\"text/javascript\">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
    
    var data = google.visualization.arrayToDataTable([
        ['Marcas', 'Quantidade'], ";
        
    while ($marca = mysqli_fetch_assoc($sql)){
        $script .= "['".utf8_encode($marca['nome'])."', ".$marca['quantidade']."], ";
    }
    $script .= "
    ]);

    var options = {
        title: 'Marcas dos Computadores',
        chartArea: {width: '40%'},
        hAxis: {
            title: 'Quantidade',
            minValue: 0
        },
        vAxis: {
            title: 'Marcas'
        }
    };
    
    var div = window.document.createElement('div');
    div.style = 'float:left; margin: 1%;';
    var chart = new google.visualization.BarChart(div);
    var sessao = window.document.getElementById('sessaoGrafico');
    sessao.appendChild(div);
    chart.draw(data, options);
}
</script>";
    return $script;
}
//barras horizontais
function graficoMemoriaCapacidade(){
    $query = "SELECT mem.capacidade, COUNT(c.idMem) AS quantidade FROM memoria mem JOIN computador c ON c.idMem = mem.id GROUP BY mem.capacidade ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "
<script type=\"text/javascript\">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
    
    var data = google.visualization.arrayToDataTable([
        ['Capacidade', 'Quantidade',], ";
        
    while ($marca = mysqli_fetch_assoc($sql)){
        $script .= "['".$marca['capacidade']."GB', ".$marca['quantidade']."], ";
    }
    $script .= "
    ]);

    var options = {
        title: 'Capacidade da memória dos computadores',
        chartArea: {width: '40%'},
        hAxis: {
            title: 'Quantidade',
            minValue: 0
        },
        vAxis: {
            title: 'Capacidade'
        }
    };

    var div = window.document.createElement('div');
    div.style = 'float:left; margin: 1%;';
    var chart = new google.visualization.BarChart(div);
    var sessao = window.document.getElementById('sessaoGrafico');
    sessao.appendChild(div);
    chart.draw(data, options);
}
</script>";
    return $script;
}

//Pizza
function graficoMemoriaBarramento(){
    $query = "SELECT mem.barramento, COUNT(c.idMem) AS quantidade FROM memoria mem JOIN computador c ON c.idMem = mem.id GROUP BY mem.barramento ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Barramento', 'Nome'],";
    while ($memoria = mysqli_fetch_assoc($sql)){
        $script .= "['".$memoria['barramento']."', ".$memoria['quantidade']."], ";
    }
          $script .="
        ]);

        var options = {
          title: 'Barramento de Memórias'
        };
        
        var div = window.document.createElement('div');
        div.style = 'float:left; margin: 1%;';
        var chart = new google.visualization.PieChart(div);
        var sessao = document.getElementById('sessaoGrafico');
        sessao.appendChild(div);

        chart.draw(data, options);
      }
    </script>
";
    return $script;
}

//barras horizontais
function graficoArmazenamentoCapacidade(){
    $query = "SELECT ar.capacidade, COUNT(c.idArm) AS quantidade FROM armazenamento ar JOIN computador c ON c.idArm = ar.id GROUP BY ar.capacidade ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "
<script type=\"text/javascript\">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
    
    var data = google.visualization.arrayToDataTable([
        ['Capacidade', 'Quantidade',], ";
        
    while ($armazenamento = mysqli_fetch_assoc($sql)){
        $script .= "['".$armazenamento['capacidade']."GB', ".$armazenamento['quantidade']."], ";
    }
    $script .= "
    ]);

    var options = {
        title: 'Capacidade de armazenamento em disco dos computadores',
        chartArea: {width: '40%'},
        hAxis: {
            title: 'Quantidade',
            minValue: 0
        },
        vAxis: {
            title: 'Capacidade'
        }
    };

    var div = window.document.createElement('div');
    div.style = 'float:left; margin: 1%;';
    var chart = new google.visualization.BarChart(div);
    var sessao = window.document.getElementById('sessaoGrafico');
    sessao.appendChild(div);
    chart.draw(data, options);
}
</script>";
    return $script;
}

//Pizza
function graficoArmazenamentoTecnologia(){
    $query = "SELECT ar.tecnologia, COUNT(c.idArm) AS quantidade FROM armazenamento ar JOIN computador c ON c.idArm = ar.id GROUP BY ar.tecnologia ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Tecnologia', 'Valor'],";
    while ($armazenamento = mysqli_fetch_assoc($sql)){
        $script .= "['".$armazenamento['tecnologia']."', ".$armazenamento['quantidade']."], ";
    }
          $script .="
        ]);

        var options = {
          title: 'Tecnologia de Armazenamento'
        };

        var div = window.document.createElement('div');
        div.style = 'float:left; margin: 1%;';
        var chart = new google.visualization.PieChart(div);
        var sessao = document.getElementById('sessaoGrafico');
        sessao.appendChild(div);

        chart.draw(data, options);
      }
    </script>
";
    return $script;
}

//barras horizontais
function graficoSOnome(){
    $query = "SELECT CONCAT_WS(\" \", so.nome, so.versao) AS nomeOS, COUNT(c.idSO) AS quantidade FROM sistema_operacional so JOIN computador c ON c.idSO = so.id GROUP BY nomeOS ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "
<script type=\"text/javascript\">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
    
    var data = google.visualization.arrayToDataTable([
        ['Nome', 'Quantidade',], ";
        
    while ($so = mysqli_fetch_assoc($sql)){
        $script .= "['".$so['nomeOS']."', ".$so['quantidade']."], ";
    }
    $script .= "
    ]);

    var options = {
        title: 'Uso de sistemas nos computadores',
        chartArea: {width: '40%'},
        hAxis: {
            title: 'Quantidade',
            minValue: parseInt(0)Olinda@2017
            
        },
        vAxis: {
            title: 'Sistemas Operacionais'
        }
    };

    var div = window.document.createElement('div');
    div.style = 'float:left; margin: 1%;';
    var chart = new google.visualization.BarChart(div);
    var sessao = window.document.getElementById('sessaoGrafico');
    sessao.appendChild(div);
    chart.draw(data, options);
}
</script>";
    return $script;
}

//Pizza
function graficoSOlicenca(){
    $query = "SELECT IF(so.licenca = '0', 'Não precisa', IF(so.licenca = '1', 'Não possui', 'Possui')) AS licenca, COUNT(c.idSO) AS quantidade FROM sistema_operacional so JOIN computador c ON c.idSO = so.id GROUP BY so.licenca ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Licenca', 'possui'],";
    while ($so = mysqli_fetch_assoc($sql)){
        $script .= "['".$so['licenca']."', ".$so['quantidade']."], ";
    }
          $script .="
        ]);

        var options = {
          title: 'Licença de Sistemas Operacionais'
        };

        var div = window.document.createElement('div');
        div.style = 'float:left; margin: 1%;';
        var chart = new google.visualization.PieChart(div);
        var sessao = document.getElementById('sessaoGrafico');
        sessao.appendChild(div);

        chart.draw(data, options);
      }
    </script>
";
    return $script;
}

//Pizza
function graficoProcessadorArquitetura(){
    $query = "SELECT proc.arquitetura, COUNT(c.idProc) AS quantidade FROM processador proc JOIN computador c ON c.idProc = proc.id GROUP BY proc.arquitetura ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "<script type=\"text/javascript\">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Arquitetura', 'valor'],";
    while ($proc = mysqli_fetch_assoc($sql)){
        $script .= "['".$proc['arquitetura']."bits', ".$proc['quantidade']."], ";
    }
          $script .="
        ]);

        var options = {
          title: 'Arquitetura de processadores'
        };

        var div = window.document.createElement('div');
        div.style = 'float:left; margin: 1%;';
        var chart = new google.visualization.PieChart(div);
        var sessao = document.getElementById('sessaoGrafico');
        sessao.appendChild(div);

        chart.draw(data, options);
      }
    </script>
";
    return $script;
}

//barras horizontais
function graficoProcessadorModelo(){
    $query = "SELECT CONCAT_WS(\" \", proc.fabricante, proc.modelo) AS nome, COUNT(c.idProc) AS quantidade FROM processador proc JOIN computador c ON c.idProc = proc.id GROUP BY nome ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "
<script type=\"text/javascript\">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
    
    var data = google.visualization.arrayToDataTable([
        ['Processador', 'Quantidade',], ";
        
    while ($marca = mysqli_fetch_assoc($sql)){
        $script .= "['".$marca['nome']."', ".$marca['quantidade']."], ";
    }
    $script .= "
    ]);

    var options = {
        title: 'Processadores usados nos computadores',
        chartArea: {width: '40%'},
        hAxis: {
            title: 'Quantidade',
            minValue: 0
        },
        vAxis: {
            title: 'Processadores'
        }
    };

    var div = window.document.createElement('div');
    div.style = 'float:left; margin: 1%;';
    var chart = new google.visualization.BarChart(div);
    var sessao = window.document.getElementById('sessaoGrafico');
    sessao.appendChild(div);
    chart.draw(data, options);
}
</script>";
    return $script;
}
