<?php
include_once '../funcoes/conection.php';
include_once '../funcoes/Corpo.php';
//parece que não, mas é necessário
$criterioC = $_SESSION['criterioC'] == ""? 0 : $_SESSION['criterioC'];
$graficos = $_SESSION['graficos'];

?>
<!DOCTYPE html>
<html><head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        function funcao(){
            google.charts.load('current', {'packages':['corechart']});
<?php
foreach ($graficos as $grafico){
    switch ($grafico){
        case '1':
            echo "google.charts.setOnLoadCallback(drawChart1);";
            break;
        case '2':
            echo "google.charts.setOnLoadCallback(drawChart2);";
            break;
        case '3':
            echo "google.charts.setOnLoadCallback(drawChart3);";
            break;
        case '4':
            echo "google.charts.setOnLoadCallback(drawChart4);";
            break;
        case '5':
            echo "google.charts.setOnLoadCallback(drawChart5);";
            break;
        case '6':
            echo "google.charts.setOnLoadCallback(drawChart6);";
            break;
        case '7':
            echo "google.charts.setOnLoadCallback(drawChart7);";
            break;
        case '8':
            echo "google.charts.setOnLoadCallback(drawChart8);";
            break;
        case '9':
            echo "google.charts.setOnLoadCallback(drawChart9);";
            break;
        case '10':
            echo "google.charts.setOnLoadCallback(drawChart10);";
            break;
        default :
            break;
        }
}
?>
        window.setTimeout(function(){window.document.getElementById("grafico").submit();}, 500);
    }
<?php
if(isset($_SESSION['graficos'])){
    $graficos = $_SESSION['graficos'];
    selecionaGraficos($graficos);
}

function selecionaGraficos($graficos){
    foreach ($graficos as $grafico){
        switch ($grafico){
            case '1':
                echo graficosPropriedade();
                break;
            case '2':
                echo graficosMarca();
                break;
            case '3':
                echo graficosMemoriaCapacidade();
                break;
            case '4':
                echo graficosMemoriaBarramento();
                break;
            case '5':
                echo graficosArmazenamentoCapacidade();
                break;
            case '6':
                echo graficosArmazenamentoTecnologia();
                break;
            case '7':
                echo graficosSOnome();
                break;
            case '8':
                echo graficosSOlicenca();
                break;
            case '9':
                echo graficosProcessadorArquitetura();
                break;
            case '10':
                echo graficosProcessadorModelo();
                break;
            default :
                break;
        }
    }
    
}
?>
</script>
</head>
<body onload="funcao();" style="display: none;">
    <div id='desenha'></div>
    <form id='grafico' action="gerarRelatorio.php" method="POST">
        <input type="text" name="computador" value="<?php echo $_SESSION['computador'];?>" style="display: none;">
        <input type="text" name="criterioC" value="<?php echo $criterioC;?>" style="display: none;">
        <input type="text" name="servico" value="<?php echo $_SESSION['servico'];?>" style="display: none;">
        <input type="text" name="criterioS" value="<?php echo $_SESSION['criterioS'];?>" style="display: none;">
        <input type="text" name="historico" value="<?php echo $_SESSION['historico'];?>" style="display: none;">
        <input type="text" name="criterioH" value="<?php echo $_SESSION['criterioH'];?>" style="display: none;">
    </form>
</body></html>
    <?php
//Pizza
function graficosPropriedade(){
    $query = "SELECT SUM(IF(tombo NOT LIKE '0', 1, 0)) AS comTombo, SUM(IF(tombo LIKE '0' AND alugado LIKE '0', 1, 0)) AS semTombo, SUM(IF(alugado NOT LIKE '0', 1, 0)) AS alugel FROM `computador`";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);

    $script = "function drawChart1() {

      var data = google.visualization.arrayToDataTable([
        ['Propriedade','Quantidade'],";
    while ($memoria = mysqli_fetch_assoc($sql)){
        $script .= "['Com Tombo', ".$memoria['comTombo']."], ['Sem Tombo', ".$memoria['semTombo']."], ['Alugado', ".$memoria['alugel']."] ";
    }
          
    $script .= "]);

    var options = {
      title: 'Propriedade dos Computadores'
    };

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.PieChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri1\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
  }";
    
    echo $script;
}

