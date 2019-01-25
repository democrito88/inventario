function pesquisarCategoria(){
    var select = window.document.getElementById("selectPesquisar");
    var valor = select.options[select.selectedIndex].value;
    if(valor == 1){
        $("select").remove("#pesquisarServicoPor");
        $("select").remove("#pesquisarGraficoPor");
        $("form").remove("#formularioPesquisa");
        pesquisarComputador();
    }else if(valor == 2){
        $("select").remove("#pesquisarComputadorPor");
        $("select").remove("#pesquisarGraficoPor");
        $("form").remove("#formularioPesquisa");
        pesquisarServico();
    }else if(valor == 3){
        window.document.location.replace("mostraGraficos.php");
    }
}

//Pesquisa de Computadores
function pesquisarComputador(){
    var select = window.document.createElement("select");
    var optionPadrao = window.document.createElement("option");
    var optionTombo = window.document.createElement("option");
    var optionEtiqueta = window.document.createElement("option");
    var optionAlugado = window.document.createElement("option");
    var optionArm = window.document.createElement("option");
    var optionMarca = window.document.createElement("option");
    var optionMemoria = window.document.createElement("option");
    var optionSO = window.document.createElement("option");
    var optionProc = window.document.createElement("option");
    
    optionPadrao.innerHTML = "pesquisar...";
    optionTombo.innerHTML = "por tombo";
    optionEtiqueta.innerHTML = "por etiqueta";
    optionAlugado.innerHTML = "se é alugado";
    optionArm.innerHTML = "por capacidade de armazenamento";
    optionMarca.innerHTML = "por marca";
    optionMemoria.innerHTML = "por memória RAM";
    optionSO.innerHTML = "por sistema operacional";
    optionProc.innerHTML = "por processador";
    
    select.setAttribute("id","pesquisarComputadorPor");
    select.setAttribute("onchange","formulario(this.value, true);");
    optionPadrao.setAttribute("value", "0");
    optionPadrao.setAttribute("selected","selected");
    optionTombo.setAttribute("value", "1");
    optionEtiqueta.setAttribute("value", "2");
    optionAlugado.setAttribute("value", "3");
    optionArm.setAttribute("value", "4");
    optionMarca.setAttribute("value", "5");
    optionMemoria.setAttribute("value", "6");
    optionSO.setAttribute("value", "7");
    optionProc.setAttribute("value", "8");
    
    select.appendChild(optionPadrao);
    select.appendChild(optionTombo);
    select.appendChild(optionEtiqueta);
    select.appendChild(optionAlugado);
    select.appendChild(optionArm);
    select.appendChild(optionMarca);
    select.appendChild(optionMemoria);
    select.appendChild(optionSO);
    select.appendChild(optionProc);
    
    window.document.getElementById("sessaoSelecao").appendChild(select);
}

function formulario(num, computador){
    removeFormulario();
    var formul = window.document.createElement("form");
    var button = window.document.createElement("input");
    
    formul.setAttribute("id","formularioPesquisa");
    button.setAttribute("onclick","mostraPesquisa("+computador+");");
    formul.setAttribute("method","POST");
    button.setAttribute("type","button");
    button.setAttribute("class","btn btn-success");
    button.setAttribute("value","pesquisar");
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        formul.innerHTML = this.responseText;
        formul.appendChild(button);
      }
    };
    xhttp.open("GET", "../pesquisa/completaForm.php?select="+num, true);
    xhttp.send();
    
    window.document.getElementById("sessaoSelecao").appendChild(formul);
}

function removeFormulario(){
    $("form").remove("#formularioPesquisa");
}

function mostraPesquisa(computador){
    var elementos = window.document.getElementById("formularioPesquisa").elements;
    var sessao = window.document.getElementById("sessaoGrafico");
    var parametrosString = "";
    
    for(i=0; i < (elementos.length - 1); i++){
        parametrosString += elementos[i].name+"="+elementos[i].value;
        
        if(i !== (elementos.length - 2)){
            parametrosString += "&";
        }
    }
    
    if(elementos[0].name === "alugado" && elementos[0].checked){
        parametrosString = "alugado=1";
    }else if (elementos[1].name === "alugado" && elementos[1].checked) {
        parametrosString = "alugado=0";
    }

    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) { 
            sessao.innerHTML = this.responseText;
        }
    };
    
    if(computador){
        xhttp.open("POST", "../pesquisa/mostraPesquisaComputadores.php", true);
    }else{
        xhttp.open("POST", "../pesquisa/mostraPesquisaServico.php", true);
    }
    
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parametrosString);
}
//Fim pesquisa de Computadores

//Pesquisa de Serviço
function pesquisarServico(){
    var select = window.document.createElement("select");
    var optionPadrao = window.document.createElement("option");
    var optionComp = window.document.createElement("option");
    var optionUsuario = window.document.createElement("option");
    var optionDepartamento = window.document.createElement("option");
    var optionEntrada = window.document.createElement("option");
    var optionSaida = window.document.createElement("option");
    
    select.setAttribute("id","pesquisarServicoPor");
    select.setAttribute("onchange","formulario(this.value, false);");
    optionPadrao.setAttribute("value","0");
    optionComp.setAttribute("value","9");
    optionUsuario.setAttribute("value","10");
    optionDepartamento.setAttribute("value","11");
    optionEntrada.setAttribute("value","12");
    optionSaida.setAttribute("value","13");
    
    optionPadrao.innerHTML = "pesquisar...";
    optionComp.innerHTML = "por etiqueta do computador";
    optionUsuario.innerHTML = "por usuário";
    optionDepartamento.innerHTML = "por departamento";
    optionEntrada.innerHTML = "por data de entrada";
    optionSaida.innerHTML = "por data de saída";
    
    select.appendChild(optionPadrao);
    select.appendChild(optionComp);
    select.appendChild(optionUsuario);
    select.appendChild(optionDepartamento);
    select.appendChild(optionEntrada);
    select.appendChild(optionSaida);
    
    window.document.getElementById("sessaoSelecao").appendChild(select);
}
//Fim pesquisa de Serviços

//Gráficos
function mostraGrafico(){
    var select = window.document.getElementById("selectGraficoPor");
    var valor = select.options[select.selectedIndex].value;
    window.location.replace("mostraGraficos.php?grafico="+valor);
}