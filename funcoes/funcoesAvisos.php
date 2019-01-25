<?php

function mostraAviso($flag){
    echo "<script>
            $(document).ready(function(){
                $('#alerta-sucesso').show(function(){
                    $('#alerta-sucesso').fadeIn(1000);
                    $('#alerta-sucesso').delay(4000).fadeOut(1000);
                });
            });
          </script>";
    switch($flag){
        case '1':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                O computador foi cadastrado com sucesso.
            </div>";
            break;
        case '2':
             echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                O registro do computador foi editado com sucesso.
            </div>";
            break;
        case '3':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-warning alerta-sucesso\">
                O registro do computador foi deletado bem como seus possíveis históricos e registros de manutenção.
            </div>";
            break;
        case '4':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                O serviço de manutenção foi cadastrado com sucesso.
            </div>";
            break;
        case '5':
            echo "</script>
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                O serviço de manutenção foi editado com sucesso.
            </div>";
            break;
        case '6':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-warning alerta-sucesso\">
                O serviço de manutenção foi removido; bem como seu registro no histórico.
            </div>";
            break;
        case '7':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                A entrada no histórico da máquina foi cadastrada com sucesso.
            </div>";
            break;
        case '8':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                A entrada no histórico da máquina foi editada com sucesso.
            </div>";
            break;
        case '9':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-warning alerta-sucesso\">
                A entrada no histórico da máquina foi removida.
            </div>";
            break;
        case '10':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-warning alerta-sucesso\">
                Usuário e/ou senha inválidos.
            </div>";
            break;
        case '11':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
                Dados do usuário modificados.
            </div>";
            break;
        case '12':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-warning alerta-sucesso\">
                Usuário removido.
            </div>";
            break;
        case '13':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-danger alerta-sucesso\">
                Usuário inexistente ou não pode ser removido.
            </div>";
            break;
        case '14':
            echo "
            <div id=\"alerta-sucesso\" class=\"alert alert-danger alerta-sucesso\">
                Você não tem autorização para essa ação.
            </div>";
            break;
        default:
            break;
    }
}

function mostraEtiqueta($etiqueta){
    echo "<script>
            $(document).ready(function(){
                $('#alerta-sucesso').show(function(){
                    $('#alerta-sucesso').fadeIn(1000);
                    $('#alerta-sucesso').delay(4000).fadeOut(1000);
                });
            });
          </script>
          <div id=\"alerta-sucesso\" class=\"alert alert-success alerta-sucesso\">
            Computador cadastrado com a etiqueta: <strong>".$_GET['etiqueta']."</strong>
        </div>";
}

