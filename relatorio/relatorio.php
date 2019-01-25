<?php
require ('./pDF_MC_Table.php');
include_once '../pesquisa/graficos.php';
include_once '../funcoes/conection.php';
include_once '../funcoes/funcoesUteis.php';

class Relatorio extends pDF_MC_Table
{
    
    function __construct() {
        parent::__construct();
    }
    
    // Cabecalho
    function Header()
    {
        // Logo
        $this->Image('../img/brasao.png',35,10,7);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(40);
        // Title
        $this->Cell(135,10,utf8_decode('Sistema de Inventário de Computadores da P.M.O.'),1,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Rodapé
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }
    
    function geraTabelaComputador($criterios, $computador){
        //cabeçalho da tabela
        $cabecalho = array('Etiqueta','Tombo', 'Alugado','Marca',utf8_decode('Memória'),'Armazeamento','S.O.','Processador');
        switch($criterios){
            case '1':
                $fimQuery = " c.`etiqueta` ";
                $subtitulo = "etiqueta";
                break;
            case '2':
                $fimQuery = "ma.`id`";
                $subtitulo = "marca";
                break;
            case '3':
                $fimQuery = " c.`tombo` ";
                $subtitulo = "tombo";
                break;
            case '4':
                $fimQuery = " c.`alugado` ";
                $subtitulo = "status de alugado";
                break;
            case '5':
                $fimQuery = " c.`idMem` ";
                $subtitulo = utf8_decode("memória");
                break;
            case '6':
                $fimQuery = " c.`idArm` ";
                $subtitulo = "armazenamento";
                break;
            case '7':
                $fimQuery = " c.`idSO` ";
                $subtitulo = "sistema operacional";
                break;
            case '8':
                $fimQuery = " c.`idProc` ";
                $subtitulo = "processador";
                break;
            default :
                $fimQuery = " c.`id` = ";
                break;
        }
        
        $query = "SELECT"
                . " IF(c.`etiqueta` = 0, 'Não possui', c.`etiqueta`) AS etiqueta,"
                . " IF(c.`tombo` = '0', 'Não possui', c.`tombo`) AS tombo,"
                . " IF(c.`alugado` = '1', 'Sim', 'Não') AS alugado,"
                . " ma.nome AS marca,"
                . " CONCAT_WS(\" \", me.barramento, me.capacidade) AS memoria,"
                . " CONCAT_WS(\" \", ar.tecnologia, ar.capacidade) AS armazenamento,"
                . " CONCAT_WS(\" \", so.nome, so.versao, IF(so.licenca = '1', '*', '')) AS SO,"
                . " CONCAT_WS(\" \", p.fabricante, p.modelo, p.arquitetura) AS processador"
                . " FROM computador c"
                . " INNER JOIN marca ma ON c.idMarca = ma.id"
                . " INNER JOIN memoria me ON c.idMem = me.id"
                . " INNER JOIN armazenamento ar ON c.idArm = ar.id"
                . " INNER JOIN sistema_operacional so ON c.idSO = so.id"
                . " INNER JOIN processador p ON c.idProc = p.id"
                . " WHERE ".$fimQuery." ".$computador
                . " ORDER BY ".$fimQuery." ;";
        
        $corpoTabela = array();
        $conn = conecta();
        $sql = mysqli_query($conn, $query);
        desconecta($conn);
        if($sql){
            while($linha = mysqli_fetch_assoc($sql)){
                $corpoTabela[] = explode("/t", utf8_decode($linha['etiqueta'])."/t".utf8_decode($linha['tombo'])."/t".utf8_decode($linha['alugado'])."/t".$linha['marca']."/t".$linha['memoria']."GB/t".$linha['armazenamento']."GB/t".$linha['SO']."/t".$linha['processador']);
            }
        }
        
        //Título da tabela
        $this->SetFont('Arial','B',12);
        $this->Cell(0,2,utf8_decode('Tabela de computadores'),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,5,utf8_decode('Ordenados por '.$subtitulo),0,0,'C');
        $this->Ln(8);
        
        // Cores, linhas e fonte em negrito
        $this->SetFillColor(0,110,180);//azul bootstrap
        $this->SetTextColor(255);
        $this->SetDrawColor(220,220,220);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','B');
        // Cabeçalho
        $largura = array(17, 17, 17, 20, 25, 28, 41, 38);//Largura de cada coluna - total:203
        for($i=0;$i<count($cabecalho);$i++)
            $this->Cell($largura[$i],7,$cabecalho[$i],1,0,'C',true);
        $this->Ln();
        // Cores e fontes
        $this->SetFillColor(220,220,220);//cor das linhas: cinza claro
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Corpo
        $linhaCinza = false;
        foreach($corpoTabela as $linha){
            $this->Cell($largura[0],6,$linha[0],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[1],6,$linha[1],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[2],6,$linha[2],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[3],6,$linha[3],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[4],6,$linha[4],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[5],6,$linha[5],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[6],6,$linha[6],'LR',0,'C',$linhaCinza);
            $this->Cell($largura[7],6,$linha[7],'LR',0,'C',$linhaCinza);
            $this->Ln();
            $linhaCinza = !$linhaCinza;
        }
        // Linha para fechar
        $this->Cell(array_sum($largura),0,'','T');
    }
    
    function geraTabelaManutencao($criterios, $servico){
        //cabeçalho da tabela
        $cabecalho = array('Etiqueta',utf8_decode('Usuário'), 'Departamento','Entrada',utf8_decode('Saída'),'Problema(s)', 'Procedimento',utf8_decode('Observação'));
        switch($criterios){
            case '1':
                $fimQuery = " c.`etiqueta` ";
                break;
            case '2':
                $fimQuery = " h.usuario ";
                break;
            case '3':
                $fimQuery = " h.departamento ";
                break;
            case '4':
                $fimQuery = " h.dataEntrada ";
                break;
            case '5':
                $fimQuery = " h.dataSaida ";
                break;
            default :
                $fimQuery = " 1 ";
                break;
        }

        $query = "SELECT A.id, A.etiqueta, A.usuario, A.departamento, A.dataEntrada, A.dataSaida, B.proc, B.observacao, B.problemas
                FROM(
                    SELECT c.etiqueta, h.id, h.usuario, h.departamento, h.dataEntrada, h.dataSaida
                    FROM historico h
                    INNER JOIN computador c ON h.idComp = c.id
                    WHERE ".$fimQuery." ".$servico."
                    ORDER BY h.dataEntrada
                ) AS A
                INNER JOIN(
                    SELECT h.id,
                    m.procedimento AS proc, m.observacao,
                    GROUP_CONCAT(p.problema SEPARATOR ', ') AS problemas
                    FROM historico h
                    LEFT JOIN manutencao m ON m.id = h.idManut
                    LEFT JOIN manutencao_problema mp ON mp.idManut = m.id
                    LEFT JOIN problema p ON p.id = mp.idProb
                    WHERE h.idManut IS NOT NULL
                    GROUP BY h.id
                ) AS B
                ON A.id = B.id;";
        $corpoTabela = array();
        $alturaTabela = array();
        $conn = conecta();
        $sql = mysqli_query($conn, $query);
        desconecta($conn);
        
        //Título da tabela
        $this->SetFont('Arial','B',12);
        $this->Cell(0,2,utf8_decode('Tabela de manutenção'),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,5,utf8_decode('serviços de manutenção em computadores '),0,0,'C');
        $this->Ln(8);
        if($sql){
            while($linha = mysqli_fetch_assoc($sql)){
                $alturaLinha[] = (int)floor($this->maiorDosTres($linha['proc'], $linha['problemas'], $linha['observacao']) / 12);
                $corpoTabela[] = explode("/t", utf8_decode($linha['etiqueta'])."/t".utf8_decode($linha['usuario'])."/t".utf8_decode(nomeDepartamento($linha['departamento']))."/t".date("d/m/Y", strtotime($linha['dataEntrada']))."/t".date("d/m/Y", strtotime($linha['dataSaida']))."/t".utf8_decode($linha['problemas'])."/t".utf8_decode($linha['proc'])."/t".utf8_decode($linha['observacao']) );
            }
        }

        // Cores, linhas e fonte em negrito
        $this->SetFillColor(0,110,180);//azul bootstrap
        $this->SetTextColor(255);
        $this->SetDrawColor(220,220,220);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','B');
        // Cabeçalho
        $largura = array(17, 25, 50, 17, 17, 21, 28, 28);//Largura de cada coluna - total: 203
        for($i=0;$i<count($cabecalho);$i++)
            $this->Cell($largura[$i],7,$cabecalho[$i],1,0,'C',true);
        $this->Ln();
        // Cores e fontes
        $this->SetFillColor(220,220,220);//cor das linhas: cinza claro
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Corpo
        $linhaCinza = false;
        $this->SetWidths($largura);
        foreach($corpoTabela as $linha){
            $this->Row($linha, $linhaCinza);
            $linhaCinza = !$linhaCinza;
        }
        
        // Linha para fechar
        $this->Cell(array_sum($largura),1,'','T');
    }
    
    function geraTabelaHistorico($criterios, $historico){
        //cabeçalho da tabela
        $cabecalho = array('Etiqueta',utf8_decode('Usuário'), 'Departamento','Entrada',utf8_decode('Saída'),'Tipo',utf8_decode('Descrição'));
        switch($criterios){
            case '1':
                $fimQuery = " c.`etiqueta` ";
                break;
            case '2':
                $fimQuery = " h.usuario ";
                break;
            case '3':
                $fimQuery = " h.departamento ";
                break;
            case '4':
                $fimQuery = " h.dataEntrada ";
                break;
            case '5':
                $fimQuery = " h.dataSaida ";
                break;
            default :
                $fimQuery = " c.`etiqueta` = -1 ";
                break;
        }

        $query = "SELECT A.id, A.departamento, A.usuario, A.dataEntrada, A.dataSaida,
                    IF(A.descricao = '', B.descricao, A.descricao) AS descricao,
                    A.tipo, A.etiqueta
                    FROM (
                        SELECT h.id, h.departamento, h.usuario, h.dataEntrada, h.dataSaida,
                        h.descricao,
                        IF(h.idManut IS NULL, 'outro', 'manutenção') AS tipo,
                        c.etiqueta
                        FROM historico h
                        INNER JOIN computador c ON  c.id = h.idComp 
                        WHERE ".$fimQuery." ".$historico."
                        ORDER BY ".$fimQuery."
                        ) AS A
                    LEFT JOIN(
                            SELECT h.id,
                        IF(h.idManut IS NULL, '', m.procedimento) AS descricao
                        FROM historico h 
                        INNER JOIN manutencao m ON h.idManut = m.id
                        WHERE 1
                    ) AS B
                    ON A.id = B.id;";
        $corpoTabela = array();
        $alturaLinha = array();
        $conn = conecta();
        $sql = mysqli_query($conn, $query);
        desconecta($conn);        
        //Título da tabela
        $this->SetFont('Arial','B',12);
        $this->Cell(0,2,utf8_decode('Histórico do computador'),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,5,utf8_decode('serviços de manutenção em computadores, deslocamento de departamento, etc...'),0,0,'C');
        $this->Ln(8);
        
        if($sql){
            while($linha = mysqli_fetch_assoc($sql)){
                $alturaLinha[] = (int)floor(strlen($linha['descricao']) / 30);
                $corpoTabela[] = explode("/t", utf8_decode($linha['etiqueta'])."/t".utf8_decode($linha['usuario'])."/t".utf8_decode(nomeDepartamento($linha['departamento']))."/t".date("d/m/Y", strtotime($linha['dataEntrada']))."/t".date("d/m/Y", strtotime($linha['dataSaida']))."/t".utf8_decode($linha['tipo'])."/t". utf8_decode($linha['descricao']) );
            }
        }

        // Cores, linhas e fonte em negrito
        $this->SetFillColor(0,110,180);//azul bootstrap
        $this->SetTextColor(255);
        $this->SetDrawColor(220,220,220);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','B');
        // Cabeçalho
        $largura = array(17, 25, 60, 17, 17, 18, 46);//Largura de cada coluna - total: 200
        for($i=0;$i<count($cabecalho);$i++)
            $this->Cell($largura[$i],7,$cabecalho[$i],1,0,'C',true);
        $this->Ln();
        // Cores e fontes
        $this->SetFillColor(220,220,220);//cor das linhas: cinza claro
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Corpo
        $linhaCinza = false;
        $this->SetWidths($largura);
        foreach($corpoTabela as $linha){
            $this->Row($linha, $linhaCinza);
            $linhaCinza = !$linhaCinza;
        }
        // Linha para fechar
        $this->Cell(array_sum($largura),0,'','T');
    }
    
    function geraGrafico($imagens){
        $y = $this->GetY();
        $y -= 20;
        if(($y + 45) > $this->GetPageHeight()){
            $this->AddPage();
            $y = 45;
        }
        //Título da sessão
        $this->SetFont('Arial','B',12);
        $this->Cell(0,2,utf8_decode('Gráficos'),0,0,'C');
        $this->Ln(5);
        
        //Busca a quantidade de computadores cadastrados
        $query = "SELECT COUNT(id) AS id FROM computador";
        $conn = conecta();
        $sql = mysqli_query($conn, $query);
        desconecta($conn);
        while($resultado = mysqli_fetch_assoc($sql)){
            $id = $resultado['id'];
        }
        
        $this->SetFont('Arial','B',8);
        $this->Cell(0,2,utf8_decode('Estatísticas feitas considerando todos os computadores cadastrados. ('.$id.' máquinas)'),0,0,'C');
        $this->Ln(8);
        $y += 40;
        $x = 5;
        
        foreach ($imagens as $imagem){
            if(($y + 45) > $this->GetPageHeight()){
                $this->AddPage();
                $y = 25;
            }
            $this->Image($imagem, $x, $y, 90, 40, "PNG");
            if($x === 5){
                $x = 105;
            }else{
                $this->Ln(10);
                $x = 5;
                $y += 50;
            }
        }
    }
    
    function maiorDosTres($a, $b, $c){
        $ta = strlen($a);
        $tb = strlen($b);
        $tc = strlen($c);
        return ($ta > $tb) ? ($ta > $tc ? $ta : $tc) : ($tb > $tc ? $tb : $tc);
    }
    
    function diferencaProMaior($a, $b, $c){
        //echo "Maior dos três:".$this->maiorDosTres($a, $b, $c)."<br>";
        $numLinhas = array(); //número de linhas que cada campo da tabela precisará
        $numLinhas[] = $a == ""? 0 : ceil($this->maiorDosTres($a, $b, $c) / strlen($a) +1); //função ceil arredonda para cima
        $numLinhas[] = $b == ""? 0 : ceil($this->maiorDosTres($a, $b, $c) / strlen($b) +1); //para lidar com o resto das divisões
        $numLinhas[] = $c == ""? 0 : ceil($this->maiorDosTres($a, $b, $c) / strlen($c) +1);
        $maiorNumLinhas = $numLinhas;
        sort($maiorNumLinhas);
        $retorno = [0=>"\n",1=>"\n",2=>"\n"];
        for($i=0; $i<3; $i++){
            //echo "Maior tamanho: ".$maiorNumLinhas[2].", Linha ".$i.": ".$numLinhas[$i]."<br>";
            for($j=0; $j < ($maiorNumLinhas[2] - $numLinhas[$i]); $j++){
                $retorno[$i] .= "\n";
            }
            //echo $retorno[$i]."<br>";
        }
        
        return $retorno;
    }
}