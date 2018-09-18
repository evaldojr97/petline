<script>

    function validateNumber(evt) {
        var e = evt || window.event;
        var key = e.keyCode || e.which;

        if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
        // numbers   
        key >= 48 && key <= 57 ||
        // Numeric keypad
        key >= 96 && key <= 105 ||
        // Backspace and Tab and Enter
        key == 8 || key == 9 || key == 13 ||
        // Home and End
        key == 35 || key == 36 ||
        // left and right arrows
        key == 37 || key == 39 ||
        // Del and Ins
        key == 46 || key == 45) {
            // input is VALID
        }
        else {
            // input is INVALID
            e.returnValue = false;
            if (e.preventDefault) e.preventDefault();
        }
    }

</script>

<script type="text/javascript" >
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

</script>

<?php

$pc = 0;

if (isset($_GET['cod'])) {
    
    $pc = 1;
    echo 
    "<html>
        <head>
            <link rel='stylesheet' href='css/bootstrap.min.css'>

            <!-- jQuery library -->
            <script src='http://code.jquery.com/jquery-1.9.1.js'></script>

            <script src='js/valida_form.js?12'></script>
            <script type='text/javascript' src='js/jquery.mask.min.js'></script>

            <!-- Latest compiled JavaScript -->
            <script src='js/bootstrap.min.js'></script>
        </head>
    <body>";

    include "conexao.php";
}else {
    include "cabecalho.php";
}
?>

    <div class="container">

        <div class="col-md-12">

            <div class="page-header">
                <h2>Cadastre-se</h2>
            </div>
<?php
    echo "<form action='cadastra_usuario.php?pc=$pc' method='post' name='cadastro_usuario' id='cadastro_usuario'>";
?>
            <div class="form-row">

                <div class="col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome" maxlength="255" id="nome">
                </div>

                <div class="col-md-6">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" class="form-control" name="sobrenome" maxlength="255" id="sobrenome">
                </div>

            </div>

             <div class="form-group col-md-6">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" id="email" onblur="validacaoEmail(event)" maxlength="60" size='65'>
            </div>

            <div class="form-group col-md-6">
                <label for="dt_nascimento">Data de Nascimento</label>
                <input type="date" class="form-control" name="dt_nascimento" id="dt_nascimento">
            </div>

            <div class="form-group col-md-12">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" name="telefone" maxlength="50" id="telefone" onkeydown="validateNumber(event);" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}">
                <script type="text/javascript">$("#telefone").mask("(00) 00000-0009");</script>
            </div>

            <div class="form-row">

                <div class="col-md-6">
                    <label for="rg">RG</label>
                    <input type="text" class="form-control" name="rg" maxlength="20" id="rg" onkeydown=validateNumber(event); pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}">
                    <script type="text/javascript">$("#rg").mask("00.000.000-9");</script>
                </div>

                <div class="col-md-6">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" name="cpf" size="14" maxlength="11" id="cpf" onkeydown="validateNumber(event);" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}">
                    <script type="text/javascript">$("#cpf").mask("000.000.000-00");</script>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" value="" size="10" maxlength="9"  class="form-control" onkeydown="validateNumber(event);" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" onblur="pesquisacep(this.value);">
                    <script type="text/javascript">$("#cep").mask("00000-000");</script>
                </div>
                <div class="form-group col-md-6">
                    <label for="rua">Rua</label>
                    <input type="text" name="rua" id="rua"  class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" id="bairro"  class="form-control">
                </div>
            </div>

            <div class="form-group col-md-8">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" name="cidade" maxlength="255" id="cidade">
            </div>

            <div class="form-group col-md-4">
                <label for="uf">Estado</label>
                <input type="text" class="form-control" name="uf" maxlength="2" id="uf">
            </div>

            <div class="form-group col-md-12">
                <label for="login">Login</label>
                <input type="text" class="form-control" name="login" maxlength="25" id="login">
            </div>

            <div class="form-group col-md-6">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" maxlength="50" id="senha">
            </div>

            <div class="form-group col-md-6">
                <label for="senha2">Confirme Sua Senha</label>
                <input type="password" class="form-control" name="senha2" maxlength="50" id="senha2">
            </div>

            <div class="form-group col-md-12">
                <label for="perfil">Perfil</label>
                
                <select name="perfil" class="form-control" style="width:15%" id="perfil">
                    <option value="0">Selecione...</option>
                    <option value="cli">Cliente</option>
                    <option value="pas">Passeador</option>
                </select>
            </div>

            <div class="form-row">

                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" id="salvar"> Salvar </button>
                </div>

                <div class="col-md-6" align="right">
                    <a href="index.php" class="btn btn-danger">Cancelar</a>
                </div>

            </div>

        </form>
    </div>

<?php
include "rodape.php";
?>