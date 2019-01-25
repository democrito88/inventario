<?php
include '../funcoes/Corpo.php';
cabecalho();
if($_SESSION['id'] !== "1"){
    echo "<script>window.location.replace('../principal.php?flag=14');</script>";
}
?>
    <div id="modalCadastro" class="modalFundo"></div>
    <section class="sessaoFormulario">
        <button class="btn btn-primary" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button><br/>
        <h3>Cadastre um novo usuário</h3>
        <form id="cadastrousuario" action="cadastrarUsuario.php" method="post">
            <label>Nome</label>
            <input type="text" name="nome" required><br/>
            <label>Login</label>
            <input type="text" name="login" required><br/>
            <label>Senha</label>
            <input type="password" name="senha" required><br/>
            <input class="btn btn-success" type="submit" value="Cadastrar">
        </form>
    </section>
<?php
rodape();