<?php
include_once '../funcoes/conection.php';
function avisoHistorico($etiqueta){
    ?>
<script>
$(document).ready(function(){
    $('#alerta-historico').show(function(){
        $('#alerta-historico').fadeIn(1000);
        $('#alerta-historico').delay(4000).fadeOut(1000);
    });
});
</script>
<div id="alerta-historico" class="alert alert-warning alerta-sucesso">
    Não existe computador cadastrado no sistema com a etiqueta <strong><?php echo $etiqueta;?></strong>
</div>
    <?php
}

