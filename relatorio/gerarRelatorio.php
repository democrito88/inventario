<?php
session_reset();
//include_once '../funcoes/validar.php';
include_once './relatorio.php';
$teste = "Hey! ";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['etiquetaC'])){
        $computador = !antiInjection($_POST['etiquetaC'])? " = ".$_POST['etiquetaC'] : NULL;
        $criterioC = 1;
    }elseif (isset($_POST['marca'])) {
        $computador = !antiInjection($_POST['marca'])? " = ".$_POST['marca'] : NULL;
        $criterioC = 2;
    }elseif (isset($_POST['tombo'])) {
        $computador = !antiInjection($_POST['tombo'])? " = ".$_POST['tombo'] : NULL;
        $criterioC = 3;
    }elseif (isset($_POST['sim'])) {
        $computador = !antiInjection($_POST['sim'])? " = 1" : NULL;
        $criterioC = 4;
    }elseif (isset($_POST['nao'])) {
        $computador = !antiInjection($_POST['nao'])? " = 0" : NULL;
        $criterioC = 4;
    }elseif (isset($_POST['memoria'])) {
        $computador = !antiInjection($_POST['memoria'])? " = ".$_POST['memoria'] : NULL;
        $criterioC = 5;
    }elseif (isset($_POST['armazenamento'])) {
        $computador = !antiInjection($_POST['armazenamento'])? " = ".$_POST['armazenamento'] : NULL;
        $criterioC = 6;
    }elseif (isset($_POST['SO'])) {
        $computador = !antiInjection($_POST['SO'])? " = ".$_POST['SO'] : NULL;
        $criterioC = 7;
    }elseif (isset($_POST['processador'])) {
        $computador = !antiInjection($_POST['processador'])? " = ".$_POST['processador'] : NULL;
        $criterioC = 8;
    }
    
    if(isset($_POST['etiquetaM'])){
        $servico = !antiInjection($_POST['etiquetaM'])? " = ".$_POST['etiquetaM'] : NULL;
        $criterioS = 1;
    }elseif (isset($_POST['usuarioM'])) {
        $servico = !antiInjection($_POST['usuarioM'])? " = '".$_POST['usuarioM']."'" : NULL;
        $criterioS = 2;
    }elseif (isset($_POST['departamentoM'])) {
        $servico = !antiInjection($_POST['departamentoM'])? " = ".$_POST['departamentoM'] : NULL;
        $criterioS = 3;
    }elseif (isset($_POST['dataEntradaInicialM']) && isset($_POST['dataEntradaFinalM'])) {
        $servico = !antiInjection($_POST['dataEntradaInicialM'])? " BETWEEN '".$_POST['dataEntradaInicialM']."'" : "";
        $servico .= !antiInjection($_POST['dataEntradaFinalM'])? " AND '".$_POST['dataEntradaFinalM']."'" : "";
        $criterioS = 4;
    }elseif (isset($_POST['dataSaidaInicialM']) && isset($_POST['dataSaidaFinalM'])) {
        $servico = !antiInjection($_POST['dataSaidaInicialM'])? " BETWEEN '".$_POST['dataSaidaInicialM']."'" : NULL;
        $servico .= !antiInjection($_POST['dataSaidaFinalM'])? " AND '".$_POST['dataSaidaFinalM']."'" : NULL;
        $criterioS = 5;
    }
    
    if(isset($_POST['etiquetaH'])){
        $historico = !antiInjection($_POST['etiquetaH'])? " = ".$_POST['etiquetaH'] : NULL;
        $criterioH = 1;
    }elseif (isset($_POST['usuarioH'])) {
        $historico = !antiInjection($_POST['usuarioH'])? " = '".$_POST['usuarioH']."'" : NULL;
        $criterioH = 2;
    }elseif (isset($_POST['departamentoH'])) {
        $historico = !antiInjection($_POST['departamentoH'])? " = ".$_POST['departamentoH'] : NULL;
        $criterioH = 3;
    }elseif (isset($_POST['dataEntradaInicialH']) && isset($_POST['dataEntradaFinalH'])) {
        $historico = !antiInjection($_POST['dataEntradaInicialH'])? " BETWEEN '".$_POST['dataEntradaInicialH']."'" : "";
        $historico .= !antiInjection($_POST['dataEntradaFinalH'])? " AND '".$_POST['dataEntradaFinalH']."'" : "";
        $criterioH = 4;
    }elseif (isset($_POST['dataSaidaInicialH']) && isset($_POST['dataSaidaFinalH'])) {
        $historico = !antiInjection($_POST['dataSaidaInicialH'])? " BETWEEN '".$_POST['dataSaidaInicialH']."'" : NULL;
        $historico .= !antiInjection($_POST['dataSaidaFinalH'])? " AND '".$_POST['dataSaidaFinalH']."'" : NULL;
        $criterioH = 5;
    }
    
    if(isset($_POST['graficos']) && !is_null($_POST['graficos'][0])){
        $_SESSION['computador'] = isset($computador)? $computador : "";
        $_SESSION['criterioC'] = isset($criterioC)? $criterioC : "";
        $_SESSION['servico'] = isset($servico)? $servico : "";
        $_SESSION['criterioS'] = isset($criterioS)? $criterioS : "";
        $_SESSION['historico'] = isset($historico)? $historico : "";
        $_SESSION['criterioH'] = isset($criterioH)? $criterioH : "";
        $_SESSION['graficos'] = $_POST['graficos'];
        //$valoresGET = "?computador=".$computador."&criterioC=".$criterioC."&servico=".$servico."&criterioS=".$criterioS."&historico=".$historico."&criterioH=".$criterioH;
        header("Location: graficos.php");
    }
    
    if(isset($_POST['criterioC']) && (intval($_POST['criterioC']) <= 8) ){//significa que foi redirecionado para gerarRelatrio.php
        $computador = isset($_POST['computador'])? $_POST['computador'] : " ";
        $criterioC = isset($_POST['criterioC'])? $_POST['criterioC'] : " ";
        $servico = isset($_POST['servico'])? $_POST['servico'] : " ";
        $criterioS = isset($_POST['criterioS'])? $_POST['criterioS'] : " ";
        $historico = isset($_POST['historico'])? $_POST['historico'] : " ";
        $criterioH = isset($_POST['criterioH'])? $_POST['criterioH'] : " ";
    }
    
    // Testando a geração de PDF
    $pdf = new Relatorio();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetLeftMargin(4);
    $pdf->SetFont('Arial','',15);
    $pdf->Cell(0,0,utf8_decode('Relatório'),0,1,'C');
    $pdf->Ln(8);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,8,'Data: '. date("d/m/Y"),0,1,'C');
    $pdf->Ln(8);
    $pdf->SetFont('Arial','',8);
    
    $pdf->Ln(10);
    if(isset($criterioC) && (intval($criterioC) < 9 && intval($criterioC) > 0) ){
        $pdf->geraTabelaComputador($criterioC, $computador);
        $pdf->Ln(10);
    }
    if(isset($criterioS) && (intval($criterioS) < 6 && intval($criterioS) > 0)){
        $pdf->geraTabelaManutencao($criterioS, $servico);
        $pdf->Ln(10);
    }
    if(isset($criterioH) && (intval($criterioH) < 6 && intval($criterioH) > 0)){
        $pdf->geraTabelaHistorico($criterioH, $historico);
        $pdf->Ln(10);
    }
    
    if(isset($_POST['imagem'])){// imagem é uma informação provida de gráficos.php
        $pdf->geraGrafico($_POST['imagem']);
    }
    $pdf->Output();
}