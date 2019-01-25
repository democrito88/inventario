<?php
include "../funcoes/conection.php";
include '../funcoes/validar.php';
$conn = conecta();

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    antiInjection($_GET['id']) === true ? header("Location: index.php") : $id = $_GET['id'];
}else{
    throw new Exception("<h4>Parâmetros Inválidos</h4>");
}
$query = "SELECT * FROM usuario WHERE id = ".$id;
$sql = mysqli_query($conn, $query);
desconecta($conn);
$painel = "<p class=\"fechar\" onclick=\"fechaModal('modalPrincipal');\">&times;</p>
    <div class=\"panel panel-primary modalPrincipal\" style=\"width:30%;\">
        <div class=\"panel-heading\">Edite dados de usuário</div>
        <div class=\"panel-body\" style=\"padding: 5%;\">
           <form action='./usuario/atualizaUsuario.php' method='POST'>
           <input type='text' name='adm' value='".$_SESSION['id']."' style='display:none;'>";
       
        while ($resultado = mysqli_fetch_assoc($sql)){
            $painel .= '<label>Nome:&nbsp;</label><input type="text" name="nome" value="'. utf8_encode($resultado['nome']).'" style="width:85%;" required><br><br>'
                    . '<label>Login:&nbsp;</label><input type="text" name="login" value="'.$resultado['login'].'" required><br><br>'
                    . '<label><input id="checkSenha" type="checkbox" onclick="liberaSenha();">&nbsp;Alterar senha?&nbsp</label><br>'
                    . '<input id="senhaUsuario" type="password" name="senha" disabled><br><br>'
                    . '<input type="text" name="id" value="'.$id.'" style="display: none;">'
                    . '<input class="btn btn-success" type="submit" value="Salvar">';
        }
        
$painel .=
      "     </form>
          </div>
    </div>";

echo $painel;