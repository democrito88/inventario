<?php
include '../funcoes/validar.php';
if(isset($_GET['numero'])){
    $numero = antiInjection($_GET['numero']) != false? "": $_GET['numero'];
}else{
    throw new Exception("<h4>parâmetros inválidos</h4>");
}

$conteudoForm = "";
switch($numero){
    case '1':
        $conteudoForm = novoProblema();
        break;
    default:
        break;
}

echo "
    <p class=\"fechar\" onclick=\"fechaModal('modalManutencao');\">&times;</p>
    <div class=\"panel panel-primary modalCadastro\">
            ".$conteudoForm."
            <input type='text' name='n' value='1' style='display: none;'>
            <input class=\"btn btn-success\" type=\"submit\" value=\"cadastrar\">
        </form>
      </div>
    </div>";

function novoProblema(){
   return "<div class=\"panel-heading\">Cadastre um novo problema</div>
      <div class=\"panel-body\">
          <form action=\"cadastrarManutencao.php\" method=\"POST\">
          <label>Nome</label><input type=\"text\" name=\"problema\" required><br/><br/>";
}