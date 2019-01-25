function habilitaSelect(num){
    var divOpcao;
    if(num === 1){
        divOpcao = window.document.getElementById("selectComputador");
    }else if(num === 2){
        divOpcao = window.document.getElementById("selectManutencao");
    }else if(num === 3){
        divOpcao = window.document.getElementById("selectHistorico");
    }else if(num === 4){
        divOpcao = window.document.getElementById("listaGrafico");
    }
    
    if(divOpcao.style.visibility === "visible"){
        divOpcao.style.visibility = "hidden";
    }else{
        divOpcao.style.visibility = "visible";
    }
}

function escolhaDeTabela(id, opcao){
    
    if(id === 1){
        var divOpcao = window.document.getElementById("opcaoManut");
    }else if(id === 2){
        var divOpcao = window.document.getElementById("opcaoHist");
    }
    
    divOpcao.innerHTML = "";
    switch(opcao){
        case '1':
            var strong = window.document.createElement("strong");
            var input = window.document.createElement("input");
            
            strong.innerHTML = "<br>Etiqueta:&nbsp;";
            input.type = "text";
            input.name = (id === 1)? "etiquetaM" : "etiquetaH";
            
            divOpcao.appendChild(strong);
            divOpcao.appendChild(input);
        break;
        case '2':
            var strong = window.document.createElement("strong");
            var input = window.document.createElement("input");
            
            strong.innerHTML = "<br>Usuário:&nbsp;";
            input.type = "text";
            input.name = (id === 1)? "usuarioM" : "usuarioH";
            
            divOpcao.appendChild(strong);
            divOpcao.appendChild(input);
        break;
        case '3':
            //var strong = window.document.createElement("strong");
            
            //strong.innerHTML = "<br>Departamento:&nbsp;";
            
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState === 4 && this.status === 200) {
                divOpcao.innerHTML = this.responseText;
                //divOpcao.appendChild(strong);
              }
            };
            xhttp.open("GET", "../relatorio/select/selectDepartamento.php?id="+id, true);
            xhttp.send();
        break;
        case '4':
            var input1 = window.document.createElement("input");
            input1.type = "date";
            input1.name = id === 1? "dataEntradaInicialM" : "dataEntradaInicialH";
            
            var input2 = window.document.createElement("input");
            input2.type = "date";
            input2.name = id === 1? "dataEntradaFinalM" : "dataEntradaFinalH";
            
            var strongDe = window.document.createElement("strong");
            var strongAte = window.document.createElement("strong");
            
            strongDe.innerHTML = "<br><br>De:&nbsp";
            strongAte.innerHTML = "<br><br>&nbsp;Até:&nbsp";
            
            divOpcao.appendChild(strongDe);
            divOpcao.appendChild(input1);
            divOpcao.appendChild(strongAte);
            divOpcao.appendChild(input2);
        break;
        case '5':
            var input1 = window.document.createElement("input");
            input1.type = "date";
            input1.name = id ===1? "dataSaidaInicialM" : "dataSaidaInicialH";
            
            var input2 = window.document.createElement("input");
            input2.type = "date";
            input2.name = id === 1? "dataSaidaFinalM" : "dataSaidaFinalH";
            
            var strongDe = window.document.createElement("strong");
            var strongAte = window.document.createElement("strong");
            
            strongDe.innerHTML = "<br><br>De:&nbsp";
            strongAte.innerHTML = "<br><br>&nbsp;Até:&nbsp";
            
            divOpcao.appendChild(strongDe);
            divOpcao.appendChild(input1);
            divOpcao.appendChild(strongAte);
            divOpcao.appendChild(input2);
        break;
    }
}

function inputComputador(opcao){
    var divOpcao = window.document.getElementById("opcaoComp");
    divOpcao.innerHTML = "";
    
    switch(opcao){
        case '1':
            var strong = window.document.createElement("strong");
            var input = window.document.createElement("input");
            
            input.type = "text";
            input.name = "etiquetaC";
            
            strong.innerHTML = "<br>Etiqueta:&nbsp;";
            divOpcao.appendChild(strong);
            divOpcao.appendChild(input);
            break;
        case '2':
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    divOpcao.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "../relatorio/select/selectMarca.php", true);
            xhttp.send();
            break;
        case '3':
            var strong = window.document.createElement("strong");
            var input = window.document.createElement("input");
            
            input.type = "text";
            input.name = "tombo";
            strong.innerHTML = "<br>Tombo:&nbsp;";
            
            divOpcao.appendChild(strong);
            divOpcao.appendChild(input);
            break;
        case '4':
            var strong1 = window.document.createElement("strong");
            var strong2 = window.document.createElement("strong");
            
            var input1 = window.document.createElement("input");
            input1.type = "radio";
            input1.name = "sim";
            input1.value = 1;
            var input2 = window.document.createElement("input");
            input2.type = "radio";
            input2.name = "nao";
            input2.value = 2;
            
            strong1.innerHTML = "Sim:&nbsp;";
            strong2.innerHTML = "<br>Não:&nbsp;";
            
            divOpcao.appendChild(strong1);
            divOpcao.appendChild(input1);
            divOpcao.appendChild(strong2);
            divOpcao.appendChild(input2);
            break;
        case '5':
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    divOpcao.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "../relatorio/select/selectMemoria.php", true);
            xhttp.send();
            break;
        case '6':
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    divOpcao.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "../relatorio/select/selectArmazenamento.php", true);
            xhttp.send();
            break;
        case '7':
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    divOpcao.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "../relatorio/select/selectSO.php", true);
            xhttp.send();
            break;
        case '8':
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    divOpcao.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "../relatorio/select/selectProcessador.php", true);
            xhttp.send();
            break;
        default:
            break;
    }
}

function selecionaTodos(){
    var todos = window.document.getElementById("todos");
    var lista = window.document.getElementById("listaGrafico").getElementsByTagName("INPUT");
    var i;
    
    if(!todos.hasAttribute("checked")){
        for(i = 0; i<lista.length; i++){
            lista[i].setAttribute("checked","true");
        }
    }else{
        for(i = 0; i<lista.length; i++){
            lista[i].removeAttribute("checked");
        }
    }
    
}