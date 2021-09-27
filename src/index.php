<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Busca de CEP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Consulta no WebService da ViaCep">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-info">

<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<div class="container w-50 p-3">
<form method="post" action="processa.php" id="form" class="form-group col-md-8 offset-md-2 mt-5">
	<h5 class="row text-white">Consulta CEP</h5>
	<div class="row"> 
		<label for="cep" class="text-white h6">CEP</label>
		<input type="text" placeholder="Digite o CEP..." id="cep" name="cep" maxlength="8" 
				class="form-control form-control-sm border border-dark border-top-0 border-right-0 border-left-0 bg-light">
	</div>
	<span id="respAjax" class="bg-success ml-5 mt-5" >
	</span>
	<div class="row">
		<label for="endereco" class="text-white h6" >Endereço</label>
		<input type="text" placeholder="" name="endereco" id="endereco" 
		class="form-control form-control-sm border border-dark border-top-0 border-right-0 border-left-0 bg-light"
		value="" readonly>
	</div>
	<div class="row">
		<label for="bairro" class="text-white h6" >Bairro</label>
		<input type="text" placeholder="" name="bairro" id="bairro" 
		class="form-control form-control-sm border border-dark border-top-0 border-right-0 border-left-0 bg-light"
		value="" readonly>
	</div>
	<div class="row">	
		<label for="cidade" class="text-white h6" >Cidade</label>
		<input type="text" placeholder="" id="cidade" name="cidade" 
		class="form-control form-control-sm border border-dark border-top-0 border-right-0 border-left-0 bg-light"
		value="" readonly>
	</div>
	<div class="row">
		<label for="uf" class="text-white h6" >Estado</label>
		<input disabled type="text" placeholder="" name="uf" id="uf" 
		class="form-control form-control-sm border border-dark border-top-0 border-right-0 border-left-0 bg-light"
		value="" readonly>
	</div>
</form>
</div>
	<p id="nr_end"></p>

<script type="text/javascript">

	document.getElementById('cep').focus();	//Foca no Cep
	document.getElementById('cep').addEventListener('keyup', function() {			

		//Impede inserir algo alem de Números
		this.value = this.value.replace(/[^0-9]/, "");
		let cep = this.value.replace(/[^0-9]/, "");
		
		$(function(){
			$("#cep").keydown(function(){
				let pesquisa = $(this).val();
				if(pesquisa != ''){
					let dados = {
						palavra : pesquisa
				}
			$.post('proc_pesq_user.php', dados, function(retorna){
				//Mostra dentro da ul os resultado obtidos 
				let title = retorna.replace(/li/g,' ').replace(/[<//>]/g,'')
				let title2 = title.split("  ");

				let cep = document.getElementById('cep').value
				let endereco = document.getElementById('endereco')
				let bairro = document.getElementById('bairro')
				let cidade = document.getElementById('cidade')
				let uf = document.getElementById('uf')

				if(endereco.value == "undefined"){
					document.getElementById('respAjax').innerHTML = 'CEP inválido, por favor digite um CEP válido!'
					setTimeout(() => {
						document.getElementById('respAjax').innerHTML = '';
						endereco.value = '';
						bairro.value = '';
						cidade.value = '';
						uf.value = '';
					}, 2500);
				}else{
					
					endereco.value = title2[1]
					bairro.value = title2[2]
					cidade.value = title2[3]
					uf.value = title2[4]
				}
			});
		}
	});
});

		ajax = new XMLHttpRequest();
		var url = "https://viacep.com.br/ws/" + cep + "/xml/";		
		ajax.open('GET', url, true);
		ajax.send();
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4 && ajax.status == 200) {


				var xml = ajax.responseXML;
				console.log(xml)
				var logradouro = xml.getElementsByTagName('logradouro')[0]
				var bairro = xml.getElementsByTagName('bairro')[0]
				var cidade = xml.getElementsByTagName('localidade')[0]
				var uf = xml.getElementsByTagName('uf')[0]
				
				document.getElementById('endereco').value = logradouro.innerHTML;
				document.getElementById('bairro').value = bairro.innerHTML;
				document.getElementById('cidade').value = cidade.innerHTML;
				document.getElementById('uf').value = uf.innerHTML;
				document.getElementById('nr_end').focus();
			}
		}
  	});

	$(function(){
    $('#cep').blur(function(e){
        e.preventDefault();
        var cep = $('#cep').val();
        var endereco = $('#endereco').val();
        var bairro = $('#bairro').val();
        var cidade = $('#cidade').val();
		var uf = $('#uf').val();
        $.post('processa.php', {
            cep:cep,
            endereco:endereco,
            bairro:bairro,
            cidade:cidade,
			uf:uf
        }, function(resposta){
            if(resposta == 1){
                $('input').val('');
            }else {
            }
        });
    });
});
	
</script>
</body>
</html>