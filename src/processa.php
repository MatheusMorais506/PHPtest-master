<?php
	session_start();
	include_once("conexao.php");
	if (empty($_POST[$cep])){
		$_SESSION['vazio_cep'] = "Campo cep é obrigatório";
	}else{
		$_SESSION['value_cep'] = $_POST['cep'];
	}

	$cep = mysqli_real_escape_string($conn, $_POST['cep']);
	$endereco = mysqli_real_escape_string($conn, $_POST['endereco']);
	$bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
	$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
	$estado = mysqli_real_escape_string($conn, $_POST['uf']);
	
	$result_usuario = "INSERT INTO consultacep (
		cep, 
		endereco, 
		bairro, 
		cidade, 
		estado, 
		created) VALUES (
		'$cep', 
		'$endereco', 
		'$bairro', 
		'$cidade', 
		'$estado',  
		NOW())";
		$resultado_usuario = mysqli_query($conn, $result_usuario); 

?>

