<?php
include_once '../funcoes/Corpo.php';
include_once '../funcoes/validar.php';
include_once '../funcoes/conection.php';
include_once '../funcoes/funcoesAvisos.php';
cabecalho();

if($_SESSION['id'] !== "1"){
    echo "<script>window.location.replace('../principal.php?flag=14');</script>";
}

if(isset($_GET['flag'])){
    mostraAviso($_GET['flag']);
}

$query1 = "SELECT `id`, `nome`, `login` FROM `usuario`";
//echo "Total: ".$total."<br>Por páginas:".$resultadosPPaginas."<br>Páginas: ".$paginas."<br>Pág. atual: ".$pagAtual;
?>
<section style="margin: 5% 8%; text-align: center;">
    <button class="btn btn-primary botaoVoltar" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button>
    <h3>Lista de usuários</h3>
    <table class="table table-hover principalTabela" style="width: 50%; margin: auto;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Login</th>
                <th></th><th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = conecta();
            $requisicao = mysqli_query($conn, $query1);
            desconecta($conn);
            if($requisicao != FALSE){
                if(mysqli_num_rows($requisicao) == 0){
                    echo "<tr><td><p class='alert alert-warning'>Não foram encontradas entradas no banco de dados</p></td></tr>";
                }else{
                    while($tupla = mysqli_fetch_assoc($requisicao)){
                        echo "<tr><td>".utf8_encode($tupla['nome'])."</td>"
                                . "<td>".$tupla['login']."</td>"
                                . "<td><a title='Editar' class='glyphicon glyphicon-edit editar' onclick=\"editarUsuario('".$tupla['id']."', false);\"></a></td>";
                        if($tupla['id'] != '1'){
                            echo "<td><p class='glyphicon glyphicon-remove remover'><span class=\"tooltiptext\">Remover?<br/><br/><a class='btn btn-danger' href='removerUsuario.php?id=".$tupla['id']."'>Sim</a></span></p></td></tr>";
                        } 
                    }
                }
            }else{
                echo "<tr><td><p class='alert alert-danger'>Houve algum problema com o banco de dados. Consulte o administrador</p></td></tr>";
            }
            ?>
        </tbody>
        <tfoot><tr><td></td><td></td><td></td><td><button class="btn btn-primary" onclick="window.location.replace('novoUsuario.php')"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;Adicionar novo</button></td></tr></tfoot>
    </table>
</section>
<?php
rodape();
