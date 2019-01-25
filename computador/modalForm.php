<?php
include '../funcoes/validar.php';
if(isset($_GET['numero']) && isset($_GET['id'])){
    $numero = antiInjection($_GET['numero']) != false? "": $_GET['numero'];
    $id = antiInjection($_GET['id']) != false? "" : $_GET['id'];
}else{
    throw new Exception("<h4>parâmetros inválidos</h4>");
}

$conteudoForm = "";
switch($numero){
    case '1':
        $conteudoForm = novaMarca();
        break;
    case '2':
        $conteudoForm = novaMemoria();
        break;
    case '3':
        $conteudoForm = novoProcessador();
        break;
    case '4':
        $conteudoForm = novoArmazenamento();
        break;
    case '5':
        $conteudoForm = novoSO();
        break;
    default:
        break;
}

echo "
    <p class=\"fechar\" onclick=\"fechaModal('modalCadastro');\">&times;</p>
    <div class=\"panel panel-primary modalCadastro\">
            ".$conteudoForm."
            <input name='id' value='".$id."' style='display: none;'>
            <input class=\"btn btn-success\" type=\"submit\" value=\"cadastrar\">
        </form>
      </div>
    </div>";

function novaMarca(){
   return "<div class=\"panel-heading\">Cadastre uma nova marca</div>
      <div class=\"panel-body\">
          <form action=\"../computador/cadastrarComputador.php\" method=\"POST\">
          <input type=\"texto\" name=\"n\" value=\"1\" style=\"display: none;\">
          <label>Nome</label><input type=\"text\" name=\"nome\" required><br/><br/>";
}

function novaMemoria(){
   return "<div class=\"panel-heading\">Cadastre uma nova memória</div>
      <div class=\"panel-body\">
          <form action=\"../computador/cadastrarComputador.php\" method=\"POST\">
          <input type=\"texto\" name=\"n\" value=\"2\" style=\"display: none;\">
          <label>Barramento</label><input type=\"text\" name=\"barramento\" placeholder=\"DDR1, DDR2, DDR3...\" required><br/>"
    . "<label>Capacidade</label><input type=\"text\" name=\"capacidade\" required>GB<br/><br/>";
}

function novoProcessador(){
   return "<div class=\"panel-heading\">Cadastre um novo processador</div>
      <div class=\"panel-body\">
          <form action=\"../computador/cadastrarComputador.php\" method=\"POST\">
          <input type=\"texto\" name=\"n\" value=\"3\" style=\"display: none;\">
          <label>Arquitetura</label><input type=\"text\" name=\"arquitetura\" placeholder=\"32 ou 64bits?\" required>bits<br/>"
    . "<label>Modelo</label><input type=\"text\" name=\"modelo\" required><br/>"
           . "<label>Fabricante</label><input type=\"text\" name=\"fabricante\" required><br/><br/>";
}

function novoArmazenamento(){
   return "<div class=\"panel-heading\">Cadastre um novo dispositivo de armazenamento</div>
      <div class=\"panel-body\">
          <form action=\"../computador/cadastrarComputador.php\" method=\"POST\">
          <input type=\"texto\" name=\"n\" value=\"4\" style=\"display: none;\">
          <label>Tecnologia</label><input type=\"text\" name=\"tecnologia\" placeholder=\"HD ou SSD?\" required><br/>"
    . "<label>Capacidade</label><input type=\"text\" name=\"capacidade\" required>GB<br/><br/>";
}

function novoSO(){
   return "<div class=\"panel-heading\">Cadastre um novo sistema operacional</div>
      <div class=\"panel-body\">
          <form action=\"../computador/cadastrarComputador.php\" method=\"POST\">
          <input type=\"texto\" name=\"n\" value=\"5\" style=\"display: none;\">
          <label>Nome</label><input type=\"text\" name=\"nome\" required><br/>
          <label>Licença</label><select name=\"licenca\">
                                    <option value='0'>Não precisa</option>
                                    <option value='1'>Não</option>
                                    <option value='2'>Sim</option>
                                </select><br/>"
           . "<label>Versão</label><input type=\"text\" name=\"versao\" required><br/><br/>";
}