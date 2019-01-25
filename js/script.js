function fechaModal(id) {
    var modal = window.document.getElementById(id);
    modal.innerHTML = "";
    modal.style.display = "none";
}

function modal(numero, id){
    var modal = window.document.getElementById("modalCadastro");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            modal.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../computador/modalForm.php?numero=" + numero + "&id=" + id, true);
    xhttp.send();
    
    modal.style = "display: block !important;";
}

function modalManutencao(numero){
    var modal = window.document.getElementById("modalManutencao");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            modal.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../manutencao/modalManut.php?numero=" + numero, true);
    xhttp.send();
    
    modal.style = "display: block !important;";
}

function detalheManutencao(id, principal){
    var modal = window.document.getElementById("modalPrincipal");
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            modal.innerHTML = this.responseText;
        }
    };
    if(principal){
        xhttp.open("GET", "detalheManutencao.php?id="+id, true);
    }else{
        xhttp.open("GET", "../detalheManutencao.php?id="+id, true);
    }
    
    xhttp.send();
    
    modal.style = "display: block !important;";
}

function detalheHistorico(id, principal){
    var modal = window.document.getElementById("modalPrincipal");
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            modal.innerHTML = this.responseText;
        }
    };
    if(principal){
        xhttp.open("GET", "detalheHistorico.php?id="+id, true);
    }else{
        xhttp.open("GET", "../detalheHistorico.php?id="+id, true);
    }
    xhttp.send();
    
    modal.style = "display: block !important;";
}

function editarUsuario(id, principal){
    var modal = window.document.getElementById("modalPrincipal");
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            modal.innerHTML = this.responseText;
        }
    };
    
    if(principal){
        xhttp.open("GET", "./usuario/editarUsuario.php?id="+id, true);
    }else{
        xhttp.open("GET", "../usuario/editarUsuario.php?id="+id, true);
    }
    xhttp.send();
    
    modal.style = "display: block !important;";
}

function liberaSenha(){
    var check = window.document.getElementById("checkSenha").checked;
    if(check){
        $('#senhaUsuario').removeAttr('disabled');
    }else{
        $('#senhaUsuario').attr('disabled','disabled');
    }
    
}

function mudaForm(){
    var divComp = window.document.getElementById("cadastroComputador");
    var divServ = window.document.getElementById("cadastroServico");
    if(divComp.style.display === "none"){
        divComp.style.display = "block";
        divComp.setAttribute("class","col-sm-5");
        divServ.setAttribute("class","col-sm-7");
    }else{
        divComp.style.display = "none";
        divComp.setAttribute("class","");
        divServ.setAttribute("class","col-lg-12");
    }
}

function procuraComputador(str) {
    var descricao = document.getElementById("descricao");
    if (str.length === 0) {
        descricao.style = "visibility: hidden";
        descricao.innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                if(this.responseText !== ""){
                    descricao.innerHTML = this.responseText;
                    descricao.style = "visibility: visible";
                }
            }
        };
        xmlhttp.open("GET", "../manutencao/buscaComputador.php?etiqueta=" + str, true);
        xmlhttp.send();
        adicionaUsDepto(str);
    }
}

function adicionaUsDepto(str){
    var campoUsuario = window.document.getElementsByName("usuario")[0];
    
    $.getJSON("../funcoes/buscaUsDepto.php?etiqueta="+str, function(data) {
        
        campoUsuario.value = data[0];
        var opcoes = window.document.getElementsByTagName("option");
        for (i = 0; i < opcoes.length; i++){
            if(opcoes[i].value === data[1]){
                opcoes[i].selected = "selected";
            }
        }
    });
}

function adicionaProblema(){
    var idProblema = window.document.getElementById('selectProblemas').value.toString();
    if(idProblema !== '0'){
        var problemasBody = window.document.getElementById('problemasBody');
        var tr = window.document.createElement("tr");
        var tdID = window.document.createElement("td");
        var tdNome = window.document.createElement("td");
        var tdExclui = window.document.createElement("td");
        var input = window.document.createElement("input");
        var botaoExclui = window.document.createElement("a");

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                tdNome.innerHTML = this.responseText+"&nbsp;";
            }
        };
        xmlhttp.open("GET", "../manutencao/addProblema.php?id=" + idProblema, true);
        xmlhttp.send();

        window.document.getElementById('problemas').style.visibility = "visible";
        botaoExclui.innerHTML = "<i class='glyphicon glyphicon-remove remover' onclick='excluiProblema("+idProblema+");'></i>";

        tdExclui.appendChild(botaoExclui);

        input.setAttribute("value", idProblema);
        input.setAttribute("type","text");
        input.setAttribute("name","prob[]");

        tdID.setAttribute("style","display: none;");
        tdID.appendChild(input);

        tr.id = idProblema;
        tr.appendChild(tdNome);
        tr.appendChild(tdID);
        tr.appendChild(tdExclui);
        problemasBody.appendChild(tr);
    }
}

//Para remover as linhas na tabela de problemas
function excluiProblema(id){
    var linha = document.getElementById(id); 
    var body = document.getElementById('problemasBody');
    body.removeChild(linha);
    if(body.innerHTML === ""){
        document.getElementById('problemas').style.visibility = "hidden";
    }
}

//Para os botões dropdown do aside
$(document).ready(function(){
    $(".aside-dropdown").click(function(){
        $(this.getElementsByClassName("aside-dropdown-container")[0]).toggle();
    });
});

function marcaNao(){
    var radioButon = window.document.getElementById("nao");
    radioButon.checked = "checked";
}

function desabilitaTombo(){
    var inputTombo = window.document.getElementsByName("tombo")[0];
    inputTombo.value = "";
    inputTombo.disabled = "disabled";
}

function habilitaTombo(){
    var inputTombo = window.document.getElementsByName("tombo")[0];
    $(inputTombo).removeAttr("disabled");
}