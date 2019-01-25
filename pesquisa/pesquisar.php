<?php
include_once '../funcoes/Corpo.php';
cabecalho();
?>
<script src="../js/pesquisa.js"></script>
<script>
let observer;
        
document.addEventListener('DOMContentLoaded', init);

function init(){
    let session = document.getElementById("sessaoGrafico");
    session.addEventListener('DOMSubtreeModified', change);

    let config = {
        attributes: true, 
        attributeOldValue: true,
        attributeFilter: ['style'],
        childList: false, 
        subtree: false, 
        characterData: false,
        characterDataOldValue: false
    };

    observer = new MutationObserver(mutated);//inicializa o observador de mutações
    observer.observe(session, config);//ela observará mudanças na <section id='sessaoGrafico'>
}

function change(){
    //let session = ev.currentTarget;
    
    let ps = document.getElementsByClassName("remover"); //todos os p's que possuem essa classe
    let usuario = document.getElementsByClassName("dropdown-toggle")[0].innerHTML;
    
    for(i=0, len = ps.length; i < len; i++){
        if(usuario.includes("Administrador")){
            ps[i].setAttribute("style", "visibility: visible;");
        }else{
            ps[i].setAttribute("style", "visibility: hidden;");
        }
    }
}

function mutated(mutationList){
    console.log( mutationList );
    for(let mutation of mutationList) {
        if (mutation.type == 'childList') {
            console.log('Foi adicionado ou removido um nó');
        }
        else if (mutation.type == 'attributes') {
            console.log('O atributo ' + mutation.attributeName + ' foi modificado.');
            console.log( mutation.oldValue );
        }
    }
observer.disconnect();
}
</script>
<section id="sessaoSelecao" class="sessaoSelecao">
    
    <h3>Pesquise computadores e serviços</h3>
    <button class="btn btn-default botaoVoltar" onclick="window.location.replace('../principal.php')"><i class="glyphicon glyphicon-circle-arrow-left"></i>&nbsp;Voltar</button>
    <select id="selectPesquisar" onchange="pesquisarCategoria();">
        <option selected>escolha uma categoria</option>
        <option value="1">Computador</option>
        <option value="2">Serviço</option>
        <option value="3">Gráficos</option>
    </select>
</section>
<section id="sessaoGrafico" style="width: 100%; height: 90%; padding: 5% 8%; align-content: center; text-align: center; display: inline-block;">
</section>
    <?php
rodape();