//Barras Horizontais
function graficosMarca(){
    $query = "SELECT m.nome, COUNT(c.idMarca) AS quantidade FROM marca m JOIN computador c ON c.idMarca = m.id GROUP BY m.nome ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart2() {
    
    var data = google.visualization.arrayToDataTable([
        ['Marcas', 'Quantidade'], ";
        
    while ($marca = mysqli_fetch_assoc($sql)){
        $script .= "['".utf8_encode($marca['nome'])."', ".$marca['quantidade']."], ";
    }
    $script .= "]);

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
    
    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.BarChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri2\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
}";
    return $script;
}
//barras horizontais
function graficosMemoriaCapacidade(){
    $query = "SELECT mem.capacidade, COUNT(c.idMem) AS quantidade FROM memoria mem JOIN computador c ON c.idMem = mem.id GROUP BY mem.capacidade ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart3() {
    
    var data = google.visualization.arrayToDataTable([
        ['Capacidade', 'Quantidade',], ";
        
    while ($marca = mysqli_fetch_assoc($sql)){
        $script .= "['".$marca['capacidade']."GB', ".$marca['quantidade']."], ";
    }
    $script .= "]);

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

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.BarChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri3\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
}
";
    return $script;
}

//Pizza
function graficosMemoriaBarramento(){
    $query = "SELECT mem.barramento, COUNT(c.idMem) AS quantidade FROM memoria mem JOIN computador c ON c.idMem = mem.id GROUP BY mem.barramento ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart4() {

        var data = google.visualization.arrayToDataTable([
          ['Barramento', 'Nome'],";
    while ($memoria = mysqli_fetch_assoc($sql)){
        $script .= "['".$memoria['barramento']."', ".$memoria['quantidade']."], ";
    }
    $script .="]);

    var options = {
      title: 'Barramento de Memórias'
    };

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.PieChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri4\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
      }";
    return $script;
}

//barras horizontais
function graficosArmazenamentoCapacidade(){
    $query = "SELECT ar.capacidade, COUNT(c.idArm) AS quantidade FROM armazenamento ar JOIN computador c ON c.idArm = ar.id GROUP BY ar.capacidade ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart5() {
    
    var data = google.visualization.arrayToDataTable([
        ['Capacidade', 'Quantidade',], ";
        
    while ($armazenamento = mysqli_fetch_assoc($sql)){
        $script .= "['".$armazenamento['capacidade']."GB', ".$armazenamento['quantidade']."], ";
    }
    $script .= "]);

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

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.BarChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri5\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
}";
    return $script;
}

//Pizza
function graficosArmazenamentoTecnologia(){
    $query = "SELECT ar.tecnologia, COUNT(c.idArm) AS quantidade FROM armazenamento ar JOIN computador c ON c.idArm = ar.id GROUP BY ar.tecnologia ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart6() {

        var data = google.visualization.arrayToDataTable([
          ['Tecnologia', 'Valor'],";
    while ($armazenamento = mysqli_fetch_assoc($sql)){
        $script .= "['".$armazenamento['tecnologia']."', ".$armazenamento['quantidade']."], ";
    }
    $script .="]);

    var options = {
      title: 'Tecnologia de Armazenamento'
    };

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.PieChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri6\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
    }";
    return $script;
}

//barras horizontais
function graficosSOnome(){
    $query = "SELECT CONCAT_WS(\" \", so.nome, so.versao) AS nomeOS, COUNT(c.idSO) AS quantidade FROM sistema_operacional so JOIN computador c ON c.idSO = so.id GROUP BY nomeOS ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart7() {
    
    var data = google.visualization.arrayToDataTable([
        ['Nome', 'Quantidade'], ";
        
    while ($so = mysqli_fetch_assoc($sql)){
        $script .= "['".$so['nomeOS']."', ".$so['quantidade']."], ";
    }
    $script .= "]);

    var options = {
        title: 'Uso de sistemas nos computadores',
        chartArea: {width: '40%'},
        hAxis: {
            title: 'Quantidade',
            minValue: 0
        },
        vAxis: {
            title: 'Sistemas Operacionais'
        }
    };

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.BarChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri7\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
}";
    return $script;
}

//Pizza
function graficosSOlicenca(){
    $query = "SELECT IF(so.licenca = '0', 'Não precisa', IF(so.licenca = '1', 'Não possui', 'Possui')) AS licenca, COUNT(c.idSO) AS quantidade FROM sistema_operacional so JOIN computador c ON c.idSO = so.id GROUP BY so.licenca ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart8() {

        var data = google.visualization.arrayToDataTable([
          ['Licenca', 'possui'],";
    while ($so = mysqli_fetch_assoc($sql)){
        $script .= "['".$so['licenca']."', ".$so['quantidade']."], ";
    }
    $script .="]);

    var options = {
      title: 'Licença de Sistemas Operacionais'
    };

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.PieChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri8\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
    }";
    return $script;
}

//Pizza
function graficosProcessadorArquitetura(){
    $query = "SELECT proc.arquitetura, COUNT(c.idProc) AS quantidade FROM processador proc JOIN computador c ON c.idProc = proc.id GROUP BY proc.arquitetura ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart9() {

        var data = google.visualization.arrayToDataTable([
          ['Arquitetura', 'valor'],";
    while ($proc = mysqli_fetch_assoc($sql)){
        $script .= "['".$proc['arquitetura']."bits', ".$proc['quantidade']."], ";
    }
    $script .="]);

    var options = {
      title: 'Arquitetura de processadores'
    };

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.PieChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri9\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
    }";
    return $script;
}

//barras horizontais
function graficosProcessadorModelo(){
    $query = "SELECT CONCAT_WS(\" \", proc.fabricante, proc.modelo) AS nome, COUNT(c.idProc) AS quantidade FROM processador proc JOIN computador c ON c.idProc = proc.id GROUP BY nome ORDER BY quantidade DESC";
    $conn = conecta();
    $sql = mysqli_query($conn, $query);
    desconecta($conn);
    
    $script = "function drawChart10() {
    
    var data = google.visualization.arrayToDataTable([
        ['Processador', 'Quantidade',], ";
        
    while ($marca = mysqli_fetch_assoc($sql)){
        $script .= "['".$marca['nome']."', ".$marca['quantidade']."], ";
    }
    $script .= "]);

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

    var div = window.document.getElementById(\"desenha\");
    var chart = new google.visualization.BarChart(div);
    chart.draw(data, options);
    var imgUri = chart.getImageURI();
    var input = window.document.createElement(\"input\");
    input.setAttribute(\"id\",\"uri10\");
    input.setAttribute(\"type\",\"text\");
    input.setAttribute(\"name\",\"imagem[]\");
    input.setAttribute(\"value\",imgUri);
    input.setAttribute(\"style\",\"display: none\");
    window.document.getElementById(\"grafico\").appendChild(input);
}";
    return $script;
}
